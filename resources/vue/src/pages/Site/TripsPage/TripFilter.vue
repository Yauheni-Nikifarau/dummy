<template>
    <div class="card">
        <form
            action="#"
            method="GET"
            class="m-5"
            @submit.prevent="filterEvent"
            @reset="resetFilterEvent"
        >
            <div class="row d-flex justify-content-around">
                <div class="col-5">
                    <h4>Hotel</h4>
                    <input
                        type="text"
                        class="form-control w-50 mb-3"
                        v-model="filterOptions.hotel"
                        placeholder="hotel"
                    />

                    <h4>Tag</h4>
                    <input-select
                        :options="tagOptions"
                        :model-value="filterOptions.tag"
                        @update:model-value="filterOptions.tag = $event"
                        title="tag"
                    ></input-select>

                    <h4>Discount value</h4>
                    <input-select
                        :options="discountValues"
                        :model-value="filterOptions.discount"
                        @update:model-value="filterOptions.discount = $event"
                        title="discount"
                    ></input-select>

                    <h4>Price</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <input
                                type="number"
                                class="form-control"
                                v-model="filterOptions.minPrice"
                                placeholder="Min price"
                                aria-label="Min price"
                            />
                        </div>
                        <div class="col-auto">
                            <input
                                type="number"
                                class="form-control"
                                v-model="filterOptions.maxPrice"
                                placeholder="Max Price"
                                aria-label="Max Price"
                            />
                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <h4 class="mt-3">People</h4>
                    <input-radio
                        :options="peopleQuantities"
                        :model-value="filterOptions.people"
                        @update:model-value="filterOptions.people = $event"
                        name="people"
                    ></input-radio>

                    <h4 class="mt-3">Meal</h4>
                    <input-radio
                        :options="mealOptions"
                        :model-value="filterOptions.meal"
                        @update:model-value="filterOptions.meal = $event"
                        name="meal"
                    ></input-radio>

                    <h4>Date in</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <input
                                type="date"
                                class="form-control"
                                v-model="filterOptions.minDateIn"
                                placeholder="Min date in"
                                aria-label="Min date in"
                            />
                        </div>
                        <div class="col-auto">
                            <input
                                type="date"
                                class="form-control"
                                v-model="filterOptions.maxDateIn"
                                placeholder="Max date in"
                                aria-label="Max date in"
                            />
                        </div>
                    </div>

                    <h4>Date out</h4>
                    <div class="row g-3">
                        <div class="col-auto">
                            <input
                                type="date"
                                class="form-control"
                                v-model="filterOptions.minDateOut"
                                placeholder="Min date out"
                                aria-label="Min date out"
                            />
                        </div>
                        <div class="col-auto">
                            <input
                                type="date"
                                class="form-control"
                                v-model="filterOptions.maxDateOut"
                                placeholder="Max date out"
                                aria-label="Max date out"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="d-grid gap-2 d-md-flex justify-content-md-end mt-2"
                role="group"
                aria-label="Basic example"
            >
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</template>

<script>
import InputSelect from "./InputSelect";
import InputRadio from "./InputRadio";
import { ref, reactive } from "vue";
import { useRoute } from "vue-router";
import { buildQuery } from "../../../composables/useFilterOptions";

export default {
    name: "trip-filter",

    setup(props, { emit }) {
        const apiUrl = process.env.VUE_APP_API_ROOT_PATH + "/api",
            tagsUrl = apiUrl + "/tags",
            discountsUrl = apiUrl + "/discounts";

        const tagOptions = ref([]);
        const discountValues = ref([]);

        const filterOptions = reactive({
            hotel: "",
            tag: "",
            discount: "",
            minPrice: "",
            maxPrice: "",
            people: "",
            meal: "",
            minDateIn: "",
            minDateOut: "",
            maxDateIn: "",
            maxDateOut: "",
        });

        const route = useRoute();
        if (route.query) {
            for (let key in route.query) {
                if (key in filterOptions) {
                    filterOptions[key] = route.query[key];
                }
            }
        }

        const getTagOptions = async () => {
            const response = await fetch(tagsUrl);
            const json = await response.json();
            tagOptions.value = json.data;
            tagOptions.value.map(function (item) {
                item.name = item.tag_name;
                item.value = item.tag_name.replace(/ /g, "_");
            });
        };

        const getDiscountsOptions = async () => {
            const response = await fetch(discountsUrl);
            const json = await response.json();
            discountValues.value = json.data;
            discountValues.value.map(function (item) {
                item.name = item.value + "%";
            });
        };

        getTagOptions();
        getDiscountsOptions();

        const peopleQuantities = ["1", "2", "3"];
        const mealOptions = ["OB", "HB", "FB", "BB", "AI"];

        const filterEvent = () => {
            const queryString = buildQuery(filterOptions);
            emit("changeFilter", queryString);
        };

        const resetFilterEvent = () => {
            emit("resetFilter");
        };

        return {
            tagOptions,
            discountValues,
            peopleQuantities,
            mealOptions,
            filterOptions,
            filterEvent,
            resetFilterEvent,
        };
    },

    components: {
        InputSelect,
        InputRadio,
    },
};
</script>

<style scoped></style>
