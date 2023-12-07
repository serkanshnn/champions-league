<script setup>
defineProps({
    matches: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <div>
        <ul role="list" class="w-full min-w-[300px]">
            <li class="overflow-hidden rounded-xl border border-gray-200 shadow">
                <div class="flex items-center gap-x-4 border-b bg-slate-800 border-gray-200 px-6 py-3">
                    <div class="text-md font-medium leading-6 text-white">Week {{matches[0].week}}</div>
                </div>

                <div class="divide-y divide-slate-500">
                    <dl v-for="(match, index) in matches" class="-my-3 px-6 py-4 text-sm leading-6" :key="index">
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
    </div>
</template>

<style scoped>

</style>
