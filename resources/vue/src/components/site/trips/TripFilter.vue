<template>
    <div class="card">
        <form action="#" method="GET" class="m-5" >

            <div class="row d-flex justify-content-around">
                <div class="col-5">

                    <h4>Hotel</h4>
                    <input type="text" class="form-control w-50 mb-3" placeholder="hotel">

                    <h4>Tag</h4>
                    <input-select :options="tagOptions" title="tag"></input-select>

                    <h4>Discount value</h4>
                    <input-select :options="discountValues" title="discount"></input-select>

                    <h4>Price</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <input type="number" class="form-control" placeholder="Min price" aria-label="Min price">
                        </div>
                        <div class="col-auto">
                            <input type="number" class="form-control" placeholder="Max Price" aria-label="Max Price">
                        </div>
                    </div>

                </div>


                <div class="col-5">

                    <h4 class="mt-3">People</h4>
                    <input-radio :options="peopleQuantities" name="people"></input-radio>

                    <h4 class="mt-3">Meal</h4>
                    <input-radio :options="mealOptions" name="meal"></input-radio>


                    <h4>Date in</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <input type="date" class="form-control" placeholder="Min date in" aria-label="Min date in">
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" placeholder="Max date in" aria-label="Max date in">
                        </div>
                    </div>

                    <h4>Date out</h4>
                    <div class="row g-3">
                        <div class="col-auto">
                            <input type="date" class="form-control" placeholder="Min date out" aria-label="Min date out">
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" placeholder="Max date out" aria-label="Max date out">
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

export default {
    name: "trip-filter",

    setup () {
        const tagOptions = [
            {name: 'bbq', value: 'bbq'},
            {name: 'children', value: 'children'},
            {name: 'hot tour', value: 'hot_tour'}
        ];
        const discountValues = [
            {name: '5%', value: 5},
            {name: '15%', value: 15},
            {name: '25%', value: 25}
        ];
        const peopleQuantities = ['1', '2', '3'];
        const mealOptions = ['OB', 'HB', 'FB', 'BB', 'AI'];

        return {
            tagOptions,
            discountValues,
            peopleQuantities,
            mealOptions
        }
    },

    components: {
        InputSelect,
        InputRadio
    }
}
</script>

<style scoped>

</style>
