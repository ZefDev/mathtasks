<template>
    <table class="table-fixed m-2 dark:bg-gray-800 dark:text-white">
        <thead>
        <tr>
            <th class="w-1/6 ...">ID</th>
            <th class="w-1/3 ...">{{__('Name')}}</th>
            <th class="w-1/3 ...">{{__('Rating')}}</th>
            <th class="w-1/3 ...">{{__('Options')}}</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td class="text-center p-4">{{ task.id }}</td>
                <td class="text-center">{{ task.name }}</td>
                <td class="text-center"><span  v-if="task.raitings_avg_mark !== null">{{task.raitings_avg_mark.substr(0, 4)}}</span>({{task.raitings_count}})</td>
                <td class="text-center">
                    <a :href="`/mytasks/${task.id}/view`" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{__('View')}}
                    </a>
                    <a :href="`/mytasks/${task.id}/edit`" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{__('Edit')}}
                    </a>
                    <a @click="deleteTask(task.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        {{__('Delete')}}
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    props: ['tasks'],
    methods:{
        deleteTask(id){
            axios.get(`/task/delete/${id}`)
                .then(response=>{
                    this.$emit('updatetable');
                });
        }
    },
}
</script>
