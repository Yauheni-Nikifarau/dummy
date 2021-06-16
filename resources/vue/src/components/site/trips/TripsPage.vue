<template>
    <div class="container mt-3 mb-3">

        <trip-filter @changeFilter="getFilteredTrips"></trip-filter>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-2">
            <trip-card-item v-for="trip in trips"
                            :key="trip.id"
                            :trip="trip">
            </trip-card-item>
        </div>

        <pagination :quantity="numberOfPages" @changePage="getOtherPage"></pagination>


    </div>
</template>

<script>
import TripFilter from "./TripFilter";
import TripCardItem from "../common/TripCardItem";
import Pagination from "../common/Pagination";
import {ref} from "vue";
export default {
    setup () {
        const tripsUrl = process.env.VUE_APP_API_ROOT_PATH + '/api/trips';

        const trips = ref([]);
        const numberOfPages = ref(1);
        const page = ref(1);
        const tripsUrlWithParams = ref(tripsUrl)

        const getDataForTripsList = async (url, page) => {
            console.log(url);
            let urlObj = new URL(url);
            if (urlObj.search) {
                url += '&page=' + page;
            } else {
                url += '?page=' + page;
            }
            let response = await fetch(url),
                json = await response.json();
            trips.value = json.data;
            numberOfPages.value = Math.ceil(json.message / 9);
        }

        getDataForTripsList(tripsUrl, page);

        return {
            tripsUrl,
            tripsUrlWithParams,
            trips,
            numberOfPages,
            getDataForTripsList
        }
    },
    components: {
        TripFilter,
        TripCardItem,
        Pagination,
    },
    name: "TripsPage",
    methods: {
        getOtherPage (page) {
            this.getDataForTripsList(this.tripsUrlWithParams, page);
            this.page = page;
        },
        getFilteredTrips (query) {
            this.page = 1;
            let url = this.tripsUrl + '?' + query;
            this.tripsUrlWithParams = url;
            this.getDataForTripsList(url, this.page);
        }
    }
}
</script>

<style scoped>

</style>
