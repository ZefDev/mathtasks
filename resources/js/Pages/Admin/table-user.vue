<template>
    <table class="table-fixed m-2">
        <thead>
        <tr>
            <th class="w-1/7 ...">ID</th>
            <th class="w-1/5 ...">Name</th>
            <th class="w-1/5 ...">Email</th>
            <th class="w-1/6 ...">Admin</th>
            <th class="w-1/6 ...">Blocked</th>
            <th class="w-1/5 ...">Created At</th>
            <th class="w-1/2 ...">Options</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <input type="checkbox" :checked="user.isAdmin" @click="setAdmin(user.id)">
                </td>
                <td>
                    <input type="checkbox" :checked="user.isBlock" @click="setBlock(user.id)">
                </td>
                <td>{{ user.created_at }}</td>
                <td>
                    <button @click="deleteUser(user.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
    props: ['users'],
    methods:{
        deleteUser(id){
            axios.get(`/admin/users/${id}/delete`)
                .then(response=>{
                    this.$emit('updatetable');
                });
        },
        setAdmin(id){
            axios.get(`/admin/users/${id}/set-admin`)
                .then(response=>{
                    this.$emit('updatetable');
                });
        },
        setBlock(id){
            axios.get(`/admin/users/${id}/set-block`)
                .then(response=>{
                    this.$emit('updatetable');
                });
        }
    },
}
</script>
