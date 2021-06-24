<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>
import { useStore } from "vuex";

export default {
    setup () {
        const store = useStore();
        const checkAuth = () => {
            if (localStorage.getItem('authHeader') && localStorage.getItem('authHeaderExpire')) {
                const now = Math.trunc(Date.now() / 1000);
                if (localStorage.getItem('authHeaderExpire') > now) {
                    store.commit('login');
                }
            }
        };
        checkAuth();
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
