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

        <button class="btn btn-outline-success mt-3" @click.prevent="buyEvent">
            BUY
        </button>

        <div class="alert alert-success mt-3" v-if="confirmOrder">
            Your order confirmed.
        </div>
    </main>
</template>

<script>
import { useRoute } from "vue-router";
import { reactive, ref } from "vue";

export default {
    setup(props, { emit }) {
        const route = useRoute();
        const tripId = route.params.slug.match(/\d+$/g)[0];
        const tripUrl =
            process.env.VUE_APP_API_ROOT_PATH + "/api/trips/" + tripId;
        const confirmOrder = ref(false);
        const trip = reactive({
            name: "",
            hotelSlug: "",
            hotelName: "",
            price: "",
            dates: "",
            image: "",
        });
        const getTripInfo = async () => {
            const response = await fetch(tripUrl);
            const json = await response.json();
            const data = json.data;
            trip.image =
                process.env.VUE_APP_API_ROOT_PATH + "/storage/" + data.image;
            trip.name = data.name;
            trip.hotelSlug =
                "/hotels/" +
                data.hotel.name.replace(/ /g, "_") +
                "_" +
                data.hotel.id;
            trip.hotelName = data.hotel.name;
            trip.price = data.price;
            trip.dates = data.date_in + " - " + data.date_out;
        };
        getTripInfo();

        const buyEvent = async () => {
            const authHeader = localStorage.getItem("authHeader");
            const authHeaderExpire = localStorage.getItem("authHeaderExpire");
            if (
                !authHeader ||
                !authHeaderExpire ||
                authHeaderExpire < Math.trunc(Date.now() / 1000)
            ) {
                emit('needLoginModal');
                return;
            }
            const buyUrl = process.env.VUE_APP_API_ROOT_PATH + "/api/orders";
            const response = await fetch(buyUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    Accept: "application/json",
                    Authorization: authHeader,
                },
                body: JSON.stringify({
                    trip_id: tripId,
                }),
            });
            const json = await response.json();
            if (json.success === true) {
                confirmOrder.value = true;
            }
        };

        return {
            confirmOrder,
            buyEvent,
            trip,
        };
    },
    name: "trip-page",
};
</script>

<style scoped></style>
