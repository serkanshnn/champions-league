<script setup>
import DefaultLayout from "../DefaultLayout.vue";
import WeekMatches from "./WeekMatches.vue";
import TeamStats from "./TeamStats.vue";
import Estimation from "./Estimation.vue";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import {computed} from "vue";

const props = defineProps({
    stats: {
        type: Array,
        required: true
    },
    matches: {
        type: Array,
        required: true
    },
    estimations: {
        type: Array,
        required: true
    }
});

const tournamentId = computed(() => {
    return props.matches[0].tournament_id;
})

const week = computed(() => {
    return props.matches[0].week;
})

const isMatchPlayed = computed(() => {
    console.log(props.matches)
    return props.matches[0].is_match_played;
})

const playForm = useForm({

})

const playAllForm = useForm({

})

const handlePlayButton = () => {
    playForm.post(route('tournaments.match.playWeek', { tournamentId: tournamentId.value, week: week.value }))
}
const handlePlayAllButton = () => {
    playForm.post(route('tournaments.match.playAll', { tournamentId: tournamentId.value }))
}


</script>

<template>
    <DefaultLayout>
        <div class="flex md:mx-auto flex-col max-w-7xl justify-center mt-10 mx-10">
            <div class="flex flex-col lg:flex-row gap-5 justify-between">
                <TeamStats :stats="stats" />
                <WeekMatches :matches="matches" />
                <Estimation :estimations="estimations" />
            </div>

            <div class="w-full flex justify-between">
                <button v-if="!isMatchPlayed || week !== 6" @click="handlePlayAllButton" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Play All Matches</button>
                <template v-if="!isMatchPlayed || week !== 6">
                    <Link v-if="isMatchPlayed" :href="route('tournaments.match.getMatchListByWeek', { tournamentId: tournamentId, week: week + 1 })" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Next Week</Link>
                    <button v-else @click="handlePlayButton" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Play</button>
                </template>
                <Link v-if="isMatchPlayed && week === 6" :href="route('matches.getMatchListGroupedByWeek', { tournamentId: tournamentId })" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Overview</Link>
                <Link :href="route('tournaments.index')" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Reset</Link>
            </div>
        </div>

    </DefaultLayout>

</template>
