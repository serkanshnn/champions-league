<script setup>
import DefaultLayout from "../DefaultLayout.vue";
import {useForm} from "@inertiajs/inertia-vue3";

defineProps({
    teams: {
        type: Array,
        required: true
    }
});

const date = new Date();
const day = date.getDate();
const month = date.getMonth();
const year = date.getFullYear();
const hour = date.getHours();
const minutes = date.getMinutes();
const seconds = date.getSeconds();

const form = useForm({ name: `Tournament ${day}/${month}/${year} ${hour}:${minutes}:${seconds}`})

const handleStartTournament = () => {
    form.post(route('tournaments.store'));
}

</script>

<template>
    <DefaultLayout>
        <div class="max-w-7xl md:mx-auto mt-10 mx-10">
            <div class="md:flex md:items-center md:justify-between bg-slate-800 px-10 py-5 rounded-lg">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">Teams</h2>
                </div>
            </div>



            <ul role="list" class="divide-y divide-gray-100 gap-2 mt-2 flex flex-col w-full">
                <li v-for="(team, index) in teams" class="flex justify-between gap-x-6 py-5 bg-slate-200 rounded-lg pl-5" :key="index">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-xl font-semibold leading-6 text-gray-900">{{ team.name }}</p>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="w-full flex justify-end">
                <button @click="handleStartTournament" type="button" class="mt-4 inline-flex items-center rounded-md bg-slate-800 px-3 py-2 text-md font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Start Tournament</button>
            </div>

        </div>
    </DefaultLayout>

</template>
