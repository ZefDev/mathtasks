<template>
    <table class="table-fixed m-2 dark:bg-gray-800 dark:text-white">
        <thead>
        <tr>
            <th class="w-1/7 ...">ID</th>
            <th class="w-1/5 ...">{{__('Name')}}</th>
            <th class="w-1/5 ...">{{__('Email')}}</th>
            <th class="w-1/6 ...">{{__('Admin title')}}</th>
            <th class="w-1/6 ...">{{__('Blocked')}}</th>
            <th class="w-1/5 ...">{{__('Created At')}}</th>
            <th class="w-1/2 ...">{{__('Options')}}</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td class="align-middle">{{ user.id }}</td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 whitespace-nowrap p-4 text-left flex items-center">
                    <img class="h-14 w-14 object-cover object-center rounded-full" :src="user.profile_photo_path" alt="photo">
                    <span class="ml-3"> {{ user.name }} </span>
                </td>
                <td class="text-center">{{ user.email }}</td>
                <td class="text-center">
                    <input type="checkbox" :checked="user.isAdmin" @click="setAdmin(user.id)">
                </td>
                <td class="text-center">
                    <input type="checkbox" :checked="user.isBlock" @click="setBlock(user.id)">
                </td>
                <td class="text-center">{{ user.created_at }}</td>
                <td>
                    <button @click="deleteUser(user.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        {{__('Delete')}}
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
