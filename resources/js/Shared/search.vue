<template>
    <div class="rounded shadow-md my-2 relative pin-t pin-l">
        <ul class="list-reset">
            <li class="p-2">
                <input v-model="text" @keyup="getTask" class="text-black border-2 rounded h-8 w-full">
                <br>
            </li>
            <li class="bg-white" v-for="task in tasksSearch" :key="task.id">
                <Link :href="`/mytasks/${task.id}/view`">
                    <p class="p-2 block text-black hover:bg-grey-light cursor-pointer">{{task.id}}.{{task.name}} {{task.raitings_avg_mark}}({{task.raitings_count}})</p>
                </Link>
            </li>
        </ul>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components:{
        Link
    },
    data: function (){
        return{
            text:'',
            tasksSearch:[],
        }
    },
    methods:{
        getTask(){
            if (!this.text){
                this.tasksSearch = [];
                return false;
            }
            let data = {
                csrfToken: document.getElementsByName('csrf-token')[0].getAttribute('content'),
                text : this.text
            }
            axios.post('/search',data)
                .then(response=>{
                    this.tasksSearch = response.data.tasksSearch;
                    console.log(response.data.tasksSearch);
                })
                .catch(error =>{
                    console.log(error);
                });
        }
    },
    created() {

    }
};
</script>
