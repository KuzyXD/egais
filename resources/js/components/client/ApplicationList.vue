<template>
    <div>

        <div class="flex justify-center">
            <div v-show="!loadingCompanies" class="px-6 pb-8">
                <label class="block px-2 text-lg font-semibold text-left text-gray-900"
                       for="selectCompany">Выберите компанию</label>
                <p class="px-2 pb-2 text-sm text-gray-500">После выбора компании прогрузится список заявок</p>
                <select id="selectCompany" v-model="selectedCompany"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        @change="fetchApplications">
                    <option selected>Выберите компанию здесь</option>
                    <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
                </select>
            </div>
            <skeleton v-show="loadingCompanies" class="col-start-2 col-span-10 w-full"></skeleton>
        </div>
        <div class="flex justify-center">
            <div
                class="px-6 pb-2 overflow-x-auto relative max-w-max">
                <custom-table v-show="!loadingApplications"
                              :actions="[
                                  {name: 'action', text: 'Открыть'},
                                  ]"
                              :cols=cols
                              :filters="[
                                  {name: 'deleted', text: 'Отобразить удаленные заявки'},
                                  ]"
                              :items="items"
                              text="Сюда попадают все созданные заявки. В поиске вы можете использовать данные из любого столбца."
                              title="Список заявок для компании"
                              @action="goToSignedRoute"
                              @deleted="this.deleted = !this.deleted"
                              @search="value => this.search = value"
                              @sorted="this.fetchApplications"
                ></custom-table>
                <pagination v-show="!loadingApplications" class="flex justify-start mt-3"
                            @next="paginationNext"
                            @previous="paginationPrevious">
                    <a ref="redirect-to-signed-route-ref"
                       class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       href=""
                       target='_blank'>
                        Отобразить форму авторизации для АЦ
                    </a>
                </pagination>
            </div>
        </div>
    </div>

</template>

<script>
import {formatYmd, getSortableState} from "../../helper_functions";

export default {
    components: {},
    data() {
        return {
            cols: [
                {name: 'ID', key: 'id', sortable: true, sortableState: 'desc'},
                {name: 'Статус', key: 'status', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Комментарий', key: 'comment', sortable: true, sortableState: 'normal', width: '52'},
                {
                    name: 'Серийный номер сертификата',
                    key: 'serial_number_certificate',
                    sortable: false,
                    sortableState: 'normal', width: '52'
                },
                {
                    name: 'Действительный с',
                    key: 'certificate_produced_at',
                    sortable: true,
                    sortableState: 'normal',
                    width: '52'
                },
                {
                    name: 'Действительный по',
                    key: 'certificate_finished_at',
                    sortable: true,
                    sortableState: 'normal',
                    width: '52'
                },
                {
                    name: 'С/Н сертификата для замены',
                    key: 'replace_serial_key',
                    sortable: true,
                    sortableState: 'normal', width: '52'
                },
                {name: 'Создана', key: 'created_at', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Удалена', key: 'deleted_at', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Действия', key: 'actions', sortable: false, sortableState: 'normal', width: '52'}
            ],
            items: [],
            loadingApplications: true,
            loadingCompanies: true,

            deleted: false,
            search: '',
            page: 1,
            last_page: 1,

            selectedItem: {},
            selectedCompany: 'Выберите компанию здесь',
            companies: [],
        }
    },
    methods: {
        fetchCompanies() {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            let apiUri = `/api/${apiLocation}/company/list`;

            axios.get(apiUri).then(function (response) {
                vue.companies = response.data;

                window.setTimeout(() => {
                    vue.loadingCompanies = false;
                }, 500);
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        fetchApplications() {
            if (typeof this.selectedCompany == 'string') {
                return;
            }

            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            let apiUri = `/api/${apiLocation}/company/${this.selectedCompany}/application/list?page=${this.page}`;

            if (this.search) {
                apiUri += `&search=${this.search}`;
            }

            const sortableCols = this.cols.filter(getSortableState);
            if (sortableCols.length > 0) {
                apiUri += '&sort='
                for (let i = 0; i < sortableCols.length; i++) {
                    apiUri += `${sortableCols[i].key},${sortableCols[i].sortableState}`
                    if (!((i + 1) >= sortableCols.length)) {
                        apiUri += ';'
                    }
                }
            }

            apiUri += `&deleted=${this.deleted}`

            axios.get(apiUri).then(function (response) {
                vue.last_page = response.data.meta.last_page
                vue.items = response.data.data.map(function (object) {
                    if (object.certificate_produced_at) {
                        object.certificate_produced_at = formatYmd(new Date(object.certificate_produced_at));
                    }
                    if (object.certificate_finished_at) {
                        object.certificate_finished_at = formatYmd(new Date(object.certificate_finished_at));
                    }

                    object.created_at = formatYmd(new Date(object.created_at));
                    //object.updated_at = formatYmd(new Date(object.updated_at));
                    if (object.deleted_at) {
                        object.deleted_at = formatYmd(new Date(object.deleted_at));
                    }

                    return object;
                });

                window.setTimeout(() => {
                    vue.loadingApplications = false;
                }, 500);

            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        deleteApplication(item) {
            const vue = this;
            const applicationId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.delete(`/api/${apiLocation}/application/${applicationId}/delete`).then(function (response) {
                vue.fetchApplications();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        goToSignedRoute(item) {
            const applicationId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            this.$refs["redirect-to-signed-route-ref"].href = `/api/${apiLocation}/application/${applicationId}/getsignedroute`
            this.$refs["redirect-to-signed-route-ref"].click();
        },
        paginationNext() {
            if ((this.page + 1) <= this.last_page) {
                this.page += 1;
                this.fetchApplications();
            }
        },
        paginationPrevious() {
            if ((this.page - 1) >= 1) {
                this.page -= 1;
                this.fetchApplications();
            }
        },
    },
    mounted() {
        this.fetchCompanies();
    },
    watch: {
        deleted() {
            this.fetchApplications();
        },
        search() {
            this.fetchApplications();
        }
    },
}
</script>
