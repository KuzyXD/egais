<template>
    <div id="update-client-group-modal" ref="modal" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full"
         tabindex="-1"
         @focus.once="fetch">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button
                    ref="close"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="update-client-group-modal"
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
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Изменить группу у клиента:</h3>
                    <p class="text-sm text-gray-500 mb-4">Группа клиента означает доступ к компания группы и возможность
                        взаимодействия с
                        их заявками.</p>
                    <form action="#" class="space-y-6">
                        <div>
                            <select
                                id="group"
                                v-model="form.group"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option v-for="value in options">{{ value }}</option>
                            </select>
                        </div>
                        <p class="text-sm text-gray-500">При нажатии кнопки "Готово" вы измените группу клиента.</p>
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
export default {
    props: ['selectedItem'],
    data() {
        return {
            form: {
                group: '',
            },
            options: []
        }
    },
    methods: {
        fetch() {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/group/list`).then(function (response) {
                vue.options = response.data
                vue.$nextTick(() => vue.showCurrentGroup());
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        showCurrentGroup() {
            const vue = this;
            const clientId = this.selectedItem.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/group/${clientId}/show`).then(function (response) {
                if (response.data[0] != null) {
                    vue.form.group = response.data[0];
                }
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        submit() {
            this.$emit('submit', this.form, this.$refs.close);
        },
        clearData() {
            this.form = {
                group: '',
            };
        }
    }
}
</script>

<style scoped>

</style>
