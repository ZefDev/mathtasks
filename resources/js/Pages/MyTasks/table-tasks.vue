<template>
    <table class="table-fixed m-2">
        <thead>
        <tr>
            <th class="w-1/6 ...">ID</th>
            <th class="w-1/2 ...">Name</th>
            <th class="w-1/6 ...">Options</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td>{{ task.id }}</td>
                <td>{{ task.name }}</td>

                <td>
                    <a :href="`/mytasks/${task.id}/view`" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        View
                    </a>
                    <a :href="`/mytasks/${task.id}/edit`" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <button @click="deleteTask(task.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
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
