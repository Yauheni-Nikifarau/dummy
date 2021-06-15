<template>
    <aside class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 100vh">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">My profile</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <nav-link v-for="item in menu" :key="item.link" :link="item.link" :title="item.title"></nav-link>
        </ul>
        <hr>
        <router-link to="/" class="nav-link link-dark">To site</router-link>
        <router-link to="/" class="nav-link link-dark">Logout</router-link>
    </aside>
</template>

<script>
import NavLink from "./NavLink";
export default {
    setup () {
        const menu = [
            {link: '/account', title: 'Me'},
            {link: '/account/orders', title: 'My orders'},
            {link: '/account/messages', title: 'My messages'},
        ];
        return {
            menu
        }
    },
    name: "account-aside",
    components: {
        NavLink
    }
}
</script>

<style scoped>

</style>
