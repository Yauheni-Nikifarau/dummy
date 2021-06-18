<template>
    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
            <p class="mb-1">It's an our trip application</p>
            <p class="mb-0">
                You can read
                <router-link to="/about">About us</router-link>
                or check our
                <router-link to="/contacts">Contacts</router-link>
                .
            </p>
        </div>
    </footer>

    <login-modal v-if="modal == 'login'"></login-modal>
    <register-modal v-if="modal == 'register'"></register-modal>
</template>

<script>
import LoginModal from "./LoginModal";
import RegisterModal from "./RegisterModal";

export default {
    name: "site-footer",
    props: ["modal"],
    components: {
        LoginModal,
        RegisterModal,
    },
};
</script>

<style scoped></style>
