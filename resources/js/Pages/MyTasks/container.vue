<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="dark:bg-gray-800 dark:text-white font-semibold text-xl text-gray-800 leading-tight">
                My tasks
            </h2>

        </template>

        <div class="py-12">
            <div class="dark:bg-gray-800 dark:text-white max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 dark:text-white bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <p>Personal achievements</p>
                        <p>Number of tasks solved: {{solved}}</p>
                        <p>Number of tasks created: {{created}}</p>
                    </div>
                    <div class="flex">
                        <jet-responsive-nav-link :href="route('new.task')" :active="route().current('mytasks')">
                            New
                        </jet-responsive-nav-link>
                    </div>
                    <table-task :tasks="tasks" v-on:updatetable="getTask()"></table-task>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import TableTask from './table-tasks.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'

export default defineComponent({
    components: {
        AppLayout,
        JetResponsiveNavLink,
        TableTask,
    },
    data: function (){
        return{
            tasks:[],
            created: 0,
            solved: 0,
        }
    },
    methods:{
        getTask(){
            axios.get('/task/task-current-user')
                .then(response=>{
                    this.tasks = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
        },
        getAchievements(){
            axios.get('/task/achievements-user')
                .then(response=>{
                    console.log(response.data);
                    this.created = response.data.created;
                    this.solved = response.data.solved;
                })
                .catch(error =>{
                    console.log(error);
                });
        }
    },
    created() {
        this.getTask();
        this.getAchievements();
    }
})
</script>
