<template>
    <div class="overflow-hidden">
        <div class="relative flex flex-col items-center justify-center">
            <div class="relative max-w-7xl">
                <custom-table v-show="!loading"
                              :actions="[
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
                              @delete="deleteCompany"
                              @deleted="this.deleted = !this.deleted"
                              @owned="this.owned = !this.owned"
                              @search="value => this.search = value"
                              @sorted="this.fetch"
                ></custom-table>
                <pagination v-show="!loading" class="flex justify-end mt-3"
                            @next="paginationNext"
                            @previous="paginationPrevious">
                    <!--                    <a class="inline-flex bg-green-500 text-white items-center py-2 px-4 text-sm font-medium bg-white rounded-lg border border-gray-300 focus:ring-4"-->
                    <!--                       data-modal-toggle="create-company-model" href="#" @click.prevent="">-->
                    <!--                        Создать компанию-->
                    <!--                    </a>-->
                </pagination>
                <skeleton v-show="loading"></skeleton>
            </div>
        </div>
        <!--        <create-company-modal @submit="create"></create-company-modal>-->
    </div>
</template>

<script>
import {getSortableState, formatYmd} from "../../helper_functions";

export default {
    components: {},
    data() {
        return {
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
            ],
            items: [],
            loading: true,

            deleted: false,
            owned: false,
            search: '',
            page: 1,
            last_page: 1,
        }
    },
    methods: {
        fetch() {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);
            let apiUri = `/api/${apiLocation}/company/list?page=${this.page}`;

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
        deleteCompany(item) {
            const vue = this;
            const companyId = item.id;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.delete(`/api/${apiLocation}/company/${companyId}/delete`).then(function (response) {
                vue.fetch();
                alert('Успешно');
            }).catch(function (error) {
                console.log(error.response);
                alert('Ошибка, обратитесь к программисту.');
            });
        },
        create(form) {
            const vue = this;
            const regex = /\w+-\w+/;
            const apiLocation = regex.exec(window.location.pathname);

            axios.post(`/api/${apiLocation}/company/store`, form).then(function (response) {
                vue.fetch();
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
        redirectToTemplates(item) {
            const companyId = item.id;
            window.location.href += `/${companyId}/templates`;
        }
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
