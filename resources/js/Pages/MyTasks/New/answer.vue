<template>
    <div v-for="(answer,index) in answers" :key="index">
        <label for="answer{{index}}">Answer{{index}} </label>
        <input :value="answer.name" type="text" name="answer{{index}}" id="answer{{index}}" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" >
    </div>
</template>
<script>
export default {
    props: ['answers']
}
</script>
