<template>
    <tr>
        <th scope="row">
            <router-link
                :to="'/account/conversations/' + conversation.id"
                class="list-group-item list-group-item-action"
                >Order#{{ conversation.id }}
            </router-link>
        </th>
        <td>{{ conversation.last_message.slice(0, 150) }}...</td>
        <td>{{ conversation.last_date }}</td>
    </tr>
</template>

<script>
export default {
    name: "conversation-list-item",
    props: ["conversation"],
};
</script>

<style scoped></style>
