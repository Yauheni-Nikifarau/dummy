<template>
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                <img :src="apiRootForImages + trip.image" alt="hotel" />
                <router-link :to="'/trips/' + trip.name.replace(/ /g, '_') + '_' + trip.id" class="fs-3 text-decoration-none">{{ trip.name }}</router-link>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-primary fw-bold">{{ trip.price }}$</p>
                    <small class="text-warning"
                        >{{ trip.date_in }} - {{ trip.date_out }}</small
                    >
                    <button class="btn btn-outline-success">Buy it</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    setup() {
        return {
            apiRootForImages: process.env.VUE_APP_API_ROOT_PATH + "/storage/",
        };
    },
    name: "trip-card-item",
    props: {
        trip: Object,
    },
};
</script>

<style scoped>
.card-body img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
</style>
