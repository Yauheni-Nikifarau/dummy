<template>
    <div v-for="option in options" :key="option" class="form-check form-check-inline">
        <input class="form-check-input" type="radio" :name="name" :id="'inlineRadio' + option" :value="option">
        <label class="form-check-label" :for="'inlineRadio' + option">{{ option }}</label>
    </div>
</template>

<script>
export default {
    name: "InputRadio",
    props: ['name', 'options']
}
</script>

<style scoped>

</style>
