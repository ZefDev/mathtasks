<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-white underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-white underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-white underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                <div class="w-full text-center pb-8">
                    <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl font-heading text-gray-400 pb-2">
                        Reviews about MathTasks
                    </h1>

                    <p class="text-gray-400 font-normal text-base">MathTask is a collective effort by its users. They are creators - authoring tasks to teach various techniques, solving tasks  with solutions that enlighten others, and commenting with constructive feedback. The leaders among them moderate the content and community.</p>
                </div>
                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center space-x-6 mb-4">
                            <img class="h-28 w-28 object-cover object-center rounded-full"
                                 src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1170&q=80" alt="photo">
                            <div>
                                <p class="text-xl text-gray-700 font-normal mb-1">Dany Bailey</p>
                                <p class="text-base text-gray-900  font-normal">Software Engineer</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-loose font-normal text-base">You are great fellows, MathTask is a great project! For heaven's sake only, do not stop, improve it, add new content, do not overdo it) those who have the opportunity will always thank you. Even more practice, even more knowledge and experience</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center space-x-6 mb-4">
                            <img class="h-28 w-28 object-cover object-center rounded-full"
                                 src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1170&q=80" alt="photo">
                            <div>
                                <p class="text-xl text-gray-700 font-normal mb-1">Lucy Carter</p>
                                <p class="text-base text-gray-900 font-normal">Graphic Designer</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-loose font-normal text-base">Thank you, MathTask is a great project! Even more practice, even more knowledge and experience, interactively, conveniently, anywhere with the Internet, no matter from a computer, tablet or phone.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center space-x-6 mb-4">
                            <img class="h-28 w-28 object-cover object-center rounded-full"
                                 src="https://images.unsplash.com/photo-1499952127939-9bbf5af6c51c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1176&q=80" alt="photo">
                            <div>
                                <p class="text-xl text-gray-700 font-normal mb-1">Jade Bradley</p>
                                <p class="text-base text-gray-900 font-normal">Dev Ops</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-loose font-normal text-base">A very useful learning resource, especially for beginners. The main thing that I like here is the abundance of practical tasks that allow you to consolidate the material. Many thanks to the site creators!)</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center space-x-6 mb-4">
                            <img class="h-28 w-28 object-cover object-center rounded-full"
                                 src="https://images.unsplash.com/photo-1632715434689-b936361f5789?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=464&q=80" alt="photo">
                            <div>
                                <p class="text-xl text-gray-700 font-normal mb-1">Jack Carter</p>
                                <p class="text-base text-gray-900 font-normal">Graphic Designer</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-loose font-normal text-base">I showed several problem conditions to my friend, a developer with 15 years of experience, who writes in several languages, he said that the conditions here are correct and set correctly !!!! with the summer :))) such things.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center space-x-6 mb-4">
                            <img class="h-28 w-28 object-cover object-center rounded-full"
                                 src="https://images.unsplash.com/photo-1606081461437-108abe922780?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=387&q=80" alt="photo">
                            <div>
                                <p class="text-xl text-gray-700 font-normal mb-1">Elisa Gram</p>
                                <p class="text-base text-gray-900 font-normal">Software Engineer</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-loose font-normal text-base">The project is really useful! It is absolutely correct that the main emphasis is on practical tasks - without them in the head - the wind. And after such a "rocking", the template code itself bounces off the fingers - you begin to believe that something.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center space-x-6 mb-4">
                            <img class="h-28 w-28 object-cover object-center rounded-full"
                                 src="https://images.unsplash.com/photo-1484186139897-d5fc6b908812?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=580&q=80" alt="photo">
                            <div>
                                <p class="text-xl text-gray-700 font-normal mb-1">Rose Brown</p>
                                <p class="text-base text-gray-900 font-normal">Dev Ops</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 leading-loose font-normal text-base">The idea of the project is excellent, it is clear that there are no ideal implementations and you can find something to blame anyone for. But this project is one of the best ideas in the field of training programmers. The project really deserves support.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            Link,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        }
    })
</script>
