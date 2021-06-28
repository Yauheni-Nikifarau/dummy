<template>
    <h1 class="mt-5 text-primary">{{ title }}</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class=" container alert alert-danger mt-3 h-25 w-100 text-center" v-if="list.error">
            Something went wrong. Try again.
        </div>
        <div class=" container alert alert-warning mt-3 h-25 w-100 text-center" v-else-if="list.empty">
            Sorry, but such trips are sold out.
        </div>
        <trip-card-item v-else v-for="trip in list.list" :key="trip.id" :trip="trip">
        </trip-card-item>
    </div>
</template>

<script>
import TripCardItem from "../../../components/TripCardItem";

export default {
    name: "trips-group",
    components: {
        TripCardItem,
    },
    props: {
        title: String,
        list: Array,
    },
};
</script>

<style scoped></style>
