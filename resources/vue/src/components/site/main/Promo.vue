<template>
    <section class="py-2 text-center container position-relative">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/img/firstslide.jpg" class="d-block w-100" alt="slide">
                </div>
                <div class="carousel-item">
                    <img src="/img/secondslide.jpg" class="d-block w-100" alt="slide">
                </div>
                <div class="carousel-item">
                    <img src="/img/thirdslide.jpeg" class="d-block w-100" alt="slide">
                </div>
            </div>
        </div>
        <div class="position-absolute top-50 start-50 translate-middle fw-bold fs-1 text-light">
            <p>Buy our trips</p>
            <a class="btn btn-outline-success fw-bold fs-1 text-light" href="#">Explore trips</a>
        </div>
    </section>
</template>

<script>
export default {
    name: "promo"
}
</script>

<style scoped>
    .carousel-item img {
        height: 400px;
        object-fit: cover;
    }
</style>
