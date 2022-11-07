<template>
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">{{ name }}:</label>
        <input :id="id"
               v-model.trim="value"
               :name="id"
               :pattern="pattern"
               :placeholder="placeholder"
               :required="required"
               :type="type"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    </div>
</template>

<script>
export default {
    props: ['name', 'id', 'type', 'placeholder', 'required', 'modelValue', 'pattern'],
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
