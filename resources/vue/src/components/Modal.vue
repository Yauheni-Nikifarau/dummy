<template>
    <div class="modal fade show d-block">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Authorization</h5>
                    <router-link
                        to="/"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></router-link>
                </div>
                <div class="modal-body p-3">
                    <slot></slot>
                </div>

                <div class="modal-footer">
                    <router-link
                        to="/"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        >Close</router-link
                    >
                    <router-link to="/account" class="btn btn-primary"
                        >Login</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "modal",
};
</script>

<style scoped></style>
