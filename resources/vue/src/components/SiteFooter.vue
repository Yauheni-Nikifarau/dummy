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
</template>

<script>
export default {
    name: "site-footer",
};
</script>

<style scoped></style>
