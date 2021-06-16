<template>
    <ul class="pagination mt-5">
        <li v-for="n in quantity" :key="n" class="page-item">
            <button class="page-link" @click="changePageListener" :page="n">{{ n }}</button>
        </li>
    </ul>
</template>

<script>
export default {
    name: "Pagination",
    props: ['quantity'],
    methods: {
        changePageListener (e) {
            let page = e.target.attributes.page.value;
            this.$emit('changePage', page);
        }
    }
}
</script>

<style scoped>

</style>
