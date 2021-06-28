<template>
    <div class="container d-flex">
        <account-aside></account-aside>
        <router-view @needAuthorization="needAuthorization"></router-view>
    </div>
</template>

<script>
import AccountAside from "../../components/AccountAside";
import { checkAuth } from "../../composables/useCheckAuth";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();
        const needAuthorization = () => {
            router.push({ path: '/login' });
        }
        if (!checkAuth()) {
            needAuthorization();
        }
        return {
            needAuthorization
        }
    },
    name: "account",
    components: {
        AccountAside,
    },
};
</script>

<style scoped></style>
