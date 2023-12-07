<script setup>
defineProps({
    estimations: {
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
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Champions Prodictions</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">%</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="estimation in estimations">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ estimation.name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-bold">{{ estimation.percent.toFixed(2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
