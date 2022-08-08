<template>
  <table class="w-full text-sm text-left text-gray-500">
    <caption class="px-5 text-lg font-semibold text-left text-gray-900">
      {{ title }}
      <p v-show="text" class="mt-1 text-sm font-normal text-gray-500">
        {{ text }}
      </p>
      <div class="mb-2 mt-4 flex gap-8">
        <div v-for="(filter, index) in filters" :key="index">
          <input :id="'checkbox'+index"
                 class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500" type="checkbox"
                 @change="$emit(filter.name)">
          <label :for="'checkbox'+index" class="ml-2 text-sm font-medium text-gray-900">{{ filter.text }}</label>
        </div>
      </div>
      <div class="flex">
        <div class="pb-4 pr-4">
          <label class="sr-only" for="table-search">Поиск</label>
          <div class="relative mt-1">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                   xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      fill-rule="evenodd"></path>
              </svg>
            </div>
            <input id="table-search"
                   class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Искать"
                   type="text"
                   @change.lazy="event => $emit('search', event.target.value)">
          </div>
        </div>
      </div>
    </caption>
    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
    <tr>
      <th v-for="(col, colIndex) in cols" :key="colIndex" class="py-3 px-6" scope="col">
        {{ col }}
      </th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(item, index) in items" :key="index" class="border-b hover:bg-gray-100">
      <th class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap"
          scope="row">
        {{ item[0] }}
      </th>
      <td v-for="value in item.slice(1)" class="py-4 px-6">
        {{ value }}
      </td>
      <td class="py-4 px-6">
        <button :id="'dropdownAction' + index" :data-dropdown-toggle="'dropdown' + index"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center"
                data-dropdown-placement="left"
                type="button" @click="openDropdown">Действия
          <svg aria-hidden="true" class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
               xmlns="http://www.w3.org/2000/svg">
            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
        </button>

        <div :id="'dropdown' + index"
             class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow absolute">
          <ul :aria-labelledby="'dropdownAction' + index" class="py-1 text-sm text-gray-700">
            <li v-for="(action, actionIndex) in actions" :key="actionIndex">
              <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600" href="#"
                 @click.prevent="$emit(action.name, item[0])">{{ action.text }}</a>
            </li>
          </ul>
        </div>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ['title', 'text', 'cols', 'items', 'actions', 'filters'],
  methods: {
    openDropdown(event) {
      let el = document.getElementById(event.target.getAttribute('data-dropdown-toggle'));
      el.classList.toggle('hidden');
    }
  }
}
</script>

<style scoped>

</style>