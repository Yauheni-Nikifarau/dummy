<template>
    <main class="p-5">
        <div style="max-height: 70vh; overflow: scroll">
            <template v-for="message in messages" :key="message.id">
                <div
                    v-if="message.user == 'you'"
                    class="w-75 p-3 bg-primary ms-auto mt-2"
                >
                    <p>You at {{ message.date }}</p>
                    <p>{{ message.text }}</p>
                </div>

                <div v-else class="w-75 p-3 bg-info mt-2">
                    <p>Admin at {{ message.date }}</p>
                    <p>{{ message.text }}</p>
                </div>
            </template>
        </div>

        <form class="card p-2 mt-3">
            <textarea class="form-control" v-model="message"></textarea>

            <div class="alert alert-warning mt-3" v-if="sendError">
                Error
            </div>

            <button type="submit"  @click.prevent="sendMessage" class="btn btn-primary mt-3 align-self-end">
                Send
            </button>
        </form>
    </main>
</template>

<script>
import { useRoute } from "vue-router";
import { ref } from "vue";
// import axios from "axios";

export default {
    setup() {
        const route = useRoute();
        const message = ref('');
        const messages = ref([]);
        const sendError = ref(false);
        const getMessagesList = async () => {
            const authHeader = localStorage.getItem("authHeader");
            const messagesUrl =
                process.env.VUE_APP_API_ROOT_PATH +
                "/api/messages/" +
                route.params.id;
            const response = await fetch(messagesUrl, {
                headers: {
                    Authorization: authHeader,
                },
            });
            const json = await response.json();
            messages.value = json.data;
        };
        getMessagesList();
        const sendMessage = async () => {
            if (! message.value) return;
            const authHeader = localStorage.getItem("authHeader");
            const messagesUrl =
                process.env.VUE_APP_API_ROOT_PATH +
                "/api/messages";
            const response = await fetch(messagesUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    Accept: 'application/json',
                    Authorization: authHeader,
                },
                body: JSON.stringify({
                    subject: route.params.id,
                    text: message.value
                })
            });
            const json = await response.json();
            if (! json.success) {
                sendError.value = true;
                return;
            }
            sendError.value = false;
            const now = new Date();
            messages.value.push({
                user: 'you',
                date: now.getDate() + '-' + (now.getMonth() + 1) + ' ' + now.getHours() + ':' + now.getMinutes(),
                text: message.value
            });
            message.value = '';
        }
        return {
            sendError,
            messages,
            message,
            sendMessage
        };
    },
    name: "conversation-page",
};
</script>

<style scoped></style>
