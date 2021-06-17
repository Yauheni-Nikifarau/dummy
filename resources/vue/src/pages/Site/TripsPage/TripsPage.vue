<template>
    <main class="container mt-3 mb-3">
        <trip-filter @changeFilter="getFilteredTrips"></trip-filter>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-2">
            <trip-card-item v-for="trip in trips" :key="trip" :trip="trip">
            </trip-card-item>
        </div>

        <pagination
            :quantity="numberOfPages"
            @changePage="getOtherPage"
        ></pagination>
    </main>
</template>

<script>
import TripFilter from "./TripFilter";
import TripCardItem from "../../../components/TripCardItem";
import Pagination from "../../../components/Pagination";
import {ref} from "vue";

export default {
    setup() {
        const tripsUrl = process.env.VUE_APP_API_ROOT_PATH + "/api/trips";

        const trips = ref([]);
        const numberOfPages = ref(1);
        const currentPage = ref(1);
        const tripsUrlWithParams = ref(tripsUrl);

        const getDataForTripsList = async (url, page) => {
            let urlObj = new URL(url);
            if (urlObj.search) {
                url += "&page=" + page;
            } else {
                url += "?page=" + page;
            }
            const response = await fetch(url);
            const json = await response.json();
            trips.value = json.data;
            numberOfPages.value = Math.ceil(json.message / 9);
        };

        getDataForTripsList(tripsUrl, currentPage);

        const getOtherPage = (page) => {
            getDataForTripsList(tripsUrlWithParams.value, page);
            currentPage.value = page;
        };

        const getFilteredTrips = (query) => {
            currentPage.value = 1;
            let url = tripsUrl + "?" + query;
            tripsUrlWithParams.value = url;
            getDataForTripsList(url, currentPage);
        };

        return {
            tripsUrl,
            tripsUrlWithParams,
            trips,
            numberOfPages,
            getDataForTripsList,
            getOtherPage,
            getFilteredTrips
        };
    },
    components: {
        TripFilter,
        TripCardItem,
        Pagination,
    },
    name: "trips-page",
};
</script>

<style scoped></style>