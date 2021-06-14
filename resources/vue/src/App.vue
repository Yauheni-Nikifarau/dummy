<template>
    <div id="app">
        <Header></Header>
        <Main></Main>
        <Footer></Footer>
    </div>
</template>

<script>
import Header from './components/site/common/Header.vue';
import Main from './components/site/common/Main.vue';
import Footer from './components/site/common/Footer.vue'

export default {
  name: 'App',
  components: {
    Header,
    Main,
    Footer
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
