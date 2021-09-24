<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="flex">
                        <jet-responsive-nav-link :href="route('new.task')" :active="route().current('mytasks')">
                            New
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link :href="route('new.edit')" :active="route().current('mytasks')">
                            Edit
                        </jet-responsive-nav-link>
                    </div>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
//import TableUser from './table-user.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'

export default defineComponent({
    components: {
        AppLayout,
        JetResponsiveNavLink,
    },
    data: function (){
        return{
            users:[]
        }
    },
    methods:{
        newTask(){

        }
    },
    created() {

    }
})
</script>
