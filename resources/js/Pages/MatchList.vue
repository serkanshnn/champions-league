<script setup>

import DefaultLayout from "../DefaultLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'
import {computed} from "vue";

const props = defineProps({
    weekMatches: {
        type: Array,
        required: true
    }
})

const tournamentId = computed(() => {
    return props.weekMatches[0][0].tournament_id;
})

</script>

<template>
    <DefaultLayout>

        <div class="max-w-7xl md:mx-auto mt-10 mx-10">
            <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                <li class="overflow-hidden rounded-xl border border-slate-900" v-for="(weekMatch, index) in weekMatches" :key="index">
                    <div class="flex items-center gap-x-4 border-b bg-slate-800 border-slate-900 p-6">
                        <div class="text-md font-medium leading-6 text-white">{{weekMatch[0].week}} Week</div>
                    </div>

                    <div class="divide-y divide-slate-500">
                        <dl v-for="(match, index) in weekMatch" class="-my-3 px-6 py-4 text-sm leading-6" :key="index">
                            <div class="flex justify-between gap-x-4 py-3">
                                <dt class="text-gray-500 flex gap-3">
                                    <span>{{ match.home_team }}</span>
                                    <span class="font-bold" v-if="match.is_match_played">{{ match.home_team_goals }} - {{ match.away_team_goals }}</span>
                                    <span class="font-bold" v-else> - </span>
                                    <span>{{ match.away_team }}</span>
                                </dt>
                            </div>
                        </dl>
                    </div>
                </li>
            </ul>

            <div class="w-full flex justify-end">
                <Link :href="route('tournaments.match.getMatchListByWeek', { tournamentId: tournamentId, week: 1 })" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Start Simulation</Link>
            </div>
        </div>

    </DefaultLayout>
</template>

<style scoped>

</style>
