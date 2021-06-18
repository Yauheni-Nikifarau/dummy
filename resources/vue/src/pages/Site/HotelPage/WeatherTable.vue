<template>
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Weather</th>
                <th scope="col">Morning</th>
                <th scope="col">Day</th>
                <th scope="col">Evening</th>
                <th scope="col">Night</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="weather1DayForecast in weather7DaysForecast"
                :key="weather1DayForecast.date"
            >
                <th scope="row">{{ weather1DayForecast.date }}</th>
                <td>{{ weather1DayForecast.weather }}</td>
                <td>{{ weather1DayForecast.morning }}</td>
                <td>{{ weather1DayForecast.day }}</td>
                <td>{{ weather1DayForecast.evening }}</td>
                <td>{{ weather1DayForecast.night }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "weather-table",
    props: ["weather7DaysForecast"],
};
</script>

<style scoped></style>
