<template>
    <main class="container">
        <h1>Hotels</h1>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <hotel-card-item v-for="hotel in hotels" :key="hotel.id" :hotel="hotel"></hotel-card-item>
        </div>

        <pagination :quantity="pages"></pagination>
    </main>
</template>

<script>
import Pagination from "../common/Pagination";
import HotelCardItem from "./HotelCardItem";
export default {
    setup () {
        const pages = 5;
        const hotels = [];
        return {
            pages,
            hotels
        }
    },
    components: {
        Pagination,
        HotelCardItem
    },
    name: "hotels-page"
}
</script>

<style scoped>

</style>
