<template>
    <me-page v-if="page == 'me'"></me-page>
    <message-page v-if="page == 'message'"></message-page>
    <messages-page v-if="page == 'messages'"></messages-page>
    <order-page v-if="page == 'order'"></order-page>
    <orders-page v-if="page == 'orders'"></orders-page>
</template>

<script>
import MePage from "../me/MePage";
import MessagePage from "../message/MessagePage";
import MessagesPage from "../messages/MessagesPage";
import OrderPage from "../order/OrderPage";
import OrdersPage from "../orders/OrdersPage";
export default {
    name: "account-main",
    props: ['page'],
    components: {
        MePage,
        MessagesPage,
        MessagePage,
        OrderPage,
        OrdersPage
    }
}
</script>

<style scoped>

</style>
