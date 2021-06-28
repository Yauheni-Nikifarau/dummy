<template>
    <div class=" container alert alert-warning mt-3 h-25 w-100 text-center" v-if="notFound">
        There is no such trip in our memory.
    </div>
    <div class=" container alert alert-danger mt-3 h-25 w-100 text-center" v-else-if="error">
        Something went wrong. Try again.
    </div>
    <main class="container" v-else>
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
        const notFound = ref(false);
        const error = ref(false);
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
            const response = await fetch(tripUrl).catch(() => {error.value = true});
            if (!response) {
                return;
            }
            if (response.status == 404) {
                notFound.value = true;
                return;
            }
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
            console.log(json);
            if (json.success === true) {
                confirmOrder.value = true;
            }
        };

        return {
            confirmOrder,
            buyEvent,
            trip,
            notFound,
            error
        };
    },
    name: "trip-page",
};
</script>

<style scoped></style>
