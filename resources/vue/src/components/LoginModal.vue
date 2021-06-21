<template>
    <modal @closeModal="closeModal">
        <template v-slot:title>Authorization</template>
        <template v-slot:body>
            <div class="form-floating">
                <input
                    v-model="email"
                    type="email"
                    name="email"
                    class="form-control"
                    id="floatingInput"
                />
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating mt-3 mb-3">
                <input
                    v-model="password"
                    type="password"
                    name="password"
                    class="form-control"
                    id="floatingInput2"
                />
                <label for="floatingInput2">Password</label>
            </div>
            <p>
                If you don't have an account
                <a href="#" @click.prevent="needRegisterModal"
                    >press here for registration
                </a>
            </p>
        </template>
        <template v-slot:footer>
            <button class="btn btn-primary" @click.prevent="loginAttempt">
                Login
            </button>
        </template>
    </modal>
    <bg-shadow></bg-shadow>
</template>

<script>
import Modal from "./Modal";
import BgShadow from "./BgShadow";
import { ref } from "vue";

export default {
    setup(props, { emit }) {
        const email = ref("");
        const password = ref("");
        const closeModal = () => {
            emit("closeModal");
        };
        const needRegisterModal = () => {
            emit("needRegisterModal");
        };
        const loginAttempt = () => {
            const credentials = {
                email: email.value,
                password: password.value
            };
            emit('loginAttempt', credentials);
        }
        return {
            email,
            password,
            closeModal,
            needRegisterModal,
            loginAttempt
        };
    },
    name: "login-modal",
    components: {
        BgShadow,
        Modal,
    },
};
</script>

<style scoped></style>
