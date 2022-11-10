<template>
    <div class="grid grid-cols-4 gap-2">
        <TemplateInput id="BasisOfActs"
                       v-model="form.BasisOfActs" :required="true"
                       name="Действует на основании"
                       placeholder="устава" type="text">
        </TemplateInput>
        <TemplateSelect id="identificationKind" v-model="form.identificationKind"
                        :options="[
                            {name: 'Лично', value: 0},
                            {name: 'По действующей ЭП', value: 1}
                            ]" name="Способ идентификации" required="true">
        </TemplateSelect>
        <TemplateInput id="lastName"
                       v-model="form.lastName" :required="true"
                       name="Фамилия"
                       type="text">
        </TemplateInput>
        <TemplateInput id="firstName"
                       v-model="form.firstName" :required="true"
                       name="Имя"
                       type="text">
        </TemplateInput>
        <TemplateInput id="middleName"
                       v-model="form.middleName" :required="false"
                       name="Отчество"
                       placeholder="Необязательное поле"
                       type="text">
        </TemplateInput>
        <TemplateSelect id="gender" v-model="form.gender"
                        :options="[
                            {name: 'Мужчина', value: 'M'},
                            {name: 'Женщина', value: 'F'},
                            {name: 'Не указан', value: 'U'}
                            ]" name="Пол" required="true">
        </TemplateSelect>
        <TemplateInput id="birthDate"
                       v-model="form.birthDate" :required="true"
                       name="Дата рождения"
                       pattern="dd-mm-yyyy"
                       type="date">
        </TemplateInput>
        <TemplateInput id="position"
                       v-model="form.position" :required="true"
                       name="Должность"
                       type="text">
        </TemplateInput>
        <TemplateInput id="department"
                       v-model="form.department" :required="false"
                       name="Подразделение/отдел"
                       placeholder="Необязательное поле"
                       type="text">
        </TemplateInput>
        <TemplateInput id="email"
                       v-model="form.email" :required="true"
                       name="Электронная почта"
                       type="email">
        </TemplateInput>
        <TemplateInput id="phone"
                       v-model="form.phone" :required="true"
                       name="Телефон"
                       type="text">
        </TemplateInput>
        <TemplateInput id="passportSerial"
                       v-model="form.passportSerial" :required="true"
                       name="Серия паспорта"
                       type="text">
        </TemplateInput>
        <TemplateInput id="passportNumber"
                       v-model="form.passportNumber" :required="true"
                       name="Номер паспорта"
                       type="text">
        </TemplateInput>
        <TemplateInput id="passportDate"
                       v-model="form.passportDate" :required="true"
                       name="Дата выдачи паспорта"
                       pattern="dd-mm-yyyy"
                       type="date">
        </TemplateInput>
        <TemplateInput id="passportDivision"
                       v-model="form.passportDivision" :required="true"
                       name="Кем выдан паспорт"
                       type="text">
        </TemplateInput>
        <TemplateInput id="passportCode"
                       v-model="form.passportCode" :required="true"
                       name="Код подразделения паспорта"
                       type="text">
        </TemplateInput>
        <TemplateInput id="snils"
                       v-model="form.snils" :required="true"
                       name="СНИЛС"
                       type="text">
        </TemplateInput>
        <TemplateInput id="personInn"
                       v-model="form.personInn" :required="true"
                       name="ИНН заявителя"
                       type="text">
        </TemplateInput>
        <TemplateInput id="ogrn"
                       v-model="form.ogrn" :required="true"
                       name="ОГРН"
                       type="text">
        </TemplateInput>

        <TemplateInput id="company"
                       v-model="form.company" :required="true"
                       name="Наименование организации"
                       type="text">
        </TemplateInput>
        <TemplateInput id="inn"
                       v-model="form.inn" :required="true"
                       name="ИНН организации"
                       type="text">
        </TemplateInput>
        <TemplateInput id="kpp"
                       v-model="form.kpp" :required="true"
                       name="КПП организации"
                       type="text">
        </TemplateInput>
        <TemplateInput id="companyPhone"
                       v-model="form.companyPhone" :required="true"
                       name="Телефон организации"
                       type="text">
        </TemplateInput>


        <TemplateSelect id="region"
                        v-model="form.region" :options="regionList"
                        :required="true"
                        name="Регион">
        </TemplateSelect>
        <TemplateInput id="city"
                       v-model="form.city" :required="true"
                       name="Населенный пункт"
                       type="text">
        </TemplateInput>
        <TemplateInput id="address"
                       v-model="form.address" :required="true"
                       name="Адрес (ЕГРЮЛ) начиная с улицы"
                       type="text">
        </TemplateInput>
        <TemplateInput id="index"
                       v-model="form.index" :required="true"
                       name="Индекс"
                       type="text">
        </TemplateInput>


        <TemplateInput id="headLastName"
                       v-model="form.headLastName" :required="true"
                       name="Фамилия руководителя"
                       type="text">
        </TemplateInput>
        <TemplateInput id="headFirstName"
                       v-model="form.headFirstName" :required="true"
                       name="Имя руководителя"
                       type="text">
        </TemplateInput>
        <TemplateInput id="headMiddleName"
                       v-model="form.headMiddleName" :required="false"
                       name="Отчество руководителя"
                       placeholder="Необязательное поле"
                       type="text">
        </TemplateInput>
        <TemplateInput id="HeadPosition"
                       v-model="form.HeadPosition" :required="true"
                       name="Должность руководителя"
                       type="text">
        </TemplateInput>
        <TemplateSelect id="offerJoining"
                        v-model="form.offerJoining" :options="[
                            {name: 'Есть', value: true},
                            {name: 'Нет', value: false},
                            ]"
                        :required="true"
                        name="Присоединение к оферте">
        </TemplateSelect>
        <TemplateInput id="products"
                       v-model="form.products" :required="true"
                       name="Продукты"
                       type="text">
        </TemplateInput>
    </div>
</template>
<script>
import TemplateInput from "./Input"
import TemplateSelect from "./Select"

export default {
    data() {
        return {
            regionList: [
                {value: 1, name: "1 Республика Адыгея (Адыгея)"},
                {value: 2, name: "2 Республика Башкортостан"},
                {value: 3, name: "3 Республика Бурятия"},
                {value: 4, name: "4 Республика Алтай"},
                {value: 5, name: "5 Республика Дагестан"},
                {value: 6, name: "6 Республика Ингушетия"},
                {value: 7, name: "7 Кабардино-Балкарская Республика"},
                {value: 8, name: "8 Республика Калмыкия"},
                {value: 9, name: "9 Карачаево-Черкесская Республика"},
                {value: 10, name: "10 Республика Карелия"},
                {value: 11, name: "11 Республика Коми"},
                {value: 12, name: "12 Республика Марий Эл"},
                {value: 13, name: "13 Республика Мордовия"},
                {value: 14, name: "14 Республика Саха (Якутия)"},
                {value: 15, name: "15 Республика Северная Осетия - Алания"},
                {value: 16, name: "16 Республика Татарстан (Татарстан)"},
                {value: 17, name: "17 Республика Тыва"},
                {value: 18, name: "18 Удмуртская Республика"},
                {value: 19, name: "19 Республика Хакасия"},
                {value: 20, name: "20 Чеченская Республика"},
                {value: 21, name: "21 Чувашская Республика - Чувашия"},
                {value: 22, name: "22 Алтайский край"},
                {value: 23, name: "23 Краснодарский край"},
                {value: 24, name: "24 Красноярский край"},
                {value: 25, name: "25 Приморский край"},
                {value: 26, name: "26 Ставропольский край"},
                {value: 27, name: "27 Хабаровский край"},
                {value: 28, name: "28 Амурская область"},
                {value: 29, name: "29 Архангельская область"},
                {value: 30, name: "30 Астраханская область"},
                {value: 31, name: "31 Белгородская область"},
                {value: 32, name: "32 Брянская область"},
                {value: 33, name: "33 Владимирская область"},
                {value: 34, name: "34 Волгоградская область"},
                {value: 35, name: "35 Вологодская область"},
                {value: 36, name: "36 Воронежская область"},
                {value: 37, name: "37 Ивановская область"},
                {value: 38, name: "38 Иркутская область"},
                {value: 39, name: "39 Калининградская область"},
                {value: 40, name: "40 Калужская область"},
                {value: 41, name: "41 Камчатский край"},
                {value: 42, name: "42 Кемеровская область"},
                {value: 43, name: "43 Кировская область"},
                {value: 44, name: "44 Костромская область"},
                {value: 45, name: "45 Курганская область"},
                {value: 46, name: "46 Курская область"},
                {value: 47, name: "47 Ленинградская область"},
                {value: 48, name: "48 Липецкая область"},
                {value: 49, name: "49 Магаданская область"},
                {value: 50, name: "50 Московская область"},
                {value: 51, name: "51 Мурманская область"},
                {value: 52, name: "52 Нижегородская область"},
                {value: 53, name: "53 Новгородская область"},
                {value: 54, name: "54 Новосибирская область"},
                {value: 55, name: "55 Омская область"},
                {value: 56, name: "56 Оренбургская область"},
                {value: 57, name: "57 Орловская область"},
                {value: 58, name: "58 Пензенская область"},
                {value: 59, name: "59 Пермский край"},
                {value: 60, name: "60 Псковская область"},
                {value: 61, name: "61 Ростовская область"},
                {value: 62, name: "62 Рязанская область"},
                {value: 63, name: "63 Самарская область"},
                {value: 64, name: "64 Саратовская область"},
                {value: 65, name: "65 Сахалинская область"},
                {value: 66, name: "66 Свердловская область"},
                {value: 67, name: "67 Смоленская область"},
                {value: 68, name: "68 Тамбовская область"},
                {value: 69, name: "69 Тверская область"},
                {value: 70, name: "70 Томская область"},
                {value: 71, name: "71 Тульская область"},
                {value: 72, name: "72 Тюменская область"},
                {value: 73, name: "73 Ульяновская область"},
                {value: 74, name: "74 Челябинская область"},
                {value: 75, name: "75 Забайкальский край"},
                {value: 76, name: "76 Ярославская область"},
                {value: 77, name: "77 г. Москва"},
                {value: 78, name: "78 Санкт-Петербург"},
                {value: 79, name: "79 Еврейская автономная область"},
                {value: 83, name: "83 Ненецкий автономный округ"},
                {value: 86, name: "86 Ханты-Мансийский автономный округ - Югра"},
                {value: 87, name: "87 Чукотский автономный округ"},
                {value: 89, name: "89 Ямало-Ненецкий автономный округ"},
                {value: 91, name: "91 Республика Крым"},
                {value: 92, name: "92 Севастополь"}
            ]
        }
    },
    components: {TemplateInput, TemplateSelect},
    props: ['modelValue'],
    emits: ['update:modelValue'],
    computed: {
        form: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            }
        }
    },
}
</script>
