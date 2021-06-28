<template>
    <div class=" container alert alert-warning mt-3 h-25 w-100 text-center" v-if="notFound">
        There is no such hotel in our memory.
    </div>
    <div class=" container alert alert-danger mt-3 h-25 w-100 text-center" v-else-if="error">
        Something went wrong. Try again.
    </div>
    <main class="container" v-else>
        <h1>{{ hotel.name }}</h1>

        <div>
            <img :src="apiRootForImages + hotel.image" alt="hotel" class="mb-3"/>
        </div>

        <p>Description: {{ hotel.description }}</p>

        <h3>Weather Forecast on the nearest 7 days at this hotel's area</h3>

        <weather-table :weather7-days-forecast="hotel.weather"></weather-table>

        <router-link
            :to="'/trips?hotel=' + hotel.slug"
            class="btn btn-success"
            >Hotel's trips
        </router-link>
    </main>
</template>

<script>
import WeatherTable from "./WeatherTable";
import { useRoute } from "vue-router";
import { ref } from "vue";

export default {
    setup() {
        const route = useRoute();
        const notFound = ref(false);
        const error = ref(false);
        const hotelId = route.params.slug.match(/\d+$/g)[0];
        const hotelUrl =
            process.env.VUE_APP_API_ROOT_PATH + "/api/hotels/" + hotelId;

        const hotel = ref({});

        const getHotelInfo = async () => {
            const response = await fetch(hotelUrl).catch(() => {error.value = true});
            if (!response) {
                return;
            }
            if (response.status == 404) {
                notFound.value = true;
                return;
            }
            const json = await response.json();
            hotel.value = json.data;

            hotel.value.slug = hotel.value.name.replace(/ /g, '_');
            for (let item of hotel.value.weather) {
                item.morningTemperature =
                    item.morningTemperature < 0
                        ? Math.ceil(item.morningTemperature)
                        : "+" + Math.ceil(item.morningTemperature);
                item.dayTemperature =
                    item.dayTemperature < 0
                        ? Math.ceil(item.dayTemperature)
                        : "+" + Math.ceil(item.dayTemperature);
                item.eveningTemperature =
                    item.eveningTemperature < 0
                        ? Math.ceil(item.eveningTemperature)
                        : "+" + Math.ceil(item.eveningTemperature);
                item.nightTemperature =
                    item.nightTemperature < 0
                        ? Math.ceil(item.nightTemperature)
                        : "+" + Math.ceil(item.nightTemperature);
            }
        };

        getHotelInfo();
        const apiRootForImages =
            process.env.VUE_APP_API_ROOT_PATH + "/storage/";


        return {
            hotel,
            apiRootForImages,
            notFound
        };
    },
    name: "HotelPage",
    components: {
        WeatherTable,
    },
};
</script>

<style scoped></style>
