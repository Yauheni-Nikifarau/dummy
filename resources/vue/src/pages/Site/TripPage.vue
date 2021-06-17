<template>
    <main class="container">
        <h1>{{ trip.name }}</h1>

        <p>
            Hotel:
            <router-link :to="'/hotels/' + trip.hotel.id"
                >{{ trip.hotel.name }}
            </router-link>
        </p>

        <p>Price: {{ trip.price }}$</p>

        <p>Dates: {{ trip.date_in }} - {{ trip.date_out }}</p>

        <div>
            <img :src="trip.image" alt="hotel" />
        </div>

        <button class="btn btn-outline-success mt-3">BUY</button>
    </main>
</template>

<script>
export default {
    name: "trip-page",
    props: ["trip"],
};
</script>

<style scoped></style>
