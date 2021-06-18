<template>
    <ul class="pagination mt-5">
        <li v-for="n in quantity" :key="n" class="page-item">
            <button class="page-link" @click="changePageListener" :page="n">
                {{ n }}
            </button>
        </li>
    </ul>
</template>

<script>
export default {
    setup (props, { emit }) {
        const changePageListener = (e) => {
            let page = e.target.attributes.page.value;
            emit('changePage',page);
        };
        return {
            changePageListener
        }

    },
    name: "pagination",
    props: ["quantity"]
};
</script>

<style scoped></style>
