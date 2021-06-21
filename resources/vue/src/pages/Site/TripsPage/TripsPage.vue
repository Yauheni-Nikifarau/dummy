<template>
    <main class="container mt-3 mb-3">
        <trip-filter @changeFilter="getFilteredTrips" @resetFilter="resetFilteredResults"></trip-filter>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-2">
            <trip-card-item v-for="trip in trips" :key="trip" :trip="trip">
            </trip-card-item>
        </div>

        <pagination v-show="numberOfPages > 1"
            :quantity="numberOfPages"
            @changePage="getOtherPage"
        ></pagination>
    </main>
</template>

<script>
import TripFilter from "./TripFilter";
import TripCardItem from "../../../components/TripCardItem";
import Pagination from "../../../components/Pagination";
import { ref } from "vue";
import { useRoute } from "vue-router";

export default {
    setup() {
        const tripsUrl = process.env.VUE_APP_API_ROOT_PATH + "/api/trips";

        const trips = ref([]);
        const numberOfPages = ref(1);
        const currentPage = ref(1);
        const tripsUrlWithParams = ref(tripsUrl);

        const route = useRoute();
        if (route.query) {
            let queryString = "";
            for (let key in route.query) {
                queryString += `&${key}=${route.query[key]}`;
            }
            queryString = queryString.substring(1);
            tripsUrlWithParams.value += '?' + queryString;
        }

        const getDataForTripsList = async (url, page) => {
            const urlObj = new URL(url);
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

        getDataForTripsList(tripsUrlWithParams.value, currentPage.value);

        const getOtherPage = (page) => {
            getDataForTripsList(tripsUrlWithParams.value, page);
            currentPage.value = page;
        };

        const getFilteredTrips = (query) => {
            history.pushState(null, "", location.href.split("?")[0]);
            currentPage.value = 1;
            const url = tripsUrl + "?" + query;
            tripsUrlWithParams.value = url;
            getDataForTripsList(url, currentPage.value);
        };

        const resetFilteredResults = () => {
            history.pushState(null, "", location.href.split("?")[0]);
            tripsUrlWithParams.value = tripsUrl
            currentPage.value = 1;
            getDataForTripsList(tripsUrlWithParams.value, currentPage.value);
        }

        return {
            tripsUrl,
            tripsUrlWithParams,
            trips,
            numberOfPages,
            getDataForTripsList,
            getOtherPage,
            getFilteredTrips,
            resetFilteredResults
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
