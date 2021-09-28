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
                                    <div v-show="!taskDone">
                                        <label for="answer">Answer</label>
                                        <input v-model="answer" id="answer" type="text" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                    </div>

                                    <div v-show="taskDone" class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                                        <p class="font-bold">Informational message</p>
                                        <p class="text-sm">Done.</p>
                                    </div>

                                    <div v-show="taskFail" class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                                        <p class="font-bold">Informational message</p>
                                        <p class="text-sm">Answer wrong.</p>
                                    </div>

                                    <div v-show="!taskDone" class="flex justify-end mt-2" >
                                        <div>
                                            <button @click="sendAnswer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send answer</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-5">
                                    <div v-for="(comment,index) in comments" :key="index" class="flex justify-left mt-8" >
                                        <div>
                                            <p>ID #{{comment.user.name}}</p>
                                            <p>{{comment.text}}</p>
                                            <button @click="sendLike(comment.id,true)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Like {{comment.like.length}}</button>
                                            <button @click="sendLike(comment.id,false)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">DisLike {{comment.dislike.length}}</button>
                                        </div>
                                    </div>
                                    <textarea v-model="comment" rows="5" type="text" name="comment" id="comment" class="h-30 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                    <div class="flex justify-end">
                                        <button @click="sendComment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send comment</button>
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
            taskFail:false,
            taskDone:false,
            id:0,
            comment:'',
            comments:[]
        }
    },
    methods:{
        sendLike(id,type_like){
            let data = {
                comment_id : id,
                type_like : type_like,
                csrfToken : document.getElementsByName('csrf-token')[0].getAttribute('content')
            }
            axios.post('/like', data).then(response=>{
                this.getComments(this.id);
            })
            .catch(error =>{
                console.log(error);
            });
        },
        sendComment(){
            if (!this.comment) {
                return false;
            }
            let data = {
                task_id : this.id,
                text : this.comment,
                csrfToken : document.getElementsByName('csrf-token')[0].getAttribute('content')
            }
            axios.post('/comment/create', data).then(response=>{
                this.comment = "";
                this.getComments(this.id);
            })
            .catch(error =>{
                console.log(error);
            });
        },
        sendAnswer(){
            console.log(this.answer);
            if (!this.answer) {
                return false;
            }
            let data = {
                task_id : this.id,
                answer : this.answer,
                csrfToken : document.getElementsByName('csrf-token')[0].getAttribute('content')
            }
            axios.post('/solving/create', data).then(response=>{
                this.reset();
                if (response.data.is_task_solved){
                    this.taskDone = true;
                }else {
                    this.taskFail = true;
                }
                //window.location.href = "/mytasks";
            })
            .catch(error =>{
                console.log(error);
            });
        },
        getTask(id){
            axios.get(`/task/${id}`)
                .then(response=>{
                    this.name = response.data.task.name;
                    this.condition = response.data.task.condition;
                    this.images = response.data.task.images;
                    this.theme =  response.data.task.theme.name;
                    //this.comments =  response.data.task.comments;
                    if (response.data.is_task_solved){
                        this.taskDone = true;
                    }
                    console.log(response.data);
                })
                .catch(error =>{
                    console.log(error);
                });
        },
        getComments(id){
            axios.get(`/comments/${id}`)
                .then(response=>{
                    this.comments =  response.data.comments;
                    console.log(response.data);
                })
                .catch(error =>{
                    console.log(error);
                });
        },
        reset(){
            this.taskDone = false;
            this.taskFail = false;
        }
    },
    created() {
        this.id = window.location.pathname.split('/')[2];
        this.getTask(window.location.pathname.split('/')[2]);
        this.getComments(window.location.pathname.split('/')[2]);
    }
})
</script>
