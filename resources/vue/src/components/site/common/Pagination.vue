<template>
    <ul class="pagination mt-5">
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li v-for="n in quantity" class="page-item"><a class="page-link" href="#">{{ n }}</a></li>
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    name: "Pagination",
    props: ['quantity']
}
</script>

<style scoped>

</style>
