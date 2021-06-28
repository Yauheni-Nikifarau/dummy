<template>
    <main class="p-5 w-100">
        <div class="messages-box">
            <div class="alert alert-warning mt-3" v-if="errors.conversation">
                You don't have an order with such id.
            </div>
            <div class="alert alert-warning mt-3" v-if="errors.empty">
                You have not any messages yet dedicated to this order. Write first.
            </div>
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

            <div class="alert alert-warning mt-3" v-if="errors.send">
                Error
            </div>

            <button
                type="submit"
                @click.prevent="sendMessage"
                class="btn btn-primary mt-3 align-self-end"
            >
                Send
            </button>
        </form>
    </main>
</template>

<script>
import { useRoute } from "vue-router";
import { reactive, ref } from "vue";
// import axios from "axios";

export default {
    setup(props, { emit }) {
        const route = useRoute();
        const message = ref("");
        const messages = ref([]);
        const errors = reactive({
            send: false,
            conversation: false,
            empty: false,
        });

        const getMessagesList = async () => {
            for (let key in errors) {
                errors[key] = false;
            }
            const authHeader = localStorage.getItem("authHeader");
            if (!authHeader) {
                emit("needAuthorization");
            }
            const messagesUrl =
                process.env.VUE_APP_API_ROOT_PATH +
                "/api/messages/" +
                route.params.id;
            const response = await fetch(messagesUrl, {
                headers: {
                    Authorization: authHeader,
                },
            });
            if (response.status == 400) {
                errors.conversation = true;
                return;
            }
            if (response.status == 403) {
                emit("needAuthorization");
                return;
            }
            const json = await response.json();
            messages.value = json.data;
            if(messages.value.length == 0) {
                errors.empty = true;
            }
        };
        getMessagesList();
        const sendMessage = async () => {
            if (!message.value) return;
            const authHeader = localStorage.getItem("authHeader");
            if (!authHeader) {
                emit("needAuthorization");
            }
            const messagesUrl =
                process.env.VUE_APP_API_ROOT_PATH + "/api/messages";
            const response = await fetch(messagesUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    Accept: "application/json",
                    Authorization: authHeader,
                },
                body: JSON.stringify({
                    subject: route.params.id,
                    text: message.value,
                }),
            });
            if (response.status == 403) {
                emit("needAuthorization");
            }
            const json = await response.json();
            if (!json.success) {
                errors.send.switch = true;
                return;
            }
            errors.send.switch = false;
            const now = new Date();
            messages.value.push({
                user: "you",
                date:
                    now.getDate() +
                    "-" +
                    (now.getMonth() + 1) +
                    " " +
                    now.getHours() +
                    ":" +
                    now.getMinutes(),
                text: message.value,
            });
            message.value = "";
        };
        return {
            errors,
            messages,
            message,
            sendMessage,
        };
    },
    name: "conversation-page",
};
</script>

<style scoped>
.messages-box {
    height: 70vh;
    overflow: scroll
}
</style>
