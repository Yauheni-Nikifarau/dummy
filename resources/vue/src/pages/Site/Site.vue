<template>
    <site-header @needLoginModal="turnOnLoginModal"></site-header>
    <router-view></router-view>
    <site-footer></site-footer>
    <login-modal
        v-if="modal == 'login'"
        @closeModal="closeModal"
        @needRegisterModal="turnOnRegisterModal"
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
        return {
            modal,
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
