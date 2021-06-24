<template>
    <div class="container d-flex">
        <account-aside></account-aside>
        <router-view></router-view>
    </div>
</template>

<script>
import AccountAside from "../../components/AccountAside";
import { checkAuth } from "../../composables/useCheckAuth";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();
        if (!checkAuth()) {
            router.push({ path: '/login' });
        }
    },
    name: "account",
    components: {
        AccountAside,
    },
};
</script>

<style scoped></style>
