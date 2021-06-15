<template>
    <main class="p-5">
        <div style="max-height: 70vh; overflow: scroll">
            <template v-for="message in messages" :key="message.id">

                <div v-if="message.user.id == authuser.id" class="w-75 p-3 bg-primary ms-auto mt-2">
                    <p>You at {{ message.date }}</p>
                    <p>{{ message.text }}</p>
                </div>

                <div v-else class="w-75 p-3 bg-info mt-2">
                    <p>Admin at {{ message.date }}</p>
                    <p>{{ message.text }}</p>
                </div>

            </template>
        </div>

        <form class="card p-2 mt-3">

            <textarea class="form-control" name="message">Write your message here</textarea>

            <button type="submit" class="btn btn-primary mt-3 align-self-end">Send</button>
        </form>
    </main>
</template>

<script>
export default {
    setup () {
        const authuser = {};
        const messages = [
            {
                user: 'userObject',
                date: '12.12.12 13:14:15',
                text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, nulla reprehenderit nihil ratione voluptatibus modi veniam temporibus, obcaecati labore, totam atque quaerat quod laborum porro. Officia quam dolore reiciendis fugiat!'
            },
            {
                user: 'userObject',
                date: '12.12.12 13:14:15',
                text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, nulla reprehenderit nihil ratione voluptatibus modi veniam temporibus, obcaecati labore, totam atque quaerat quod laborum porro. Officia quam dolore reiciendis fugiat!'
            },
            {
                user: 'userObject',
                date: '12.12.12 13:14:15',
                text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, nulla reprehenderit nihil ratione voluptatibus modi veniam temporibus, obcaecati labore, totam atque quaerat quod laborum porro. Officia quam dolore reiciendis fugiat!'
            },
            {
                user: 'userObject',
                date: '12.12.12 13:14:15',
                text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, nulla reprehenderit nihil ratione voluptatibus modi veniam temporibus, obcaecati labore, totam atque quaerat quod laborum porro. Officia quam dolore reiciendis fugiat!'
            },
        ];
        return {
            messages,
            authuser
        }
    },
    name: "message-page"
}
</script>

<style scoped>

</style>
