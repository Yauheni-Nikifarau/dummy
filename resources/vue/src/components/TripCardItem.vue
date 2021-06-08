<template>
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                <img :src="imgSrc" alt="hotel" style="width: 100%; height: 200px; object-fit: cover">
                <h3>{{ title }}</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-primary fw-bold">{{ price }}$</p>
                    <small class="text-warning">{{ dateIn }} - {{ dateOut }}</small>
                    <button class="btn btn-outline-success" href="#">Buy it</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TripCardItem",
    props: ['imgSrc', 'title', 'price', 'dateIn', 'dateOut']
}
</script>

<style scoped>

</style>
