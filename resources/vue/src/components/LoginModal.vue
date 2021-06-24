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
            <div class="alert alert-danger" v-show="loginErrorSwitch">
                Wrong email or password
            </div>
            <div class="alert alert-danger" v-show="loginAnyErrorSwitch">
                Something went wrong. Please try again.
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
import { useStore } from "vuex";

export default {
    setup(props, { emit }) {
        const store = useStore();
        const email = ref("");
        const password = ref("");
        const loginErrorSwitch = ref(false);
        const loginAnyErrorSwitch = ref(false);
        const closeModal = () => {
            emit("closeModal");
        };
        const needRegisterModal = () => {
            emit("needRegisterModal");
        };
        const loginAttempt = async () => {
            const loginUrl = process.env.VUE_APP_API_ROOT_PATH + '/login';
            const response = await fetch(loginUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    email: email.value,
                    password: password.value
                })
            });
            const json = await response.json();
            if (json.access_token && json.token_type && json.expires_in) {
                localStorage.setItem('authHeader', `${json.token_type} ${json.access_token}`);
                localStorage.setItem('authHeaderExpire', Math.trunc(Date.now() / 1000) + json.expires_in);
                loginErrorSwitch.value = false;
                store.commit('login');
                closeModal();
            } else if (json.error) {
                loginErrorSwitch.value = true;
            } else {
                loginAnyErrorSwitch.value = true;
            }
        };
        return {
            email,
            password,
            loginErrorSwitch,
            loginAnyErrorSwitch,
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
