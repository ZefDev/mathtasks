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
                                    <input required v-model="name" type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                </div>

                                <div class="md:col-span-5">
                                    <label for="condition">Condition</label>
                                    <textarea required v-model="condition" rows="10" type="text" name="condition" id="condition" class="h-30 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                </div>

                                <div class="md:col-span-3">
                                    <label for="tags">Tags</label>
                                    <input type="text" name="tags" id="tags" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="theme">Theme</label>
                                    <select v-model="theme" name="theme" id="theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                        <option v-for="item in themes" v-bind:value="item.name">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="md:col-span-5">
                                    <!--                                    <answer v-model="answers" :answers="answers"></answer>-->
                                    <div v-for="(answer,index) in answers" :key="index">
                                        <input @keyup="updateAnswer(index,$event.target.value)" :value="answer.answer" type="text" name="answer{{index}}" id="answer{{index}}" class="h-10 border mt-1 rounded px-4 w-3/4 bg-gray-50" >
                                        <button @click="deleteAnswer(answer.id,index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">X</button>
                                    </div>
                                    <br>
                                    <button @click="addAnswer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add answer</button>
                                </div>
                                 <div class="md:col-span-5">
                                    <!--                                    <answer v-model="answers" :answers="answers"></answer>-->
                                    <div v-for="(image,index) in images" :key="index" class="flex justify-center mt-8" >
                                         <div >
                                            <img :src="image.link" alt=""  max-width="300" max-height="400">
                                            <button @click="deleteImage(image.id,index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">X</button>
                                        </div>
                                    </div>
                                 </div>
                                <div class="md:col-span-5">
                                    <div class="form-group">
                                        <label for="file">Select Image</label>
                                        <input type="file" accept="image/*" multiple="multiple" @change="previewMultiImage" class="form-control-file" id="file">
                                        <button @click="reset" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Clear All</button>
                                        <div class="border p-2 mt-3">
                                            <p>Preview Here:</p>
                                            <div v-if="preview_list.length">
                                                <div v-for="(item, index) in preview_list" :key="index">
                                                    <img :src="item" class="img-fluid" />
                                                    <p class="mb-0">file name: {{ image_list[index].name }}</p>
                                                    <p>size: {{ image_list[index].size/1024 }}KB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <button @click="updateTask(id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
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
            answers:[],
            theme:'',
            condition:'',
            name:'',
            id:0,
            preview_list: [],
            image_list: []
        }
    },
    methods:{
        deleteImage(id,index){
            axios.get(`/image/delete/${id}`)
                .then(response=>{
                    this.images.splice(index, 1);
                });
        },
        deleteAnswer(id,index){
            this.answers.splice(index, 1);
            axios.get(`/answer/delete/${id}`)
                .then(response=>{
                });
        },
        previewMultiImage(event) {
            var input = event.target;
            var count = input.files.length;
            var index = 0;
            if (input.files) {
                while(count --) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview_list.push(e.target.result);
                    }
                    this.image_list.push(input.files[index]);
                    reader.readAsDataURL(input.files[index]);
                    index ++;
                }
            }
        },
        reset() {
            this.image_list = [];
            this.preview_list = [];
        },
        addAnswer () {
            const answer = {
                answer:'new answer',
            }
            this.answers.push(answer);
            console.log(this.answers);
        },
        updateAnswer (index,value) {
            this.answers[index].answer = value;
        },
        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
        },
        getTheme(){
            axios.get('/theme')
                .then(response=>{
                    this.themes = response.data;
                    this.theme = this.themes[0];
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
                    this.answers = response.data.task.answers;
                    this.images = response.data.task.images;
                    this.theme =  response.data.task.theme.name;
                    console.log(response.data.task);
                })
                .catch(error =>{
                    console.log(error);
                });
        },
        updateTask(id){
            if (!this.name) {
                return false;
            }
            if (!this.condition) {
                return false;
            }

            let data = new FormData();
            //var imagefile = document.querySelector('#file');
            let filesLength=document.getElementById('file').files.length;
            for(var i=0;i<filesLength;i++){
                data.append("file[]", document.getElementById('file').files[i]);
            }

            data.append('name', this.name);
            data.append('condition', this.condition);
            data.append('theme_id', this.theme);
            data.append('answers', JSON.stringify(this.answers));
            data.append('csrfToken', document.getElementsByName('csrf-token')[0].getAttribute('content'));

            axios.post(`/task/update/${id}`, data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response=>{
                window.location.href = "/mytasks";
            })
                .catch(error =>{
                    console.log(error);
                });
        }
    },
    created() {
        this.getTheme();
        this.id = window.location.pathname.split('/')[2];
        this.getTask(window.location.pathname.split('/')[2]);
    }
})
</script>
