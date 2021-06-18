<template>
    <div class="container d-flex">
        <account-aside></account-aside>
        <router-view></router-view>
    </div>
</template>

<script>
import AccountAside from "../../components/AccountAside";

export default {
    name: "account",
    components: {
        AccountAside,
    },
};
</script>

<style scoped></style>
