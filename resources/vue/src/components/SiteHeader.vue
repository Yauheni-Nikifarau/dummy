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
                    </ul>
                    <button class="d-flex btn btn-outline-success">
                        Sign in
                    </button>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: "site-header",
};
</script>

<style scoped></style>
