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
    </main>
</template>

<script>
import {ref} from "vue";
import ConversationListItem from "./ConversationListItem";

export default {
    setup() {
        const conversations = ref([]);
        const getConversationsList = async () => {
            const authHeader = localStorage.getItem("authHeader");
            const messagesUrl = process.env.VUE_APP_API_ROOT_PATH + '/api/messages';
            const response = await fetch(messagesUrl, {
                headers: {
                    'Authorization': authHeader,
                },
            });
            const json = await response.json();
            const data = json.data;
            conversations.value = data;
        }
        getConversationsList();
        return {
            conversations,
        };
    },
    name: "conversations-page",
    components: {
        ConversationListItem
    },
};
</script>

<style scoped></style>
