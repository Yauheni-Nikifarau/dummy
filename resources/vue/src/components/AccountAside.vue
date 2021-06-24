<template>
    <aside
        class="d-flex flex-column flex-shrink-0 p-3 bg-light"
        style="width: 280px; height: 100vh"
    >
        <router-link
            to="/"
            class="
                d-flex
                align-items-center
                mb-3 mb-md-0
                me-md-auto
                link-dark
                text-decoration-none
            "
        >
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4">My profile</span>
        </router-link>
        <hr />
        <ul class="nav nav-pills flex-column mb-auto">
            <li v-for="item in menu" :key="item.link">
                <router-link :to="item.link" class="nav-link link-dark">
                    {{ item.title }}
                </router-link>
            </li>
        </ul>
        <hr />
        <router-link to="/" class="nav-link link-dark">To site</router-link>
        <router-link to="/" class="nav-link link-dark" @click.="logoutEvent">Logout</router-link>
    </aside>
</template>

<script>
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import {logout} from "../composables/useLogout";

export default {
    setup() {
        const menu = [
            { link: "/account", title: "Me" },
            { link: "/account/orders", title: "My orders" },
            { link: "/account/messages", title: "My messages" },
        ];
        const router = useRouter();
        const store = useStore();
        const logoutEvent = () => {
            logout();
            store.commit('logout');
            router.push({ path: '/' });
        }
        return {
            menu,
            logoutEvent
        };
    },
    name: "account-aside",
};
</script>

<style scoped></style>
