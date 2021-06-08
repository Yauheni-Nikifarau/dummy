<template>
    <main>

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

        <div class="album py-5 bg-light">
            <div class="container">

                <h1 class="mt-5 text-primary ">The latest offers</h1>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <TripCardItem v-for="trip in latestList"
                                  :key="trip.id"
                                  :img-src="apiRootForImages + trip.image"
                                  :title="trip.name"
                                  :price="trip.price"
                                  :date-in="trip.date_in"
                                  :date-out="trip.date_out">
                    </TripCardItem>
                </div>

                <h1 class="mt-5 text-primary">Hot tours</h1>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <TripCardItem v-for="trip in hotList"
                                  :key="trip.id"
                                  :img-src="apiRootForImages + trip.image"
                                  :title="trip.name"
                                  :price="trip.price"
                                  :date-in="trip.date_in"
                                  :date-out="trip.date_out">
                    </TripCardItem>
                </div>

                <h1 class="mt-5 text-primary">35% off</h1>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <TripCardItem v-for="trip in offList"
                                  :key="trip.id"
                                  :img-src="apiRootForImages + trip.image"
                                  :title="trip.name"
                                  :price="trip.price"
                                  :date-in="trip.date_in"
                                  :date-out="trip.date_out">
                    </TripCardItem>
                </div>
            </div>
        </div>

    </main>
</template>

<script>
import TripCardItem from './TripCardItem.vue';

const tripsUrl = process.env.VUE_APP_API_ROOT_PATH + '/api/trips',
    latestListUrl = tripsUrl + '?order=created_at&direction=desc&limit=3',
    hotListUrl = tripsUrl + '?tag=hot_tour&order=created_at&direction=desc&limit=3',
    offListUrl = tripsUrl + '?discount=35&order=created_at&direction=desc&limit=3';


export default {
    name: "Main",
    data() {
        return {
            latestList: [],
            hotList: [],
            offList: [],
            apiRootForImages: process.env.VUE_APP_API_ROOT_PATH + '/storage/'
        }
    },
    components: {
        TripCardItem
    },
    created() {
        this.getLatestList();
        this.getHotList();
        this.getOffList();
    },
    methods: {
        getLatestList: function () {
            fetch(latestListUrl)
                .then(response => response.json())
                .then(json => {
                    this.latestList = json.data;
                });
        },
        getHotList: function () {
            fetch(hotListUrl)
                .then(response => response.json())
                .then(json => {
                    this.hotList = json.data;
                });
        },
        getOffList: function () {
            fetch(offListUrl)
                .then(response => response.json())
                .then(json => {
                    this.offList = json.data;
                });
        }
    }
}
</script>

<style scoped>
    .carousel-item img {
        height: 400px;
        object-fit: cover;
    }
</style>
