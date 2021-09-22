<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin panel
                <div >привет одмен</div>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table-user :users="users" v-on:updatetable="getUsers()"></table-user>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import TableUser from './table-user.vue'

export default defineComponent({
    components: {
        AppLayout,
        TableUser,
    },
    data: function (){
        return{
            users:[]
        }
    },
    methods:{
        getUsers(){
            axios.get('/admin/users')
            .then(response=>{
                this.users = response.data;
            })
            .catch(error =>{
                console.log(error);
            });
        }
    },
    created() {
        this.getUsers();
    }
})
</script>
