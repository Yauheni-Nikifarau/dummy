<template>
    <tr>
        <th scope="row">
            <router-link
                :to="'/account/orders/' + order.id"
                class="list-group-item list-group-item-action"
                >{{ order.id }}
            </router-link>
        </th>
        <td>{{ order.created_at }}</td>
        <td>{{ order.price }}$</td>
        <td>{{ order.paid ? "yes" : "no" }}</td>
        <td>{{ order.country }}</td>
        <td>{{ order.hotel }}</td>
    </tr>
</template>

<script>
export default {
    name: "order-list-item",
    props: ["order"],
};
</script>

<style scoped></style>
