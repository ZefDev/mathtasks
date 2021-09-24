<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Task
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

<!--                                <div>-->
<!--                                    <label class="typo__label">Tagging</label>-->
<!--                                    <multiselect v-model="value" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>-->
<!--                                    <pre class="language-json"><code>{{ value  }}</code></pre>-->
<!--                                </div>-->
                                <div class="md:col-span-5">
<!--                                    <answer v-model="answers" :answers="answers"></answer>-->
                                    <div v-for="(answer,index) in answers" :key="index">
                                        <label for="answer{{index}}">Answer{{index}} </label>
                                        <input @keyup="updateAnswer(index,$event.target.value)" :value="answer.name" type="text" name="answer{{index}}" id="answer{{index}}" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                    </div>
                                    <button @click="addAnswer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add answer</button>
                                </div>
                                <div class="md:col-span-5">
                                    <div class="flex justify-center mt-8">
                                        <div class="rounded-lg shadow-xl bg-gray-50 lg:w-1/2">
                                            <div class="m-4">
                                                <label class="inline-block mb-2 text-gray-500">Upload
                                                    Image(jpg,png,svg,jpeg)</label>
                                                <div class="flex items-center justify-center w-full">
                                                    <label class="flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 hover:border-gray-300">
                                                        <div class="flex flex-col items-center justify-center pt-7">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20"
                                                                 fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                      clip-rule="evenodd" />
                                                            </svg>
                                                            <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                                                Select a photo</p>
                                                        </div>
                                                        <input id="file" type="file" class="opacity-0" @change="previewFiles" />
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="flex p-2 space-x-4">
                                                <button class="px-4 py-2 text-white bg-red-500 rounded shadow-xl">Cannel</button>
                                                <button class="px-4 py-2 text-white bg-green-500 rounded shadow-xl">Create</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <button @click="addTask" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
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
import answer from './answer.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import Multiselect from 'vue-multiselect'
import Answer from "./answer";

export default defineComponent({
    components: {
        Answer,
        AppLayout,
        JetResponsiveNavLink,
        JetInput,
        JetInputError,
        JetLabel,
        Multiselect,
    },
    data: function (){
        return{
            users:[],
            themes:[],
            answers:[],
            theme:'',
            condition:'',
            name:''
        }
    },
    methods:{
        previewFiles(event) {
            console.log(event.target.files);
        },
        addAnswer () {
            const answer = {
                name:'new answer',
            }
            this.answers.push(answer);
            console.log(this.answers);
        },
        updateAnswer (index,value) {
            this.answers[index].name = value;
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
        addTask(){
            if (!this.name) {
                return false;
            }
            if (!this.condition) {
                return false;
            }
            let data = new FormData();
            var imagefile = document.querySelector('#file');
            console.log(imagefile.files[0]);
            data.append('file', imagefile.files[0]);
            data.append('name', this.name);
            data.append('condition', this.condition);
            data.append('theme_id', this.theme);
            data.append('answers', JSON.stringify(this.answers));
            data.append('csrfToken', document.getElementsByName('csrf-token')[0].getAttribute('content'));
            // let data = {
            //     name: this.name,
            //     condition:this.condition ,
            //     theme_id:this.theme,
            //     answers: this.answers,
            //     csrfToken : document.getElementsByName('csrf-token')[0].getAttribute('content'),
            // };

            axios.post('/task/create', data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response=>{
                    console.log("add new task");
                    //this.themes = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
        }
    },
    created() {
        this.getTheme();
    }
})
</script>
