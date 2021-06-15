<template>
    <modal>
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput">
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating mt-3 mb-3">
            <input type="password" name="password" class="form-control" id="floatingInput2">
            <label for="floatingInput2">Password</label>
        </div>
        <p>If you don't have an accountt <a href="/register">press here for registration</a></p>
    </modal>
    <shadow></shadow>
</template>

<script>
import Modal from "./Modal";
import Shadow from "../common/Shadow";
export default {
    name: "login-modal",
    components: {
        Shadow,
        Modal
    }
}
</script>

<style scoped>

</style>
