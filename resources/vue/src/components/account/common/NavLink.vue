<template>
    <li>
        <router-link :to="link" class="nav-link link-dark">
            {{ title }}
        </router-link>
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
