<template>
    <div class="">
        <div class="relative flex flex-col items-center justify-center">
            <div class="relative max-w-8xl">
                <custom-table v-show="!loading"
                              :actions="[
                                  {name: 'update', text: 'Изменить'},
                                  {name: 'update_group', text: 'Изменить доступ к группе'},
                                  {name: 'delete', text: 'Удалить/восстановить'},
                              ]"
                              :cols=cols
                              :filters="[
                                  {name: 'deleted', text: 'Отобразить удаленных клиентов'},
                              ]"
                              :items="items"
                              text="Добавляйте, удаляйте, клиентов с помощью таблицы. В поиске вы можете использовать данные из любого столбца."
                              title="Список клиентов"
                              @delete="deleteClient"
                              @deleted="this.deleted = !this.deleted"
                              @search="value => this.search = value"
                              @sorted="this.fetch"
                              @update="showUpdateModal"
                              @update_group="showUpdateGroupModal"
                ></custom-table>
                <pagination v-show="!loading" class="flex justify-end mt-3"
                            @next="paginationNext"
                            @previous="paginationPrevious">
                    <a class="inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="create-client-modal" href="#" @click.prevent="">
                        Создать клиента
                    </a>
                    <a ref="update-client-modal-href"
                       class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="update-client-modal" href="#" @click.prevent="">
                        Изменить клиента
                    </a>
                    <a ref="update-client-group-modal-href"
                       class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="update-client-group-modal" href="#" @click.prevent="">
                        Изменить клиента
                    </a>
                </pagination>
                <skeleton v-show="loading"></skeleton>
            </div>
        </div>
        <create-client-modal @submit="create"></create-client-modal>
        <update-client-modal ref="update-client-modal" :selected-item="selectedItem"
                             @submit="update"></update-client-modal>
        <update-client-group-modal ref="update-client-group-modal"
                                   :selected-item="selectedItem"
                                   @submit="updateClientGroup"></update-client-group-modal>
    </div>
</template>

<script>
import {formatYmd, getSortableState} from "../../helper_functions";
import CreateClientModal from "./CreateClientModal";
import UpdateClientModal from "./UpdateClientModal";
import UpdateClientGroupModal from "./UpdateClientGroupModal";

export default {
    components: {CreateClientModal, UpdateClientModal, UpdateClientGroupModal},
    data() {
        return {
            cols: [
                {name: 'ID', key: 'id', sortable: true, sortableState: 'desc'},
                {name: 'ФИО', key: 'fio', sortable: true, sortableState: 'normal'},
                {name: 'Группа', key: 'group', sortable: true, sortableState: 'normal'},
                {
                    name: 'Серийный номер сертификта',
                    key: 'certificate_serial_number',
                    sortable: true,
                    sortableState: 'normal'
                },
                {
                    name: 'Дата окончания сертификата',
                    key: 'certificate_expire_to_date',
                    sortable: true,
                    sortableState: 'normal'
                },
                {name: 'Заметка', key: 'note', sortable: true, sortableState: 'normal'},
                {name: 'Создан', key: 'created_at', sortable: true, sortableState: 'normal'},
                {name: 'Обновлен', key: 'update_at', sortable: true, sortableState: 'normal'},
                {name: 'Удален', key: 'deleted_at', sortable: true, sortableState: 'normal'},
                {name: 'Действия', key: 'actions', sortable: false, sortableState: 'normal'}
            ],
            items: [],
            loading: true,

            deleted: false,
            search: '',
            page: 1,
            last_page: 1,

            selectedItem: {},
        }
    },
    methods: {
        fetch() {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            let apiUri = `/api/${apiLocation}/client/index?page=${this.page}`;

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
                vue.last_page = response.data.last_page;
                vue.items = response.data.data.map(function (object) {
                    object.created_at = formatYmd(new Date(object.created_at));
                    object.updated_at = formatYmd(new Date(object.updated_at));
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
        deleteClient(item) {
            const vue = this;
            const clientId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.delete(`/api/${apiLocation}/client/${clientId}/delete`).then(function (response) {
                vue.fetch();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        create(form, closeButton) {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.post(`/api/${apiLocation}/company/store`, form).then(function (response) {
                vue.fetch();
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                alert((Object.values(error.response.data.errors)).flat().join(', '));
            });
        },
        update(form, closeButton) {
            const vue = this;
            const clientId = this.selectedItem.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.patch(`/api/${apiLocation}/client/${clientId}/update`, form).then(function (response) {
                vue.fetch();
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                alert((Object.values(error.response.data.errors)).flat().join(', '));
            });
        },
        showUpdateModal(item) {
            this.selectedItem = item;
            this.$refs['update-client-modal-href'].click();
            this.$nextTick(() => this.$refs['update-client-modal'].$el.focus());
        },
        updateClientGroup(form, closeButton) {
            const vue = this;
            const clientId = this.selectedItem.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.patch(`/api/${apiLocation}/group/${clientId}/update`, form).then(function (response) {
                vue.fetch();
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                alert((Object.values(error.response.data.errors)).flat().join(', '));
            });
        },
        showUpdateGroupModal(item) {
            this.selectedItem = item;
            this.$refs['update-client-group-modal-href'].click();
            this.$nextTick(() => this.$refs['update-client-group-modal'].$el.focus());
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
    },
}
</script>

<style scoped>

</style>
