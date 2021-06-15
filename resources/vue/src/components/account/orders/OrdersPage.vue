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
            <order-list-item v-for="order in orders" :key="order.id" :order="order"></order-list-item>
            </tbody>
        </table>
    </main>
</template>

<script>
import OrderListItem from "./OrderListItem";

export default {
    setup () {
        const orders = [
            {
                id: 192,
                created_at: '12.12.2021 13:14:15',
                price: 1950,
                paid: true,
                trip: {
                    hotel: {
                        country: 'Cyprus',
                        name: 'The most popular hotel'
                    }
                }
            },
            {
                id: 192,
                created_at: '12.12.2021 13:14:15',
                price: 1950,
                paid: true,
                trip: {
                    hotel: {
                        country: 'Cyprus',
                        name: 'The most popular hotel'
                    }
                }
            },
            {
                id: 192,
                created_at: '12.12.2021 13:14:15',
                price: 1950,
                paid: true,
                trip: {
                    hotel: {
                        country: 'Cyprus',
                        name: 'The most popular hotel'
                    }
                }
            },
            {
                id: 192,
                created_at: '12.12.2021 13:14:15',
                price: 1950,
                paid: true,
                trip: {
                    hotel: {
                        country: 'Cyprus',
                        name: 'The most popular hotel'
                    }
                }
            },
        ];
        return {
            orders
        }
    },
    name: "orders-page",
    components: {
        OrderListItem
    }
}
</script>

<style scoped>

</style>
