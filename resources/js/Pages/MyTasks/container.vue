<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="dark:bg-gray-800 dark:text-white font-semibold text-xl text-gray-800 leading-tight">
                {{__('My tasks')}}
            </h2>

        </template>

        <div class="py-12">
            <div class="dark:bg-gray-800 dark:text-white max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 dark:text-white bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <p>{{__('Personal achievements')}}</p>
                        <p>{{__('Number of tasks solved')}}: {{solved}}</p>
                        <p>{{__('Number of tasks created')}}: {{created}}</p>
                    </div>
                    <div class="flex">
                        <jet-responsive-nav-link :href="route('new.task')" :active="route().current('mytasks')">
                            {{__('New')}}
                        </jet-responsive-nav-link>
                    </div>
                    <table-task :tasks="tasks" v-on:updatetable="getTask()"></table-task>
<!--                    <pagination :links="tasks.links"></pagination>-->
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
import pagination from "../../Shared/pagination";

export default defineComponent({
    components: {
        AppLayout,
        JetResponsiveNavLink,
        TableTask,
        pagination,
    },
    props: {
        created: 0,
        solved: 0,
    },
    data: function (){
        return{
             tasks:[],
        }
    },
    methods:{
        getTask(){
            axios.get('/task/task-current-user')
                .then(response=>{
                    this.tasks = response.data.tasks;
                    //console.log(response.data);
                })
                .catch(error =>{
                    console.log(error);
                });
        },
    },
    created() {
        //this.getTask()
        //console.log(this.$page.props.tasks);
        this.tasks = this.$page.props.tasks;
    }
})
</script>
