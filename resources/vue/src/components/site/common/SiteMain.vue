<template>
    <main-page v-if="page == 'main'"></main-page>
    <about-page v-if="page == 'about'"></about-page>
    <contacts-page v-if="page == 'contacts'"></contacts-page>
    <hotel-page v-if="page == 'hotel'"></hotel-page>
    <hotels-page v-if="page == 'hotels'"></hotels-page>
    <trip-page v-if="page == 'trip'"></trip-page>
    <trips-page v-if="page == 'trips'"></trips-page>
</template>

<script>
import MainPage from "../main/MainPage";
import AboutPage from "../about/AboutPage";
import ContactsPage from "../contacts/ContactsPage";
import HotelPage from "../hotel/HotelPage";
import HotelsPage from "../hotels/HotelsPage";
import TripPage from "../trip/TripPage";
import TripsPage from "../trips/TripsPage";

export default {
    name: "site-main",
    props: ['page'],
    components: {
        MainPage,
        AboutPage,
        ContactsPage,
        HotelPage,
        HotelsPage,
        TripPage,
        TripsPage
    }
}
</script>

<style scoped>

</style>
