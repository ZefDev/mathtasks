<template>
    <div v-if="links.length > 3" class="w-full text-center p-6">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
<!--            <a href="#" aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">-->
<!--                1-->
<!--            </a>-->
            <Link v-for="(link,k) in links" :key="k" v-html="link.label" :href="link.url"
                  :disabled="link.url === null"
                  :class="{'z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium':link.active,
                  'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium':link.url === null}"
                  class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">

            </Link>
        </nav>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components:{
        Link
    },
    props:{
        links: Array,
    }
};
</script>
