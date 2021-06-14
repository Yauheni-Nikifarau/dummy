<template>
    <div class="container mt-3 mb-3">

        <trip-filter></trip-filter>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-2">
            <trip-card-item v-for="trip in trips"
                            :key="trip.id"
                            :trip="trip">
            </trip-card-item>
        </div>

        <pagination :quantity="pages"></pagination>


    </div>
</template>

<script>
import TripFilter from "./TripFilter";
import TripCardItem from "../common/TripCardItem";
import Pagination from "../common/Pagination";
export default {
    setup () {
        const trips = [];
        const pages = 5;
        return {
            trips,
            pages
        }
    },
    components: {
        TripFilter,
        TripCardItem,
        Pagination
    },
    name: "TripsPage",
}
</script>

<style scoped>

</style>
