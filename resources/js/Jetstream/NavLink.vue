<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'dark:bg-white-800 dark:border-white-800 dark:text-white inline-flex items-center px-1 pt-1 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition'
                    : 'dark:bg-white-800 dark:border-white-800 dark:text-white inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 dark:text-white-500 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition'
            }
        }
    }) //border-transparent
</script>
