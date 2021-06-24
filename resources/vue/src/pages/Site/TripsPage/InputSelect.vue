<template>
    <select
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="form-select w-50 mb-3"
        aria-label="Default select example"
    >
        <option selected value="">{{ title }}</option>
        <option
            v-for="option in options"
            :key="option.id"
            :value="option.value"
            :selected="option.value == selectedTag"
        >
            {{ option.name }}
        </option>
    </select>
</template>

<script>
import {ref} from "vue";

export default {
    setup (props) {
        const selectedTag = ref(props.modelValue);
        return {
            selectedTag
        }
    },
    name: "input-select",
    props: ["modelValue", "title", "options"],
    emits: ["update:modelValue"],
};
</script>

<style scoped></style>
