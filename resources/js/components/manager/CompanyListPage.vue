<template>
  <div class="overflow-hidden">
    <manager-logo></manager-logo>
    <div class="relative flex flex-col items-center justify-center">
      <div class="overflow-x-auto relative">
        <custom-table
            :actions="[
                {name: 'delete', text: 'Удалить'}
                ]"
            :cols="['ID', 'Наименование', 'Тэг', 'Менеджер', 'Создана', 'Обновлена', 'Действие']"
            :items="items"
            text="Добавляйте, удаляйте, изменяйте компании с помощью таблицы. В поиске вы можете использовать данные из любого столбца."
            title="Список компаний"
        ></custom-table>
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
    }
  },
  methods: {
    fetch() {
      const vue = this;

      axios.get('/api/manager/company/list?page=1').then(function (response1) {
        vue.items = response1.data.data.map(function (object) {
          object.created_at = formatYmd(new Date(object.created_at));
          object.updated_at = formatYmd(new Date(object.updated_at));

          return Object.values(object);
        });
      });


    }
  },
  mounted() {
    this.fetch();
  }
}
</script>

<style scoped>

</style>