<template>
    <main>
        <promo></promo>
        <div class="album py-5 bg-light">
            <div class="container">
                <trips-group
                    title="The latest offers"
                    :list="latestList"
                ></trips-group>
                <trips-group title="Hot tours" :list="hotList"></trips-group>
                <trips-group title="35% off" :list="offList"></trips-group>
            </div>
        </div>
    </main>
</template>

<script>
import TripsGroup from "./TripsGroup.vue";
import Promo from "./Promo.vue";
import { reactive } from "vue";

export default {
    setup() {
        const tripsUrl = process.env.VUE_APP_API_ROOT_PATH + "/api/trips",
            latestListUrl =
                tripsUrl + "?order=created_at&direction=desc&limit=3",
            hotListUrl =
                tripsUrl +
                "?tag=hot_tour&order=created_at&direction=desc&limit=3",
            offListUrl =
                tripsUrl +
                "?discount=35&order=created_at&direction=desc&limit=3";

        const latestList = reactive({
                list: [],
                error: false,
                empty: false,
            }),
            hotList = reactive({
                list: [],
                error: false,
                empty: false,
            }),
            offList = reactive({
                list: [],
                error: false,
                empty: false,
            });

        const getTrips = async (url, variable) => {
            const response = await fetch(url).catch(() => {variable.error = true});
            if(!response || response.status != 200) {
                variable.error = true;
            }
            const json = await response.json();
            variable.list = json.data;
            if(variable.list.length == 0) {
                variable.empty = true;
            }
        };
        getTrips(latestListUrl, latestList);
        getTrips(hotListUrl, hotList);
        getTrips(offListUrl, offList);

        return {
            latestList,
            hotList,
            offList,
        };
    },

    components: {
        Promo,
        TripsGroup,
    },

    name: "main-page",
};
</script>

<style scoped></style>
