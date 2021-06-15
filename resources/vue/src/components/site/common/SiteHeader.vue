<template>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container container-fluid">
                    <a class="navbar-brand" href="#">CoolTrip</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link hover:active" href="#">Main</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover:active" href="#">Trips</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover:active" href="#">Hotels</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover:active" href="#">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover:active" href="#">Contacts</a>
                            </li>
                        </ul>
                        <a class="d-flex btn btn-outline-success" href="#">Sign in</a>
                    </div>
                </div>
            </nav>
        </header>
</template>

<script>
export default {
    name: "site-header"
}
</script>

<style scoped>

</style>
