<template>
    <div class="card">
        <form action="#" method="GET" class="m-5" @submit.prevent="filterEvent">

            <div class="row d-flex justify-content-around">
                <div class="col-5">

                    <h4>Hotel</h4>
                    <input type="text" class="form-control w-50 mb-3" v-model="hotel" placeholder="hotel">

                    <h4>Tag</h4>
                    <input-select :options="tagOptions" :model-value="tag" @update:model-value="tag = $event" title="tag"></input-select>

                    <h4>Discount value</h4>
                    <input-select :options="discountValues" :model-value="discount" @update:model-value="discount = $event" title="discount"></input-select>

                    <h4>Price</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <input type="number" class="form-control" v-model="minPrice" placeholder="Min price" aria-label="Min price">
                        </div>
                        <div class="col-auto">
                            <input type="number" class="form-control" v-model="maxPrice" placeholder="Max Price" aria-label="Max Price">
                        </div>
                    </div>

                </div>


                <div class="col-5">

                    <h4 class="mt-3">People</h4>
                    <input-radio :options="peopleQuantities" :model-value="people" @update:model-value="people = $event" name="people"></input-radio>

                    <h4 class="mt-3">Meal</h4>
                    <input-radio :options="mealOptions" :model-value="meal" @update:model-value="meal = $event" name="meal"></input-radio>


                    <h4>Date in</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <input type="date" class="form-control" v-model="minDateIn" placeholder="Min date in" aria-label="Min date in">
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" v-model="maxDateIn" placeholder="Max date in" aria-label="Max date in">
                        </div>
                    </div>

                    <h4>Date out</h4>
                    <div class="row g-3">
                        <div class="col-auto">
                            <input type="date" class="form-control" v-model="minDateOut" placeholder="Min date out" aria-label="Min date out">
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" v-model="maxDateOut" placeholder="Max date out" aria-label="Max date out">
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2" role="group" aria-label="Basic example">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>

        </form>
    </div>
</template>

<script>

import InputSelect from "./InputSelect";
import InputRadio from "./InputRadio";
import {ref} from "vue";

export default {
    name: "trip-filter",

    setup () {
        const apiUrl = process.env.VUE_APP_API_ROOT_PATH + '/api',
            tagsUrl = apiUrl + '/tags',
            discountsUrl = apiUrl + '/discounts';
        const tagOptions = ref([]);
        const discountValues = ref([]);
        const hotel = ref('');
        const tag = ref('');
        const discount = ref('');
        const minPrice = ref('');
        const maxPrice = ref('');
        const people = ref('');
        const meal = ref('');
        const minDateIn = ref('');
        const minDateOut = ref('');
        const maxDateIn = ref('');
        const maxDateOut = ref('');


        const getTagOptions = async () => {
            let response = await fetch(tagsUrl),
                json = await response.json();
            tagOptions.value = json.data;
            tagOptions.value.map(function (item) {
                item.name = item.tag_name;
                item.value = item.tag_name.replace(/ /g, '_');
            });
        }

        const getDiscountsOptions = async () => {
            let response = await fetch(discountsUrl),
                json = await response.json();
            discountValues.value = json.data;
            discountValues.value.map(function (item) {
                item.name = item.value + '%';
            });
        }

        getTagOptions();
        getDiscountsOptions();

        const peopleQuantities = ['1', '2', '3'];
        const mealOptions = ['OB', 'HB', 'FB', 'BB', 'AI'];

        return {
            hotel,
            tagOptions,
            discountValues,
            peopleQuantities,
            mealOptions,
            tag,
            discount,
            minPrice,
            maxPrice,
            people,
            meal,
            minDateIn,
            minDateOut,
            maxDateIn,
            maxDateOut
        }
    },

    components: {
        InputSelect,
        InputRadio
    },

    methods: {
        filterEvent () {
            let queries = {};
            if (this.hotel) {
                queries.hotel = this.hotel;
            }
            if (this.tag) {
                queries.tag = this.tag;
            }
            if (this.discount) {
                queries.discount = this.discount;
            }
            if (this.minPrice) {
                queries.min_price = this.minPrice;
            }
            if (this.maxPrice) {
                queries.max_price = this.maxPrice;
            }
            if (this.people) {
                queries.people = this.people;
            }
            if (this.meal) {
                queries.meal = this.meal;
            }
            if (this.minDateIn) {
                queries.min_date_in = Date.parse(this.minDateIn);
            }
            if (this.minDateOut) {
                queries.min_date_out = Date.parse(this.minDateOut);
            }
            if (this.maxDateIn) {
                queries.max_date_in = Date.parse(this.maxDateIn);
            }
            if (this.maxDateOut) {
                queries.max_date_out = Date.parse(this.maxDateOut);
            }
            let queryString = '';
            for (let key in queries) {
                queryString += `&${key}=${queries[key]}`;
            }
            if (queryString) {
                queryString = queryString.substring(1);
                this.$emit('changeFilter', queryString);
            }
        }
    }
}
</script>

<style scoped>

</style>
