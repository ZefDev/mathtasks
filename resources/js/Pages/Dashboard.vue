<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:bg-gray-800 dark:text-white" >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="dark:bg-gray-800 dark:text-white max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                        <div class="w-full text-center pb-8">
                            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl font-heading text-gray-900 pb-2">
                                Last task
                            </h1>
                        </div>
                        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="task in lastTask" :key="task.id" class="bg-white rounded-lg p-6">
                                <div class="flex items-center space-x-6 mb-4">
                                    <img class="h-28 w-28 object-cover object-center rounded-full"
                                         :src="task.user.profile_photo_path" alt="photo">
                                    <div>
                                        <p class="text-xl text-gray-700 font-normal mb-1">{{task.user.name}}</p>
                                        <p class="text-base text-blue-600 font-normal">{{task.theme.name}}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-400 leading-loose font-normal text-base">{{task.condition.substring(0,255)+".."}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="w-full text-center pb-8">
                            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl font-heading text-gray-900 pb-2">
                                High rating task
                            </h1>
                        </div>
                        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="task in topTask" :key="task.id" class="bg-white rounded-lg p-6">
                                <div class="flex items-center space-x-6 mb-4">
                                    <img class="h-28 w-28 object-cover object-center rounded-full"
                                         :src="task.user.profile_photo_path" alt="photo">
                                    <div>
                                        <p class="text-xl text-gray-700 font-normal mb-1">{{task.user.name}}</p>
                                        <p class="text-base text-blue-600 font-normal">{{task.theme.name}}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-400 leading-loose font-normal text-base">{{task.condition.substring(0,255)+".."}}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        },
        props: {
            lastTask: Array,
            topTask: Array
        },
    })
</script>
