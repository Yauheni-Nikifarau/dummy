<template>
    <li>
        <a :href="link" class="nav-link link-dark">
            {{ title }}
        </a>
    </li>
</template>

<script>
export default {
    name: "nav-link",
    props: ['link', 'title']
}
</script>

<style scoped>

</style>
