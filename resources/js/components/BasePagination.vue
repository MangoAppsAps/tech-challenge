<template>
    <nav>
        <ul class="pagination">
            <li
                v-for="(link, index) in pagination.links"
                :key="index"
                class="page-item"
                :class="{'disabled': !link.url, 'active': link.active}"
            >
                <span
                    v-if="hasNavigateListener"
                    @click="$emit('navigate', link.url || '#')"
                    class="page-link cursor-pointer"
                    v-html="link.label"></span>
                <a v-else
                   class="page-link"
                   :href="link.url || '#'"
                   v-html="link.label"></a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        pagination: {
            type: Object,
            required: true
        }
    },
    computed: {
        hasNavigateListener() {
            return !!this.$listeners?.navigate;
        }
    }
}
</script>
