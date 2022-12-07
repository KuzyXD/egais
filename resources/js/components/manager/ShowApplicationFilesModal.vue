<template>
    <div id="show-application-files-modal" ref="modal" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex items-start"
         tabindex="-1">
        <a ref="renew" href="#" @click.prevent="fetch">Обновить</a>
        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button
                    ref="close"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="show-application-files-modal"
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
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Прикрепите файлы для заявления:</h3>
                    <form action="#" class="space-y-4">

                        <application-file-fields ref="applicationFileFields"
                                                 @filesInput="(incomingFiles) => this.files = incomingFiles"></application-file-fields>

                        <p class="text-sm text-gray-500">Разрешена загрузка файлов до 5 Мб.</p>
                        <button
                            class="w-full focus:outline-none text-white bg-green-500 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
                            type="button" @click="sendFiles">
                            Отправить
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Отображение загруженных файлов:</h3>
                    <div class="space-y-4">

                        <show-uploaded-files v-for="file in uploadedFiles" :id="file.id" :name="file.name"
                                             :type="file.type" @delete="deleteFile"
                                             @download="downloadFile"></show-uploaded-files>

                        <div id="alert-3" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800"
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      fill-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                                Загрузите сюда файлы из окна слева или воспользуйтесь кнопка
                                "автозагрузки из шаблона".
                            </div>
                        </div>
                    </div>
                    <button
                        class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button" @click="getTemplateFiles">
                        Автозагрузка из шаблона
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ShowUploadedFiles from "./TemplatesForm/ShowUploadedFiles";
import fileDownload from "js-file-download";
import ApplicationFileFields from "./ApplicationFileFields";

export default {
    components: {ApplicationFileFields, ShowUploadedFiles},
    props: ['selectedItem'],
    data() {
        return {
            files: undefined,
            uploadedFiles: [],
        }
    },
    methods: {
        fetch() {
            const vue = this;
            const applicationID = this.selectedItem.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${applicationID}/files/index`).then(function (response) {
                vue.uploadedFiles = response.data;
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        sendFiles() {
            const vue = this;
            const applicationID = this.selectedItem.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);


            for (const [key, value] of Object.entries(this.files)) {
                if (!value) continue;

                let formData = new FormData();
                formData.append('type', key);
                formData.append('file', value);


                axios.post(`/api/${apiLocation}/application/${applicationID}/files/store`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    vue.fetch();
                    alert('Успешно');
                }).catch(function (error) {
                    console.log(error.response);
                    alert('Ошибка, обратитесь к программисту.');
                });
            }
        },
        downloadFile(fileId) {
            const vue = this;
            const regex = /\w+-\w+/;
            const applicationID = this.selectedItem.id;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${applicationID}/files/${fileId}/show`, {responseType: "blob"}).then(function (response) {
                const fileDownload = require('js-file-download')
                fileDownload(response.data, vue.getFileNameFromResponse(response))
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        getFileNameFromResponse(response) {
            const disposition = response.headers['content-disposition']
            return disposition.split('filename=')[1].split(';')[0];
        },
        deleteFile(fileId) {
            const vue = this;
            const regex = /\w+-\w+/;
            const applicationID = this.selectedItem.id;
            const apiLocation = regex.exec(window.location.pathname);

            axios.delete(`/api/${apiLocation}/application/${applicationID}/files/${fileId}/delete`, {responseType: "blob"}).then(function (response) {
                vue.fetch();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        getTemplateFiles() {
            const vue = this;
            const applicationID = this.selectedItem.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${applicationID}/files/template/getfiles`).then(function (response) {
                vue.$nextTick(() => vue.fetch());
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        clearData() {
            this.$refs.applicationFileFields.clearData();
        },
    },
}
</script>

