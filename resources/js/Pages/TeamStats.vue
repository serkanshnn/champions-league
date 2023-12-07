<script setup>
defineProps({
    stats: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <div class="w-full">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300 shadow">
                        <thead class="bg-slate-800">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Team Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">P</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">W</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">D</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">L</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">GD</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">PTS</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="(stat, index) in stats" :key="index">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ stat.name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ stat.played }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ stat.win }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ stat.draw }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ stat.lose }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ stat.goal_difference }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500 font-bold">{{ stat.points }}</td>
                        </tr>

                        <!-- More people... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
