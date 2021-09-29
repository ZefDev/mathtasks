<template>
    <div class="ml-4">
        <jet-nav-link :href="route('language', [selectable_locale])">
            <icon class="w-5 h-5" :name="selectable_locale" />
        </jet-nav-link>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import JetNavLink from '@/Jetstream/NavLink.vue'
export default {
    name: "LanguageSelector",
    components: {
        Icon,
        JetNavLink,
    },
    computed: {
        selectable_locale() {
            if(this.$page.props.locale == 'ru') {
                return 'en';
            }
            return 'ru'
        }
    },
}
</script>

<style scoped>
</style>
