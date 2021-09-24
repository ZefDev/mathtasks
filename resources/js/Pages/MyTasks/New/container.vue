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
                                    <input type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="">
                                </div>

                                <div class="md:col-span-5">
                                    <label for="condition">Condition</label>
                                    <textarea rows="10" type="text" name="condition" id="condition" class="h-30 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder=""/>
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

                                <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
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
//import TableUser from './table-user.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import Multiselect from 'vue-multiselect'

export default defineComponent({
    components: {
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
            theme:''
        }
    },
    methods:{
        newTask(){

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
