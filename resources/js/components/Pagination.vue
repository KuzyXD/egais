<template>
  <nav class="flex gap-2">
    <slot></slot>
    <a class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
       href="#" @click.prevent="$emit('previous')">
      Предыдущая страница
    </a>
    <a class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
       href="#" @click.prevent="$emit('next')">
      Следующая страница
    </a>
  </nav>
</template>

<script>
export default {}
</script>

<style scoped>

</style>