<template>
    <div class="px-6 pb-2 overflow-x-auto relative max-w-max">
        <custom-table v-show="!loading" :actions="[
                              {name: 'open_in_lk', text: 'Открыть в ЛК'},
                              {name: 'show_files', text: 'Файлы'},
                              {name: 'send_docs', text: 'Отправить документы'},
                              {name: 'send_request', text: 'Отправить запрос'},
                              {name: 'change_status', text: 'Сменить статус'},
                              {name: 'delete', text: 'Удалить/восстановить'},
                          ]"
                      :cols=cols
                      :filters="[
                              {name: 'deleted', text: 'Отобразить удаленные заявки'},
                              {name: 'owned', text: 'Отобразить мои заявки'},
                          ]"
                      :items="items"
                      text="Сюда попадают все созданные заявки. В поиске вы можете использовать данные из любого столбца."
                      title="Список заявок"
                      @delete="deleteApplication"
                      @deleted="this.deleted = !this.deleted"
                      @open_in_lk="open_in_lk"
                      @owned="this.owned = !this.owned"
                      @search="value => this.search = value"
                      @show_files="showFilesModal"
                      @sorted="this.fetch"
                      @send_docs="sendDocs"
                      @send_request="sendRequest"
                      @change_status="showChangeStatusModal"
        ></custom-table>
        <pagination v-show="!loading" class="flex justify-start mt-3"
                    @next="paginationNext"
                    @previous="paginationPrevious">
            <a ref="show-application-files-modal-ref"
               class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
               data-modal-toggle="show-application-files-modal" href="#" @click.prevent="">
                Открыть файлы заявки
            </a>
            <a ref="open_in_lk-ref" :href="'https://lk.iecp.ru/application/' + selectedItem.ac_id"
               class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
               target='_blank'>
                Открыть в АЦ
            </a>
            <a ref="show-change-status-modal-ref"
               class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
               data-modal-toggle="show-change-status-modal" href="#" @click.prevent="">
                Открыть смену статусов у заявки
            </a>
        </pagination>
        <show-application-files-modal ref="show-application-files-modal"
                                      :selected-item="selectedItem"></show-application-files-modal>
        <change-status-modal ref="show-change-status-modal" :selected-item="selectedItem" @submit="changeStatus"></change-status-modal>
        <skeleton v-show="loading"></skeleton>
    </div>
</template>

<script>
import {formatYmd, getSortableState} from "../../helper_functions";
import ShowApplicationFilesModal from "./ShowApplicationFilesModal";
import ChangeStatusModal from "./ChangeStatusModal";

export default {
    components: {ShowApplicationFilesModal, ChangeStatusModal},
    data() {
        return {
            cols: [
                {name: 'ID', key: 'id', sortable: true, sortableState: 'desc'},
                {name: 'ID в АЦ', key: 'ac_id', sortable: true, sortableState: 'normal'},
                {name: 'Статус', key: 'status', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Пин-код', key: 'pin_code', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Комментарий', key: 'comment', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Номер шаблона', key: 'template_id', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Номер магазина', key: 'store_number', sortable: true, sortableState: 'normal', width: '52'},
                {name: 'Тип действия', key: 'action_type', sortable: true, sortableState: 'normal', width: '52'},
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
            loading: true,

            deleted: false,
            owned: false,
            search: '',
            page: 1,
            last_page: 1,

            selectedItem: {}
        }
    },
    methods: {
        fetch() {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            let apiUri = `/api/${apiLocation}/application/index?page=${this.page}`;

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
            apiUri += `&owned=${this.owned}`

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
                    vue.loading = false;
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
                vue.fetch();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        sendDocs(item) {
            const vue = this;
            const applicationId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${applicationId}/senddocs`).then(function (response) {
                vue.fetch();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        sendRequest(item) {
            const vue = this;
            const applicationId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.get(`/api/${apiLocation}/application/${applicationId}/sendrequest`).then(function (response) {
                vue.fetch();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        showFilesModal(item) {
            this.selectedItem = item;
            this.$refs['show-application-files-modal-ref'].click();
            this.$nextTick(() => this.$refs['show-application-files-modal'].$refs.renew.click());
        },
        open_in_lk(item) {
            this.selectedItem = item;
            this.$refs['open_in_lk-ref'].click();
        },
        showChangeStatusModal(item) {
            this.selectedItem = item;
            this.$refs['show-change-status-modal-ref'].click();
            this.$nextTick(() => this.$refs['show-change-status-modal'].$refs.renew.click());
        },
        changeStatus(form, closeButton) {
            const vue = this;
            const regex = /\w+-\w+/;
            const applicationId = this.selectedItem.id;
            const apiLocation = regex.exec(window.location.pathname);

            axios.post(`/api/${apiLocation}/application/${applicationId}/changestatus`, form).then(function (response) {
                vue.fetch();
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        paginationNext() {
            if ((this.page + 1) <= this.last_page) {
                this.page += 1;
                this.fetch();
            }
        },
        paginationPrevious() {
            if ((this.page - 1) >= 1) {
                this.page -= 1;
                this.fetch();
            }
        },
    },
    mounted() {
        this.fetch();
    },
    watch: {
        deleted() {
            this.fetch();
        },
        search() {
            this.fetch();
        },
        owned() {
            this.fetch();
        }
    },
}
</script>

<style scoped>

</style>
