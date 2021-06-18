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
                <td class="text-capitalize">{{ weather1DayForecast.weatherFull }}</td>
                <td>{{ weather1DayForecast.morningTemperature }}</td>
                <td>{{ weather1DayForecast.dayTemperature }}</td>
                <td>{{ weather1DayForecast.eveningTemperature }}</td>
                <td>{{ weather1DayForecast.nightTemperature }}</td>
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
