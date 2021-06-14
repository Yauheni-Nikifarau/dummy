<template>
    <select class="form-select w-50 mb-3" aria-label="Default select example">
        <option selected>{{ title }}</option>
        <option v-for="option in options" :key="option.id" :value="option.value">{{ option.name }}</option>
    </select>
</template>

<script>
export default {
    name: "InputSelect",
    props: ['title', 'options']
}
</script>

<style scoped>

</style>
