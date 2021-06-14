<template>
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                <img :src="hotel.image" alt="hotel" style="width: 100%; height: 200px; object-fit: cover">
                <p class="linkprimary text-decoration-none fw-bolder fs-3">{{ hotel.name }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <a class="btn btn-outline-success" :href="'/hotel/' + hotel.id">More</a>
                    <a class="btn btn-outline-success" :href="'/trips?hotel_id=name_' + hotel.id">Trips</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HotelCardItem",
    props: ['hotel']
}
</script>

<style scoped>

</style>
