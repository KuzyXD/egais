<template>
    <div class="overflow-hidden">
        <div class="relative flex flex-col items-center justify-center">
            <div class="overflow-x-auto relative">
                <custom-table
                    :actions="[
                {name: 'delete', text: 'Удалить'}
                ]"
                    :cols="['ID', 'Фамилия, имя и отчество', 'Серийный номер сертификата', 'Сертификат действует до', 'Действие']"
                    :items="[[1, 'КИО', '123', '15.09.2022'],]"
                    text="Добавляйте, удаляйте, изменяйте клиентов с помощью таблицы. В поиске вы можете использовать данные из любого столбца."
                    title="Список клиентов"
                ></custom-table>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [],
        }
    },
    methods: {
        fetch() {

        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
