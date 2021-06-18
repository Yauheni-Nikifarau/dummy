<template>
    <div
        v-for="option in options"
        :key="option"
        class="form-check form-check-inline"
    >
        <input
            class="form-check-input"
            :value="option"
            @change="$emit('update:modelValue', $event.target.value)"
            type="radio"
            :name="name"
            :id="'inlineRadio' + option"
        />
        <label class="form-check-label" :for="'inlineRadio' + option">{{
            option
        }}</label>
    </div>
</template>

<script>
export default {
    name: "input-radio",
    props: ["modelValue", "name", "options"],
    emits: ["update:modelValue"],
};
</script>

<style scoped></style>
