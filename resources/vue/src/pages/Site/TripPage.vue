<template>
    <main class="container">
        <h1>{{ trip.name }}</h1>

        <p>
            Hotel:
            <router-link :to="trip.hotelSlug"
                >{{ trip.hotelName }}
            </router-link>
        </p>

        <p>Price: {{ trip.price }}$</p>

        <p>Dates: {{ trip.dates }}</p>

        <div>
            <img :src="trip.image" alt="hotel" />
        </div>

        <button class="btn btn-outline-success mt-3">BUY</button>
    </main>
</template>

<script>
import {useRoute} from "vue-router";
import {reactive} from "vue";

export default {
    setup () {
        const route = useRoute();
        const tripId = route.params.slug.match(/\d+$/g)[0];
        const tripUrl =
            process.env.VUE_APP_API_ROOT_PATH + "/api/trips/" + tripId;
        const trip = reactive({
            name: '',
            hotelSlug: '',
            hotelName: '',
            price: '',
            dates: '',
            image: ''
        });
        const getTripInfo = async () => {
            const response = await fetch(tripUrl);
            const json = await response.json();
            const data = json.data;
            trip.image = process.env.VUE_APP_API_ROOT_PATH + "/storage/" + data.image;
            trip.name = data.name;
            trip.hotelSlug = '/hotels/' + data.hotel.name.replace(/ /g, '_') + '_' + data.hotel.id;
            trip.hotelName = data.hotel.name;
            trip.price = data.price;
            trip.dates = data.date_in + ' - ' + data.date_out;
        };
        getTripInfo();

        return {
            trip
        }
    },
    name: "trip-page"
};
</script>

<style scoped></style>
