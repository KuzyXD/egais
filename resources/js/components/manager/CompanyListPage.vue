<template>
  <div class="overflow-hidden">
    <manager-logo></manager-logo>
    <div class="relative flex flex-col items-center justify-center">
      <div class="relative">
        <custom-table v-show="!loading"
                      :actions="[
                          {name: 'delete', text: 'Удалить/восстановить'}
                      ]"
                      :cols="['ID', 'Наименование', 'Тэг', 'Менеджер', 'Создана', 'Обновлена', 'Удалена', 'Действие']"
                      :filters="[
                          {name: 'deleted', text: 'Отобразить удаленные компании'},
                          {name: 'owned', text: 'Отобразить мои компании'},
                      ]"
                      :items="items"
                      text="Добавляйте, удаляйте, изменяйте компании с помощью таблицы. В поиске вы можете использовать данные из любого столбца."
                      title="Список компаний"
                      @delete="deleteCompany"
                      @deleted="this.deleted = !this.deleted"
                      @owned="this.owned = !this.owned"
                      @search="value => this.search = value"
        ></custom-table>
        <pagination v-show="!loading" class="flex justify-end my-3"
                    @next="paginationNext"
                    @previous="paginationPrevious"></pagination>
        <skeleton v-show="loading"></skeleton>
      </div>
    </div>

  </div>
</template>

<script>
import {formatYmd} from "../../helper_functions";

export default {
  data() {
    return {
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
      let apiUri = `/api/manager/company/list?page=${this.page}`;

      if (this.search) {
        apiUri += `&search=${this.search}`;
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

          return Object.values(object);
        });

        window.setTimeout(() => {
          vue.loading = false;
        }, 500);

      }).catch(function (error) {
        console.log(error.response);
        alert('Ошибка, обратитесь к программисту.');
      });
    },
    deleteCompany(id) {
      const vue = this;

      axios.delete(`/api/manager/company/${id}/delete`).then(function (response) {
        vue.fetch();
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