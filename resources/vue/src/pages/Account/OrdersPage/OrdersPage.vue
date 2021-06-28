<template>
    <main class="p-5">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Created</th>
                    <th scope="col">Price</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Country</th>
                    <th scope="col">Hotel</th>
                </tr>
            </thead>
            <tbody>
                <order-list-item
                    v-for="order in orders"
                    :key="order.id"
                    :order="order"
                ></order-list-item>
            </tbody>
        </table>
    </main>
</template>

<script>
import OrderListItem from "./OrderListItem";
import {ref} from "vue";

export default {
    setup() {
        const orders = ref([]);
        const getOrders = async () => {
            const authHeader = localStorage.getItem("authHeader");
            const ordersUrl = process.env.VUE_APP_API_ROOT_PATH + '/api/orders';
            const response = await fetch(ordersUrl, {
                headers: {
                    Authorization: authHeader,
                },
            });
            const json = await response.json();
            orders.value = json.data;
        }
        getOrders()
        return {
            orders,
        };
    },
    name: "orders-page",
    components: {
        OrderListItem,
    },
};
</script>

<style scoped></style>
