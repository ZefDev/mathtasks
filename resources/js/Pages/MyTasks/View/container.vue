<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit task
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Personal Details</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                                <div class="md:col-span-5">
                                    <label for="name">Name</label>
                                    <input readonly v-model="name" type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                </div>

                                <div class="md:col-span-5">
                                    <label for="condition">Condition</label>
                                    <textarea readonly v-model="condition" rows="10" type="text" name="condition" id="condition" class="h-30 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                </div>

                                <div class="md:col-span-3">
                                    <label for="tags">Tags</label>
                                    <input readonly type="text" name="tags" id="tags" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                </div>

                                <div class="md:col-span-2">
                                    <label for="theme">Theme</label>
                                    <input v-model="theme" readonly type="text" name="theme" id="theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">

                                </div>

                                 <div class="md:col-span-5">
                                    <div v-for="(image,index) in images" :key="index" class="flex justify-center mt-8" >
                                         <div>
                                            <img :src="image.link" alt="" max-width="300" max-height="400" class="w-11/12">
                                        </div>
                                    </div>
                                 </div>

                                <div class="md:col-span-5">
                                    <label for="answer">Answer</label>
                                    <input v-bind="answer" id="answer" type="text" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                </div>

                                <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <button @click="sendAnswer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send answer</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import Input from "../../../Jetstream/Input";

export default defineComponent({
    components: {
        Input,
        AppLayout,
        JetResponsiveNavLink,
        JetInput,
        JetInputError,
        JetLabel,
    },
    data: function (){
        return{
            themes:[],
            images:[],
            theme:'',
            condition:'',
            name:'',
            answer:'',
            id:0,
        }
    },
    methods:{
        sendAnswer(){

        },
        getTask(id){
            axios.get(`/task/${id}`)
                .then(response=>{
                    this.name = response.data.task.name;
                    this.condition = response.data.task.condition;
                    this.images = response.data.task.images;
                    this.theme =  response.data.task.theme.name;
                    console.log(response.data.task);
                })
                .catch(error =>{
                    console.log(error);
                });
        },
    },
    created() {
        this.id = window.location.pathname.split('/')[2];
        this.getTask(window.location.pathname.split('/')[2]);
    }
})
</script>
