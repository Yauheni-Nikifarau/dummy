<template>
    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
            <p class="mb-1">It's an  our trip application</p>
            <p class="mb-0">
                You can read <a href="#">About us</a> or check our <a href="#">Contacts</a>.
            </p>
        </div>
    </footer>

    <login-modal v-if="modal == 'login'"></login-modal>
    <register-modal v-if="modal == 'register'"></register-modal>
</template>

<script>
import LoginModal from "../auth/LoginModal";
import RegisterModal from "../auth/RegisterModal";

export default {
    name: "site-footer",
    props: ['modal'],
    components: {
        LoginModal,
        RegisterModal
    }
}
</script>

<style scoped>

</style>
