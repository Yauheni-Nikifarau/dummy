<template>
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                <img :src="apiRootForImages + trip.image" alt="hotel">
                <h3>{{ trip.name }}</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-primary fw-bold">{{ trip.price }}$</p>
                    <small class="text-warning">{{ trip.date_in }} - {{ trip.date_out }}</small>
                    <button class="btn btn-outline-success" href="#">Buy it</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    setup () {
        return {
            apiRootForImages: process.env.VUE_APP_API_ROOT_PATH + '/storage/'
        }
    },
    name: "trip-card-item",
    props: {
        trip: Object
    }
}
</script>

<style scoped>
    .card-body img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
</style>
