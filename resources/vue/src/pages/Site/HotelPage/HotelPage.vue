<template>
    <main class="container">
        <h1>{{ hotel.name }}</h1>

        <div>
            <img :src="hotel.image" alt="hotel" />
        </div>

        <p>Description: {{ hotel.description }}</p>

        <h3>Weather Forecast on the nearest 7 days at this hotel's area</h3>

        <weather-table :weather="weatherForecast"></weather-table>

        <router-link
            :to="'/trips?hotel=name_' + hotel.id"
            class="btn btn-success"
            >Hotel's trips
        </router-link>
    </main>
</template>

<script>
import WeatherTable from "./WeatherTable";

export default {
    setup() {
        const weatherForecast = [
            {
                date: "1.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "2.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "3.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "4.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "5.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "6.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "7.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
            {
                date: "8.06",
                weather: "Clear sky",
                morning: "+19",
                day: "+22",
                evening: "+20",
                night: "+15",
            },
        ];

        return {
            weatherForecast,
        };
    },
    name: "HotelPage",
    props: ["hotel"],
    components: {
        WeatherTable,
    },
};
</script>

<style scoped></style>
