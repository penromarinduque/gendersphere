<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>List of Committee Positions</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'committeepositions.create' }" class="text-sm font-medium">Add New</router-link>
            </button>
        </div>
    </div>
    
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Position Title</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Status</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actions</span>
                </th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in committeepositions" :key="item.id">
                <tr class="bg-white">
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="">{{ item.position_title }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;" v-if="item.is_active_position==1">Active</span>
                        <span style="text-transform: capitalize;" v-if="item.is_active_position==0">Inactive</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'committeepositions.edit', params: { id: item.id } }" class="inline-flex items-center mr-2 px-2 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        <button @click="deleteCommitteePosition(item.id)" class="inline-flex items-center px-2 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                            Delete</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import useCommitteePositions from '../../composables/committeepositions'
import { onMounted } from 'vue'

const { committeepositions, getCommitteePositions, destroyCommitteePosition } = useCommitteePositions()

const deleteCommitteePosition = async (id) => {
    // console.log(id);
    if (!window.confirm('You sure you want to remove this Attendee from the list?')) {
        return
    }
    await destroyCommitteePosition(id)
    await getCommitteePositions()
}

// We get the companies immediately
onMounted(getCommitteePositions)
</script>