<template>
    <div id="create-ur-template-modal" ref="modal" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full"
         tabindex="-1">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button
                    ref="close"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="create-ur-template-modal"
                    type="button"
                    @click="clearData">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              fill-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Создать шаблон заявки:</h3>
                    <form action="#" class="space-y-4">

                        <ur-fields v-model="form"></ur-fields>
                        
                        <p class="text-sm text-gray-500">При нажатии кнопки "Готово" вы автоматически становитесь
                            ответственным за созданную заявку.</p>
                        <button
                            class="w-full focus:outline-none text-white bg-green-500 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
                            type="button" @click="submit">
                            Готово
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UrFields from "./TemplatesForm/UrFields";
import {UrTemplate} from "./TemplatesForm/UrTemplate";

export default {
    components: {UrFields},
    data() {
        return {
            form: new UrTemplate(),
        }
    },
    methods: {
        submit() {
            this.$emit('submit', this.form, this.$refs.close);
        },
        clearData() {
            this.form = new UrTemplate();
        }
    },
}
</script>

