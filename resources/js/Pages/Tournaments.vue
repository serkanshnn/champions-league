<script setup>

import DefaultLayout from "../DefaultLayout.vue";
import {Link} from "@inertiajs/inertia-vue3";

defineProps({
    tournaments: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <DefaultLayout>
        <div class="max-w-7xl md:mx-auto mx-10 mt-10">
            <div class="flex justify-end mb-3">
                <Link :href="route('home')" class="inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Start Tournament</Link>
            </div>
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 shadow">
                            <thead class="bg-slate-800">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Tournaments</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="tournament in tournaments">
                                <td class="flex items-center justify-between py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    <p>{{ tournament.name }}</p>
                                    <Link :href="route('tournaments.match.getMatchListByWeek', { tournamentId: tournament.id, week: 1 })" class="inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Overview</Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
