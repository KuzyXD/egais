<template>
    <div>
        <div class="flex justify-center">
            <skeleton v-show="loading"></skeleton>

            <div v-show="status === -1" class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"
                 role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          fill-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Внимание</span>
                <div>
                    <span class="font-medium">Вы не можете взаимодействовать с заявкой:</span>
                    <ul class="mt-1.5 ml-4 text-red-700 list-disc list-inside">
                        <li>Текущий статус заявки не предусматривает действия от клиента</li>
                        <li>Произошла ошибка программы</li>
                    </ul>
                </div>
            </div>
            <div v-show="status === 0"
                 class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow-md sm:p-6 md:p-8">
                <h1 class="text-lg font-semibold text-gray-900 mb-4">Генерация запроса</h1>
                <p class="text-sm text-gray-400">Нажмите на кнопку снизу, чтобы приступить к созданию контейнера и
                    запроса на сертификат к нему.</p>
                <div class="flex justify-center">
                    <button
                        class="focus:outline-none w-1/2 text-white bg-green-700 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-6"
                        type="button" @click="createRequest">
                        Начать
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Skeleton from "../Skeleton";
import {cadesplugin_request_creation} from "../../cadesplugin_request_creation";
import {cadesplugin_certificate_install} from "../../cadesplugin_certificate_install";

export default {
    name: 'ApplicationAction',
    props: ['applicationid', 'allowedstatuses'],
    components: {Skeleton},
    data() {
        return {
            loading: true,
            status: undefined,
            dn: undefined,
            identificationKind: undefined,
            cadesplugin_request_creation,
            cadesplugin_certificate_install
        }
    },
    methods: {
        fetchStatus() {
            const vue = this;
            const regex = /\w+-\w+/;

            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${this.applicationid}/status`).then(function (response) {
                vue.setStatus(response.data)
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        setStatus(status) {
            setTimeout(() => {
                this.loading = false;
                this.status = this.allowedstatuses.indexOf(status)

                if (this.status >= 0) {
                    this.fetchDn()
                }
            }, 500)
        },
        fetchDn() {
            const vue = this;
            const regex = /\w+-\w+/;

            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${this.applicationid}/dn`).then(function (response) {
                vue.dn = response.data.data.dn;
                vue.identificationKind = response.data.data.IdentificationKind;
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        async createRequest() {
            const fullYear = new Date(Date.now()).getFullYear().toString();
            const containerName = fullYear + this.applicationid;

            const dnString = cadesplugin_request_creation.toDN(this.dn);
            const IdentificationKind = cadesplugin_request_creation.getIdentificationKind(this.identificationKind);

            console.log(containerName, dnString, IdentificationKind)
            const requestString = await cadesplugin_request_creation.createRequest(containerName, dnString, IdentificationKind)
            console.log(await requestString);
        },
        sendRequest() {
            //todo
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.fetchStatus();
        })

    }
}
</script>

<style scoped>

</style>
