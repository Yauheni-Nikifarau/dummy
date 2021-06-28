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
        <div class="alert-warning" v-if="orders.length == 0 && !errorSwitch">
            You have not any orders
        </div>
        <div class="alert-danger" v-if="errorSwitch">
            Error. Try again.
        </div>
    </main>
</template>

<script>
import OrderListItem from "./OrderListItem";
import {ref} from "vue";

export default {
    setup(props, { emit }) {
        const orders = ref([]);
        const errorSwitch = ref(false);
        const getOrders = async () => {
            const authHeader = localStorage.getItem("authHeader");
            if (!authHeader) {
                emit('needAuthorization');
            }
            const ordersUrl = process.env.VUE_APP_API_ROOT_PATH + '/api/orders';
            const response = await fetch(ordersUrl, {
                headers: {
                    Authorization: authHeader,
                },
            }).catch(() => {errorSwitch.value = true});
            if (response.status == 403) {
                emit("needAuthorization");
            }
            const json = await response.json();
            orders.value = json.data;
        }
        getOrders()
        return {
            orders,
            errorSwitch
        };
    },
    name: "orders-page",
    components: {
        OrderListItem,
    },
};
</script>

<style scoped></style>
