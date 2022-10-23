<template>
    <main class="container">
        <h1>Hotels</h1>


        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class=" container alert alert-danger mt-3 h-25 w-100 text-center" v-if="error">
                Something went wrong. Try again.
            </div>
            <hotel-card-item
                v-else
                v-for="hotel in hotelsList"
                :key="hotel.id"
                :hotel="hotel"
            ></hotel-card-item>
        </div>

        <pagination v-show="numberOfPages > 1"
            :quantity="numberOfPages"
            @changePage="getOtherPage"
        ></pagination>
    </main>
</template>

<script>
import Pagination from "../../../components/Pagination";
import HotelCardItem from "./HotelCardItem";
import { ref } from "vue";

export default {
    setup() {
        const hotelsUrl = process.env.VUE_APP_API_ROOT_PATH + "/api/hotels";
        const error = ref(false);
        const currentPage = ref(1);
        const numberOfPages = ref(1);
        const hotelsList = ref([]);

        const getOtherPage = (page) => {
            currentPage.value = page;
            getHotelsForHotelsList();
        };

        const getHotelsForHotelsList = async () => {
            const url = `${hotelsUrl}?page=${currentPage.value}`;
            const response = await fetch(url).catch(() => {error.value = true});
            if (!response || response.status != 200) {
                error.value = true;
                return;
            }
            const json = await response.json();
            hotelsList.value = json.data;
            if ( ! hotelsList.value.length) {
                error.value = true;
                return;
            }
            numberOfPages.value = Math.ceil(json.message / 9);
        };

        getHotelsForHotelsList();

        return {
            numberOfPages,
            hotelsList,
            getOtherPage,
            error
        };
    },
    components: {
        Pagination,
        HotelCardItem,
    },
    name: "hotels-page",
};
</script>

<style scoped></style>
