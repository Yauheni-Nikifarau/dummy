<template>
    <h1 class="mt-5 text-primary">{{ title }}</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <trip-card-item v-for="trip in list"
                      :key="trip.id"
                      :trip="trip">
        </trip-card-item>
    </div>
</template>

<script>
import TripCardItem from '../common/TripCardItem.vue';
export default {
    name: "trips-group",
    components: {
        TripCardItem
    },
    props: {
        title: String,
        list: Array
    }
}
</script>

<style scoped>

</style>
