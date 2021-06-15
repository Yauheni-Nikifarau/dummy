<template>
    <div id="app">
        <site v-if="site"></site>
        <account v-else></account>
    </div>
</template>

<script>
import Site from "./components/site/common/Site";
import Account from "./components/account/common/Account";

export default {
    setup () {
        const site = true;
        return {
            site
        }
    },
    name: 'App',
    components: {
        Site,
        Account
    }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
