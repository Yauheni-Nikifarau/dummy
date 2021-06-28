<template>
    <main class="p-5">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Last message</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <conversation-list-item
                    v-for="conversation in conversations"
                    :key="conversation.id"
                    :conversation="conversation"
                >
                </conversation-list-item>
            </tbody>
        </table>
        <div class="alert-warning" v-if="conversations.length == 0 && !errorSwitch">
            You have not any conversations
        </div>
        <div class="alert-danger" v-if="errorSwitch">
            Error. Try again.
        </div>
    </main>
</template>

<script>
import { ref } from "vue";
import ConversationListItem from "./ConversationListItem";

export default {
    setup(props, { emit }) {
        const conversations = ref([]);
        const errorSwitch = ref(false);
        const getConversationsList = async () => {
            errorSwitch.value = false;
            const authHeader = localStorage.getItem("authHeader");
            if (!authHeader) {
                emit('needAuthorization');
            }
            const messagesUrl =
                process.env.VUE_APP_API_ROOT_PATH + "/api/messages";
            const response = await fetch(messagesUrl, {
                headers: {
                    Authorization: authHeader,
                },
            }).catch(() => {errorSwitch.value = true});
            if (response.status == 403) {
                emit("needAuthorization");
            }
            const json = await response.json();
            conversations.value = json.data;
        };
        getConversationsList();
        return {
            conversations,
            errorSwitch
        };
    },
    name: "conversations-page",
    components: {
        ConversationListItem,
    },
};
</script>

<style scoped></style>
