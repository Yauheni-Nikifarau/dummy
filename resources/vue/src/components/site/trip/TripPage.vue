<template>
    <div class="container">
        <h1>{{ trip.name }}</h1>

        <p>Hotel: <a :href="'/hotels/' + trip.hotel.id">{{ trip.hotel.name }}</a></p>

        <p>Price: {{ trip.price }}$</p>

        <p>Dates: {{ trip.date_in }} - {{ trip.date_out }}</p>

        <div>
            <img :src="trip.image" alt="hotel">
        </div>

        <a href="#" class="btn btn-outline-success mt-3">BUY</a>
    </div>
</template>

<script>
export default {
    name: "TripPage",
    props: ['trip']
}
</script>

<style scoped>

</style>
