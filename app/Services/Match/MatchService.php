<?php

namespace App\Services\Match;

use App\Http\Resources\MatchResource;
use App\Repositories\Match\MatchRepositoryInterface;
use App\Services\BaseService;
use App\Services\Team\TeamServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

//@TODO: refactor
class MatchService extends BaseService implements MatchServiceInterface
{
    protected TeamServiceInterface $teamService;
    public function __construct(MatchRepositoryInterface $repository, TeamServiceInterface $teamService)
    {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->teamService = $teamService;
    }

    public function generateFixture($tournamentId): array
    {
        $teams = $this->teamService->all();

        return $this->schedule($teams->toArray(), $tournamentId);
    }

    private function schedule(array $teams, int $tournamentId): array
    {
        $teamCount = count($teams);
        $halfTeamCount = $teamCount / 2;
        $schedule = [];
        for ($round = 1; $round <= 6; $round += 1) {
            foreach ($teams as $key => $team) {
                if ($key >= $halfTeamCount) {
                    break;
                }
                $team1 = $team;
                $team2 = $teams[$key + $halfTeamCount];
                //Home-away swapping
                if ($round % 2 === 0) {
                    $matchup = [$team1, $team2];

                    $this->repository->create([
                        'home_team_id' => $team1['id'],
                        'away_team_id' => $team2['id'],
                        'week' => $round,
                        'tournament_id' => $tournamentId
                    ]);
                } else {
                    $matchup = [$team2, $team1];

                    $this->repository->create([
                        'home_team_id' => $team2['id'],
                        'away_team_id' => $team1['id'],
                        'week' => $round,
                        'tournament_id' => $tournamentId
                    ]);
                }
                $schedule[$round][] = $matchup;
            }
            $this->rotate($teams);
        }

        return $schedule;
    }

    private function rotate(array &$items)
    {
        $itemCount = count($items);
        if ($itemCount < 3) {
            return;
        }
        $lastIndex = $itemCount - 1;
        $factor = (int)($itemCount % 2 === 0 ? $itemCount / 2 : ($itemCount / 2) + 1);
        $topRightIndex = $factor - 1;
        $topRightItem = $items[$topRightIndex];
        $bottomLeftIndex = $factor;
        $bottomLeftItem = $items[$bottomLeftIndex];
        for ($i = $topRightIndex; $i > 0; $i -= 1) {
            $items[$i] = $items[$i - 1];
        }
        for ($i = $bottomLeftIndex; $i < $lastIndex; $i += 1) {
            $items[$i] = $items[$i + 1];
        }
        $items[1] = $bottomLeftItem;
        $items[$lastIndex] = $topRightItem;
    }

    public function getMatchListGroupedByWeek($tournamentId): array
    {
        $matches = $this->repository->allBy(['tournament_id' => $tournamentId]);

        $weeks = [];

        foreach ($matches as $match) {
            $weeks[$match->week - 1][] = new MatchResource($match);
        }

        return $weeks;
    }

    public function getStatsByTeams($tournamentId, $week): array
    {
        $teams = $this->teamService->all();
        $teamWithStats = [];

        foreach ($teams as $team) {
            $teamWithStats[] = $this->getStatsByTeam($team, $tournamentId, $week);
        }

        return $teamWithStats;
    }

    private function getStatsByTeam($team, $tournamentId, $week): Model
    {
        $matches = $this->repository->allMatchesPlayedBy($team->id, $tournamentId, $week);

        $played = count($matches);
        $win = 0;
        $draw = 0;
        $lose = 0;
        $goalDifference = 0;
        $points = 0;

        foreach ($matches as $match) {
            if ($match->home_team_goals === $match->away_team_goals) {
                $draw += 1;
                $points += 1;
            }

            if ($match->home_team_id === $team->id) {
                $goalDifference += $match->home_team_goals;
                $goalDifference -= $match->away_team_goals;

                if ($match->home_team_goals > $match->away_team_goals) {
                    $win += 1;
                    $points += 3;
                }

                if ($match->home_team_goals < $match->away_team_goals) {
                    $lose += 1;
                }
            } else {
                $goalDifference -= $match->home_team_goals;
                $goalDifference += $match->away_team_goals;

                if ($match->home_team_goals < $match->away_team_goals) {
                    $win += 1;
                    $points += 3;
                }

                if ($match->home_team_goals > $match->away_team_goals) {
                    $lose += 1;
                }
            }
        }
        $temp = $team;

        $temp->played = $played;
        $temp->win = $win;
        $temp->draw = $draw;
        $temp->lose = $lose;
        $temp->goal_difference = $goalDifference;
        $temp->points = $points;

        return $temp;
    }

    public function playAll(int $tournamentId): bool
    {
        $matches = $this->repository->allBy(['tournament_id' => $tournamentId, 'is_match_played' => false]);

        foreach ($matches as $match) {
            $this->playMatch($match->id, $match->week);
        }

        return true;
    }

    public function playWeek(int $tournamentId, $week): bool
    {
        $matches = $this->repository->allBy(['tournament_id' => $tournamentId, 'week' => $week, 'is_match_played' => false]);

        foreach ($matches as $match) {
            $this->playMatch($match->id, $week);
        }

        return true;
    }

    /**
     * %25 win
     * %25 lose
     * %50 draw
     *
     * 50 power + 3*2 = 56
     * 50 power - 3*2 = 44
     *
     * win bonus = 3
     * lose bonus = 3
     * draw bonus = 2
     * goal difference = 0.25
     *
     * 50 + 3 * 2 + 9 * 0.25 = 58,25 ~ 56,9682151589
     * 50 - 3 * 2 + 0 * 0.25 = 44 ~ 43,0317848411
     *
     * 32,4137499999 daha güçlü
     * 32,4137499999/6 = 5,4022916666
     *
     *  win + 3*5,4022916666 = 25 + 5,4022916666*3 = 41,2068749998
     *  draw - 2*5,4022916666 = 50 - 5,4022916666*2 = 39,1954166668
     *  lose - 1*5,4022916666 = 25 - 5,4022916666 = 19,5977083334
     *
     *
     * %150 daha güçlü
     * %27 daha güçlü
     * 27/6 = 4,5
     *
     * win + 3*4,5 = 13,5 + 25 = 38,5
     * draw - 2*4,5 = 9 - 50 = 41
     * lose - 1*4,5 = 4,5 - 25 = 20,5
     *
     *
     *
     *  %25 win
     *  %25 lose
     *  %50 draw
     *
     *  50 power + 3*2 = 56
     *  50 power - 3*2 = 44
     *
     *  %27 daha güçlü
     *  27/6 = 4,5
     *
     *  win + 3*4,5 = 13,5 + 25 = 38,5
     *  draw - 2*4,5 = 9 - 50 = 41
     *  lose - 1*4,5 = 4,5 - 25 = 20,5
     *
     *
     *
     *
     */
    public function playMatch($matchId, $week): array
    {
        $defaultTeamPower = 50;
        $defaultWinRate = 25;
        $defaultLoseRate = 25;

        $match = $this->repository->find($matchId);

        $firstTeamStats = $this->getStatsByTeam($match->homeTeam, $match->tournament_id, $week);
        $secondTeamStats = $this->getStatsByTeam($match->awayTeam, $match->tournament_id, $week);


        $firstTeamPower = $defaultTeamPower + $firstTeamStats->win * 3 - $firstTeamStats->lose * 3 + $firstTeamStats->draw * 1 + $firstTeamStats->goal_difference * 0.5;
        $secondTeamPower = $defaultTeamPower + $secondTeamStats->win * 3 - $secondTeamStats->lose * 3 + $secondTeamStats->draw * 1 + $secondTeamStats->goal_difference * 0.5;

        $normalizedFirstTeamPower = ($firstTeamPower * 100) / ($firstTeamPower + $secondTeamPower);
        $normalizedSecondTeamPower = ($secondTeamPower * 100) / ($firstTeamPower + $secondTeamPower);

        if ($normalizedFirstTeamPower > $normalizedSecondTeamPower) {
            $powerDifference = (($normalizedFirstTeamPower - $normalizedSecondTeamPower) * 100 / $normalizedFirstTeamPower);
        } else {
            $powerDifference = (($normalizedSecondTeamPower - $normalizedFirstTeamPower) * 100 / $normalizedSecondTeamPower);
        }

        $rate = $powerDifference / 6;

        $winRate = $defaultWinRate + $rate * 3;
        $loseRate = $defaultLoseRate - $rate;

        $homeGoal = 0;
        $awayGoal = 0;

        for ($i = 0; $i < 15; $i++) {
            $firstTeamRand = (float)rand() / (float)getrandmax();
            $secondTeamRand = (float)rand() / (float)getrandmax();
            if ($firstTeamRand < $winRate / 500) $homeGoal++;
            if ($secondTeamRand < $loseRate / 500) $awayGoal++;
        }

        $this->repository->update($matchId, [
            'home_team_goals' => $homeGoal,
            'away_team_goals' => $awayGoal,
            'is_match_played' => true
        ]);

        return [
            'home' => $homeGoal,
            'away' => $awayGoal
        ];
    }

    public function winEstimation(int $tournamentId, $week): array
    {
        $matches = $this->repository->allBy(['tournament_id' => $tournamentId]);
        $teams = $this->teamService->all();

        $teamIds = $teams->pluck('id')->toArray();
        $teamPoints = array_combine($teamIds, [0,0,0,0]);

        $unplayedMatches = [];
        $unplayedCount = 0;
        foreach ($matches as $match) {
            if ($match->is_match_played) {
                if ($match->home_team_goals > $match->away_team_goals) {
                    $teamPoints[$match->home_team_id] += 3;
                }

                if ($match->home_team_goals === $match->away_team_goals) {
                    $teamPoints[$match->home_team_id] += 1;
                    $teamPoints[$match->away_team_id] += 1;
                }

                if ($match->away_team_goals > $match->home_team_goals) {
                    $teamPoints[$match->away_team_id] += 3;
                }
            } else {
                $unplayedCount++;
            }

            $unplayedMatches[$match->week][] = $match->toArray();
        }
        $computedWeek = $unplayedCount > 0 && $week > 1 ? $week - 1: $week;

        $tempPoints = [];
        for ($i = $computedWeek; $i < 6; $i++) {
            for ($j = $computedWeek; $j < 6; $j++) {
                for ($k = 0; $k < 3; $k++) {
                    for ($l = 0; $l < 3; $l++) {
                        if (empty($tempPoints[$j][$k][$l])) {
                            $tempPoints[$j][$k][$l] = $teamPoints;
                        }

                        if ($k === 0) {
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][0]['home_team_id']] += 3;
                        } else if ($k === 1) {
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][0]['home_team_id']] += 1;
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][0]['away_team_id']] += 1;
                        } else {
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][0]['away_team_id']] += 3;
                        }

                        if ($l === 0) {
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][1]['home_team_id']] += 3;
                        } else if ($l === 1) {
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][1]['home_team_id']] += 1;
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][1]['away_team_id']] += 1;
                        } else {
                            $tempPoints[$j][$k][$l][$unplayedMatches[$j][1]['away_team_id']] += 3;
                        }
                    }
                }
            }
        }

        $teamWins = array_combine($teamIds, [0,0,0,0]);
        foreach ($tempPoints ? Arr::flatten($tempPoints, 2): [$teamPoints] as $item)
        {
            foreach (array_keys($item, max($item)) as $key) {
                $teamWins[$key] += 1;
            }
        }

        $totalCount = array_sum($teamWins);

        return array_map(function ($id, $team) use ($totalCount, $teams) {
            return [
                'name' => $teams->where('id', $id)->first()->name,
                'percent' => $totalCount ? $team*100 / $totalCount: 0
            ];
        }, array_keys($teamWins), $teamWins);
    }
}
