<template>
    <site-header @needLoginModal="turnOnLoginModal"></site-header>
    <router-view></router-view>
    <site-footer></site-footer>
    <login-modal
        v-if="modal == 'login'"
        @closeModal="closeModal"
        @needRegisterModal="turnOnRegisterModal"
        @loginAttempt="loginAttempt"
    ></login-modal>
    <register-modal
        v-if="modal == 'register'"
        @closeModal="closeModal"
    ></register-modal>
</template>

<script>
import SiteHeader from "../../components/SiteHeader";
import SiteFooter from "../../components/SiteFooter";
import LoginModal from "../../components/LoginModal";
import RegisterModal from "../../components/RegisterModal";
import { ref } from "vue";

export default {
    setup() {
        const modal = ref("none");
        const turnOnLoginModal = () => {
            modal.value = "login";
        };
        const turnOnRegisterModal = () => {
            modal.value = "register";
        };
        const closeModal = () => {
            modal.value = "none";
        };
        const loginAttempt = async (credentials) => {
            console.log(credentials.email);
            console.log(credentials.password);
            const loginUrl = process.env.VUE_APP_API_ROOT_PATH + '/login';
            const response = await fetch(loginUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    email: credentials.email,
                    password: credentials.password
                })
            });
            const json = await response.json();
            console.log(json);
        };
        return {
            modal,
            loginAttempt,
            turnOnLoginModal,
            closeModal,
            turnOnRegisterModal,
        };
    },
    name: "site",
    components: {
        SiteHeader,
        SiteFooter,
        LoginModal,
        RegisterModal,
    },
};
</script>

<style scoped></style>
