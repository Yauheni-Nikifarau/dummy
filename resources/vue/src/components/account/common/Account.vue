<template>
    <div class="container d-flex">
        <account-aside></account-aside>
        <account-main></account-main>
    </div>
</template>

<script>
import AccountAside from "./AccountAside";
import AccountMain from "./AccountMain";

export default {
    name: "account",
    components: {
        AccountAside,
        AccountMain
    }
}
</script>

<style scoped>

</style>
