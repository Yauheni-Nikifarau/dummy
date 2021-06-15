<template>
    <main class="p-5">
        <img :src="order.trip.image" alt="hotel">
        <h2>Order #{{ order.id }}</h2>
        <p>Price: {{ order.price }}$</p>
        <p v-if="order.paid">You already have paid this order</p>
        <p v-else>You have not paid this trip and reservation expires {{ order.reservation_expires }}</p>
        <p>If you have any problem, or questions, <button class="btn btn-success">contact us</button></p>
    </main>
</template>

<script>
export default {
    name: "order-page",
    props: ['order']
}
</script>

<style scoped>

</style>
