<template>
    <modal @closeModal="closeModal">
        <template v-slot:title>Registration</template>
        <template v-slot:body>
            <div class="form-floating">
                <input
                    type="text"
                    class="form-control"
                    v-model="credentials.name"
                />
                <label>Name</label>
                <div class="alert alert-danger" v-show="errors.name.switch">
                    {{ errors.name.text }}
                </div>
            </div>
            <div class="form-floating mt-3 mb-3">
                <input
                    type="text"
                    class="form-control"
                    v-model="credentials.surname"
                />
                <label>Surname</label>
                <div class="alert alert-danger" v-show="errors.surname.switch">
                    {{ errors.surname.text }}
                </div>
            </div>
            <div class="form-floating">
                <input
                    type="email"
                    class="form-control"
                    v-model="credentials.email"
                />
                <label>Email</label>
                <div class="alert alert-danger" v-show="errors.email.switch">
                    {{ errors.email.text }}
                </div>
            </div>
            <div class="form-floating mt-3 mb-3">
                <input
                    type="password"
                    class="form-control"
                    v-model="credentials.password"
                />
                <label>Password</label>
                <div class="alert alert-danger" v-show="errors.password.switch">
                    {{ errors.password.text }}
                </div>
            </div>
            <div class="form-floating mt-3 mb-3">
                <input
                    type="password"
                    class="form-control"
                    v-model="credentials.confirmation"
                />
                <label>Password</label>
            </div>
            <div class="form-floating">
                <input
                    type="date"
                    class="form-control"
                    v-model="credentials.birth"
                />
                <label>Birth date</label>
                <div class="alert alert-danger" v-show="errors.birth.switch">
                    {{ errors.birth.text }}
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <button class="btn btn-primary" @click.prevent="registerAttempt">Register</button>
        </template>
    </modal>

    <bg-shadow></bg-shadow>
</template>

<script>
import Modal from "./Modal";
import BgShadow from "./BgShadow";
import {reactive} from "vue";
import { useStore } from "vuex";

export default {
    setup (props, { emit }) {
        const store = useStore();
        const credentials = reactive({
            name: '',
            surname: '',
            email: '',
            password: '',
            confirmation: '',
            birth: ''
        });
        const errors = reactive({
            name: {switch: false, text: ''},
            surname: {switch: false, text: ''},
            email: {switch: false, text: ''},
            password: {switch: false, text: ''},
            birth: {switch: false, text: ''},
        });
        const closeModal = () => {
            emit("closeModal");
        };
        const registerAttempt = async () => {
            for (let key in errors) {
                errors[key].switch = false;
                errors[key].text = '';
            }
            const registerUrl = process.env.VUE_APP_API_ROOT_PATH + '/register';
            const response = await fetch(registerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: credentials.name,
                    surname: credentials.surname,
                    email: credentials.email,
                    password: credentials.password,
                    password_confirmation: credentials.confirmation,
                    birth: credentials.birth
                })
            });
            const json = await response.json();
            if (json.access_token && json.token_type && json.expires_in) {
                localStorage.setItem('authHeader', `${json.token_type} ${json.access_token}`);
                localStorage.setItem('authHeaderExpire', Math.trunc(Date.now() / 1000) + json.expires_in);
                store.commit('login');
                closeModal();
            } else if (json.errors) {
                for (let key in json.errors) {
                    if (key in errors) {
                        errors[key].switch = true;
                        errors[key].text = json.errors[key][0];
                    }
                }
            }
        }
        return {
            credentials,
            errors,
            closeModal,
            registerAttempt
        };
    },
    name: "register-modal",
    components: {
        BgShadow,
        Modal,
    },
};
</script>

<style scoped></style>
