<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>
import { useStore } from "vuex";
import { checkAuth } from "./composables/useCheckAuth";

export default {
    setup () {
        const store = useStore();
        if (checkAuth()) {
            store.commit('login');
        } else {
            store.commit('logout');
        }
    },
    name: 'App',
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
