<template>
    <tr>
        <th scope="row">
            <a :href="'/profile/order/' + order.id" class="list-group-item list-group-item-action">{{ order.id }}</a>
        </th>
        <td>{{ order.created_at }}</td>
        <td>{{ order.price }}$</td>
        <td>{{ order.paid ? 'yes' : 'no' }}</td>
        <td>{{ order.trip.hotel.country }}</td>
        <td>{{ order.trip.hotel.name}}</td>
    </tr>
</template>

<script>
export default {
    name: "order-list-item",
    props: ['order']
}
</script>

<style scoped>

</style>
