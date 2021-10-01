<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="dark:bg-gray-800 dark:text-white font-semibold text-xl text-gray-800 leading-tight">
                {{__('Admin')}}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 dark:text-white bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
    props: {
        //users: Array,
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
        //this.getUsers();
        this.users = this.$page.props.users;
    }
})
</script>
