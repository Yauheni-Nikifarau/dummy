<template>
    <div class="modal fade show d-block">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Authorization</h5>
                    <a href="/" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body p-3">
                    <slot></slot>
                </div>

                <div class="modal-footer">
                    <a href="/" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                    <a href="/profile" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "modal"
}
</script>

<style scoped>

</style>
