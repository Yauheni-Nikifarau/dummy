<template>
    <tr>
        <th scope="row">
            <a :href="'/profile/message?opponent=' + message.opponent.id" class="list-group-item list-group-item-action">{{ message.subject }}</a>
        </th>
        <td>{{ message.text }}</td>
        <td>{{ message.created_at }}</td>
    </tr>
</template>

<script>
export default {
    name: "message-list-item",
    props: ['message']
}
</script>

<style scoped>

</style>
