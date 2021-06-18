<template>
    <main class="p-5">
        <button class="btn btn-success">Start a new conversation</button>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Last message</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <message-list-item
                    v-for="message in messages"
                    :key="message.id"
                    :message="message"
                >
                </message-list-item>
            </tbody>
        </table>
    </main>
</template>

<script>
import MessageListItem from "./MessageListItem";

export default {
    setup() {
        const messages = [
            {
                id: 12,
                subject: "Order #25446",
                opponent: "userObject",
                created_at: "12.12.2021 13:14:15",
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione itaque repellendus quae eaque fugit pariatur doloribus, ab ipsam. Aliquid porro dolorum magni cupiditate maiores unde voluptatibus, quos fugit cumque laborum.",
            },
            {
                id: 13,
                subject: "Order #25446",
                opponent: "userObject",
                created_at: "12.12.2021 13:14:15",
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione itaque repellendus quae eaque fugit pariatur doloribus, ab ipsam. Aliquid porro dolorum magni cupiditate maiores unde voluptatibus, quos fugit cumque laborum.",
            },
            {
                id: 124,
                subject: "Order #25446",
                opponent: "userObject",
                created_at: "12.12.2021 13:14:15",
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione itaque repellendus quae eaque fugit pariatur doloribus, ab ipsam. Aliquid porro dolorum magni cupiditate maiores unde voluptatibus, quos fugit cumque laborum.",
            },
            {
                id: 1,
                subject: "Order #25446",
                opponent: "userObject",
                created_at: "12.12.2021 13:14:15",
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione itaque repellendus quae eaque fugit pariatur doloribus, ab ipsam. Aliquid porro dolorum magni cupiditate maiores unde voluptatibus, quos fugit cumque laborum.",
            },
            {
                id: 22,
                subject: "Order #25446",
                opponent: "userObject",
                created_at: "12.12.2021 13:14:15",
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione itaque repellendus quae eaque fugit pariatur doloribus, ab ipsam. Aliquid porro dolorum magni cupiditate maiores unde voluptatibus, quos fugit cumque laborum.",
            },
        ];
        return {
            messages,
        };
    },
    name: "messages-page",
    components: {
        MessageListItem,
    },
};
</script>

<style scoped></style>
