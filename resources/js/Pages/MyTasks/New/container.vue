<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="dark:bg-gray-800 dark:text-white font-semibold text-xl text-gray-800 leading-tight">
                {{__('New Task')}}
            </h2>
        </template>

        <div class="py-12 dark:bg-gray-800 dark:text-white">
            <div class="dark:bg-gray-800 dark:text-white max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 dark:text-white bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                    <div class="dark:bg-gray-800 dark:text-white grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="dark:bg-gray-800 dark:text-white text-gray-600">
                            <p class="font-medium text-lg">{{__('Task Details')}}</p>
                            <p>{{__('Please fill out all the fields')}}.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                                <div class="md:col-span-5">
                                    <label for="name">{{__('Name')}}</label>
                                    <input required v-model="name" type="text" name="name" id="name" class="dark:bg-gray-800 dark:text-white h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                </div>

                                <div class="md:col-span-5">
                                    <label for="condition">{{__('Condition')}}</label>
                                    <textarea required v-model="condition" rows="10" type="text" name="condition" id="condition" class="dark:bg-gray-800 dark:text-white h-30 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                </div>

                                <div class="md:col-span-3">
                                    <label for="tags">{{__('Tags')}}</label>
                                    <input type="text" name="tags" id="tags" class="dark:bg-gray-800 dark:text-white h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="theme">{{__('Theme')}}</label>
                                    <select v-model="theme" name="theme" id="theme" class="dark:bg-gray-800 dark:text-white h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                        <option v-for="item in themes" v-bind:value="item.id">
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
                                        <label for="answer{{index}}">{{__('Answer')}} </label>
                                        <input @keyup="updateAnswer(index,$event.target.value)" :value="answer.name" type="text" name="answer{{index}}" id="answer{{index}}" class="dark:bg-gray-800 dark:text-white h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
                                    </div>
                                    <button @click="addAnswer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('Add answer')}}</button>
                                </div>
                                <div class="md:col-span-5">
                                    <div class="form-group">
                                        <label for="file">{{__('Select Image')}}</label>
                                        <input type="file" accept="image/*" multiple="multiple" @change="previewMultiImage" class="form-control-file" id="file">
                                        <button @click="reset" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">{{__('Clear All')}}</button>
                                        <div class="border p-2 mt-3">
                                            <p>{{__('Preview Here')}}:</p>
                                            <div v-if="preview_list.length">
                                                <div v-for="(item, index) in preview_list" :key="index">
                                                    <img :src="item" class="img-fluid" />
                                                    <p class="mb-0">{{__('file name')}}: {{ image_list[index].name }}</p>
                                                    <p>{{__('size')}}: {{ image_list[index].size/1024 }}KB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <button @click="addTask" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('Create')}}</button>
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
            name:'',
            preview_list: [],
            image_list: []
        }
    },
    methods:{
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
        // getTheme(){
        //     axios.get('/theme')
        //         .then(response=>{
        //             this.themes = response.data;
        //             this.theme = this.themes[0];
        //         })
        //         .catch(error =>{
        //             console.log(error);
        //         });
        // },
        addTask(){
            if (!this.name) {
                return false;
            }
            if (!this.condition) {
                return false;
            }
            let data = new FormData();
            let filesLength=document.getElementById('file').files.length;
            for(var i=0;i<filesLength;i++){
                data.append("file[]", document.getElementById('file').files[i]);
            }
            data.append('name', this.name);
            data.append('condition', this.condition);
            data.append('theme_id', this.theme);
            data.append('answers', JSON.stringify(this.answers));
            data.append('csrfToken', document.getElementsByName('csrf-token')[0].getAttribute('content'));

            axios.post('/task/create', data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response=>{
                    console.log(response.data);
                    window.location.href = "/mytasks";
                })
                .catch(error =>{
                    console.log(error);
                });
        }
    },
    created() {
        this.themes = this.$page.props.themes;
        this.theme = this.themes[0];
    }
})
</script>
