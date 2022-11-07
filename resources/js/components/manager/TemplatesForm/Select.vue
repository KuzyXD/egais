<template>
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">{{ name }}:</label>
        <select :id="id"
                v-model="value"
                :name="id"
                :required="required"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option v-for="option in options" :value="option.value">{{ option.name }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: ['name', 'id', 'required', 'modelValue', 'options'],
    emits: ['update:modelValue'],
    computed: {
        value: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            }
        }
    }
}
</script>

<style scoped>

</style>
