<template>
    <select :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="form-select w-50 mb-3" aria-label="Default select example">
        <option selected value="">{{ title }}</option>
        <option v-for="option in options" :key="option.id" :value="option.value">{{ option.name }}</option>
    </select>
</template>

<script>
export default {
    name: "InputSelect",
    props: ['modelValue', 'title', 'options'],
    emits: ['update:modelValue']
}
</script>

<style scoped>

</style>
