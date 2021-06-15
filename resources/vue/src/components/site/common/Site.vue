<template>
    <div>
        <site-header></site-header>
        <site-main></site-main>
        <site-footer></site-footer>
    </div>
</template>

<script>
import SiteHeader from "./SiteHeader";
import SiteMain from "./SiteMain";
import SiteFooter from "./SiteFooter";
export default {
    name: "site",
    components: {
        SiteHeader,
        SiteMain,
        SiteFooter
    }
}
</script>

<style scoped>

</style>
