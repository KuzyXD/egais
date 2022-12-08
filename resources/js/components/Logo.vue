<template>
    <div class="relative flex items-center justify-center py-6">
        <a
            :href="href"
            class="cursor-pointer">
            <div class="p-5">
                <span class="text-light-blue text-7xl">КЦР.</span>
                <span class="text-green-500 text-7xl">ПНК</span>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    name: "Logo",
    computed: {
        href() {
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            return `/${apiLocation}/dashboard`;
        }
    }
}
</script>

<style scoped>

</style>
