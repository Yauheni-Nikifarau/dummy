<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container container-fluid">
                <router-link class="navbar-brand" to="/">CoolTrip</router-link>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link class="nav-link hover:active" to="/"
                                >Main
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link hover:active"
                                to="/trips"
                                >Trips
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link hover:active"
                                to="/hotels"
                                >Hotels
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link hover:active"
                                to="/about"
                                >About Us
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link hover:active"
                                to="/contacts"
                                >Contacts
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="store.state.auth">
                            <router-link
                                class="nav-link hover:active"
                                to="/account"
                                >My account
                            </router-link>
                        </li>
                    </ul>
                    <button
                        class="d-flex btn btn-outline-warning"
                        @click.prevent="logoutEvent"
                        v-if="store.state.auth"
                    >
                        Logout
                    </button>
                    <button
                        class="d-flex btn btn-outline-success"
                        @click.prevent="signInClickEvent"
                        v-else
                    >
                        Sign in
                    </button>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import { useStore } from "vuex";
import { logout } from "../composables/useLogout";

export default {
    setup(props, { emit }) {
        const store = useStore();
        const signInClickEvent = () => {
            emit("needLoginModal");
        };
        const logoutEvent = () => {
            logout();
            store.commit('logout');
        }
        return {
            store,
            signInClickEvent,
            logoutEvent,
        };
    },
    name: "site-header",
};
</script>

<style scoped></style>
