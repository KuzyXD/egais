<template>
    <table class="w-full text-sm text-left text-gray-500 table-fixed">
        <caption class="px-5 text-lg font-semibold text-left text-gray-900">
            {{ title }}
            <p v-show="text" class="mt-1 text-sm font-normal text-gray-500">
                {{ text }}
            </p>
            <div class="mb-2 mt-4 flex gap-8">
                <div v-for="(filter, index) in filters" :key="index">
                    <input :id="'checkbox'+index"
                           class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500"
                           type="checkbox"
                           @change="$emit(filter.name)">
                    <label :for="'checkbox'+index" class="ml-2 text-sm font-medium text-gray-900">{{
                            filter.text
                        }}</label>
                </div>
            </div>
            <div class="flex">
                <div class="pb-4 pr-4">
                    <label class="sr-only" for="table-search">Поиск</label>
                    <div class="relative mt-1">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                 viewBox="0 0 20 20"
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
            <th v-for="(col, colIndex) in localCols" :id="col.key" :key="colIndex" class="py-3 px-6" scope="col">
                <div class="flex items-center">
                    {{ col.name }}
                    <a v-if="col.sortable" href="#" @click.prevent="changeSortableState(col)">
                        <svg :viewBox="sortIconViewbox(col.sortableState)" aria-hidden="true" class="ml-1 w-3 h-3"
                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                :d="sortIconPathValue(col.sortableState)"/>
                        </svg>
                    </a>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in items" :key="index" class="border-b hover:bg-gray-100">
            <th class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap"
                scope="row">
                {{ item.id }}
            </th>
            <td v-for="value in Object.values(item).slice(1)" class="py-4 px-6">
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
    data() {
        return {
            localCols: this.cols,
        }
    },
    methods: {
        openDropdown(event) {
            let el = document.getElementById(event.target.getAttribute('data-dropdown-toggle'));
            el.classList.toggle('hidden');
        },
        sortIconViewbox(state) {
            switch (state) {
                case 'normal':
                    return '0 0 24 24';
                case 'desc':
                    return '-96 0 512 512';
                case 'asc':
                    return '-96 0 512 512';
            }
        },
        sortIconPathValue(state) {
            switch (state) {
                case 'normal':
                    return 'M6.227 11h11.547c.862 0 1.32-1.02.747-1.665L12.748 2.84a.998.998 0 0 0-1.494 0L5.479 9.335C4.906 9.98 5.364 11 6.227 11zm5.026 10.159a.998.998 0 0 0 1.494 0l5.773-6.495c.574-.644.116-1.664-.747-1.664H6.227c-.862 0-1.32 1.02-.747 1.665l5.773 6.494z';
                case 'desc':
                    return 'M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z';
                case 'asc':
                    return 'M279 224H41c-21.4 0-32.1-25.9-17-41L143 64c9.4-9.4 24.6-9.4 33.9 0l119 119c15.2 15.1 4.5 41-16.9 41z';
            }
        },
        changeSortableState(col) {
            col.sortableState = col.sortableState === 'normal' ? 'desc' : (col.sortableState === 'desc' ? 'asc' : 'normal');
            this.$emit('sorted');
        }
    },
}
</script>

<style scoped>

</style>
