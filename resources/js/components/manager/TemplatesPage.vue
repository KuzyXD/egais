<template>
    <div class="">
        <div class="relative flex flex-col items-center justify-center overflow-x-auto">
            <div class="relative mx-2 pb-14">
                <custom-table v-show="!loading"
                              :actions="[
                                  {name: 'registrate', text: 'Зарегистрировать в АЦ'},
                                  {name: 'update', text: 'Изменить'},
                                  {name: 'files', text: 'Файлы'},
                                  {name: 'delete', text: 'Удалить/восстановить'},
                              ]"
                              :cols=cols
                              :filters="[
                                  {name: 'deleted', text: 'Отобразить удаленные шаблоны'},
                                  {name: 'owned', text: 'Отобразить мои шаблоны'},
                              ]"
                              :items="items"
                              text="Добавляйте, удаляйте, изменяйте шаблоны с помощью таблицы. В поиске вы можете использовать данные из любого столбца."
                              title="Список шаблонов"
                              @delete="deleteTemplate"
                              @deleted="this.deleted = !this.deleted"
                              @files="showFilesModal"
                              @owned="this.owned = !this.owned"
                              @registrate="showACLoginForm"
                              @search="value => this.search = value"
                              @sorted="this.fetch"
                              @update="showUpdateModal"
                >
                </custom-table>
                <pagination v-show="!loading" class="flex justify-end mt-3"
                            @next="paginationNext"
                            @previous="paginationPrevious">
                    <a class="inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="create-ur-template-modal" href="#" @click.prevent="">
                        Создать шаблон юр. лица
                    </a>
                    <a ref="update-ur-template"
                       class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="update-ur-template-modal" href="#" @click.prevent="">
                        Изменить шаблон юр. лица
                    </a>
                    <a ref="show-files"
                       class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="show-files-modal" href="#" @click.prevent="">
                        Отобразить файлы для шаблона заявки
                    </a>
                    <a ref="ac-login"
                       class="hidden inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"
                       data-modal-toggle="ac-login-modal" href="#" @click.prevent="">
                        Отобразить форму авторизации для АЦ
                    </a>
                    <!--                    <a class="inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"-->
                    <!--                       data-modal-toggle="create-template-modal" href="#" @click.prevent="">-->
                    <!--                        Создать шаблон ИП-->
                    <!--                    </a>-->
                    <!--                    <a class="inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"-->
                    <!--                       data-modal-toggle="create-template-modal" href="#" @click.prevent="">-->
                    <!--                        Создать шаблон физ. лица-->
                    <!--                    </a>-->
                </pagination>
                <skeleton v-show="loading"></skeleton>
            </div>
        </div>
        <create-ur-template-modal @submit="create"></create-ur-template-modal>
        <update-ur-template-modal ref="update-ur-template-modal" :selectedItem="selectedItem"
                                  @update="updateTemplate"></update-ur-template-modal>
        <show-files-modal ref="show-files-modal" :selected-item="selectedItem"></show-files-modal>
        <ac-login-modal ref="show-ac-login-modal" @submit="registrateApplication"></ac-login-modal>
    </div>
</template>

<script>
import {getSortableState, formatYmd} from "../../helper_functions";
import CreateUrTemplateModal from "./CreateUrTemplateModal";
import UpdateUrTemplateModal from "./UpdateUrTemplateModal";
import ShowFilesModal from "./ShowTemplateFilesModal";
import AcLoginModal from "./AcLoginModal";

export default {
    components: {ShowFilesModal, CreateUrTemplateModal, UpdateUrTemplateModal, AcLoginModal},
    data() {
        return {
            companyId: 0,
            cols: [
                {name: 'ID', key: 'id', sortable: true, sortableState: 'desc'},
                {name: 'Тип', key: 'type', sortable: true, sortableState: 'normal'},
                {name: 'Заявитель', key: 'applicant_fio', sortable: true, sortableState: 'normal'},
                {name: 'Директор', key: 'head_fio', sortable: true, sortableState: 'normal'},
                {name: 'Продукты', key: 'products', sortable: true, sortableState: 'normal'},
                {name: 'Создавший менеджер', key: 'created_by', sortable: true, sortableState: 'normal'},
                {name: 'Создано', key: 'created_at', sortable: true, sortableState: 'normal'},
                {name: 'Обновлено', key: 'updated_at', sortable: true, sortableState: 'normal'},
                {name: 'Удалено', key: 'deleted_at', sortable: true, sortableState: 'normal'},
                {name: 'Действия', key: 'actions', sortable: false, sortableState: 'normal'},
            ],
            items: [],
            loading: true,

            deleted: false,
            owned: false,
            search: '',
            page: 1,
            last_page: 1,

            selectedItem: [],
        }
    },
    methods: {
        fetch() {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            let apiUri = `/api/${apiLocation}/company/${this.companyId}/templates?page=${this.page}`;

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
        deleteTemplate(item) {
            const vue = this;
            const templateId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.delete(`/api/${apiLocation}/company/templates/${templateId}/delete`).then(function (response) {
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

            axios.post(`/api/${apiLocation}/company/${this.companyId}/templates/store`, form).then(function (response) {
                vue.fetch();
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                alert((Object.values(error.response.data.errors)).flat().join(', '));
            });
        },
        showUpdateModal(item) {
            this.selectedItem = item;
            this.$refs['update-ur-template'].click();
            this.$nextTick(() => this.$refs['update-ur-template-modal'].$refs.renew.click());
        },
        updateTemplate(form, closeButton) {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            const templateId = this.selectedItem.id;

            axios.patch(`/api/${apiLocation}/company/templates/${templateId}/update`, form).then(function (response) {
                vue.fetch();
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                alert((Object.values(error.response.data.errors)).flat().join(', '));
            });
        },
        showFilesModal(item) {
            this.selectedItem = item;
            this.$refs['show-files'].click();
            this.$nextTick(() => this.$refs['show-files-modal'].$refs.renew.click());
        },
        showACLoginForm(item) {
            this.selectedItem = item;
            this.$refs['ac-login'].click();
            this.$nextTick(() => this.$refs['show-ac-login-modal'].$el.focus());
        },
        registrateApplication(form, closeButton) {
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            form['templateId'] = this.selectedItem.id;

            axios.post(`/api/${apiLocation}/application/registrate`, form).then(function (response) {
                closeButton.click();
                alert('Успешно');
            }).catch(function (error) {
                alert((Object.values(error.response.data.errors)).flat().join(', '));
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
        setTheId() {
            const regex = /(?<=companies\/)\d+/;
            this.companyId = regex.exec(window.location.pathname)[0];
        }
    },
    mounted() {
        this.setTheId();
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
