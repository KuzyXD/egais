<template>
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ title }} (<a
        class="text-blue-600 underline" href="" @click.prevent="clearValue">очистить</a>)</label>
    <input
        :id="'file_input_' + this.en_title"
        :ref="this.en_title + 'fileField'"
        aria-describedby="file_input_help"
        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        type="file"
        @change="value">
    <p id="file_input_help" class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ helperText }}</p>
</template>

<script>
export default {
    props: ['title', 'en_title', 'helperText'],
    emits: ['fileChange'],
    methods: {
        value(value) {
            this.$emit('fileChange', value.target.files[0]);
        },
        clearValue() {
            this.$refs[this.en_title + 'fileField'].value = null
            this.$emit('fileChange', null);
        }
    }
}
</script>

<style scoped>

</style>
