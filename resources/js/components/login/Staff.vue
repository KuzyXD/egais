<template>
    <div>
        <div
            class="relative flex flex-col items-center justify-center py-12 lg:py-6">
            <logo></logo>
            <div
                class="w-1/3 max-w-md p-6 bg-white border border-gray-200 shadow-md  md:rounded-lg lg:p-8">
                <form class="space-y-6" @submit.prevent="login">
                    <h5 class="text-2xl font-medium text-center text-black">
                        Вход для сотрудников
                    </h5>
                    <div>
                        <label
                            class="block mb-2 text-sm font-medium text-gray-900"
                            for="email"
                        >Почта</label
                        >
                        <input
                            id="email"
                            v-model="email"
                            class="
								bg-gray-50
								border border-gray-300
								text-gray-900 text-sm
								rounded-lg
								focus:ring-blue-500 focus:border-blue-500
								block
								w-full
								p-2.5
							"
                            name="email"
                            placeholder="placeholder@yandex.ru"
                            required="true"/>
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-sm font-medium text-gray-900"
                            for="password"
                        >Пароль</label
                        >
                        <input
                            id="password"
                            v-model="password"
                            class="
								bg-gray-50
								border border-gray-300
								text-gray-900 text-sm
								rounded-lg
								focus:ring-blue-500 focus:border-blue-500
								block
								w-full
								p-2.5
							"
                            name="password"
                            placeholder="••••••••"
                            required="true"
                            type="password"/>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input
                                    id="remember"
                                    aria-describedby="remember"
                                    class="w-4 h-4 border border-gray-300 rounded  bg-gray-50 focus:ring-3 focus:ring-blue-300"
                                    type="checkbox"/>
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-900" for="remember"
                                >Запомнить меня</label
                                >
                            </div>
                        </div>
                    </div>
                    <button
                        class="
							w-full
							text-white
							bg-light-blue
							focus:ring-4 focus:outline-none focus:ring-blue-300
							font-medium
							rounded-lg
							text-sm
							px-5
							py-2.5
							text-center
						"
                        type="submit">
                        Войти
                    </button>
                </form>
            </div>
            <div
                id="alert-2"
                class="absolute flex hidden p-4 mt-4 transition-opacity duration-300 ease-out bg-red-100 rounded-lg opacity-0 -bottom-10 dark:bg-red-200"
                role="alert">
                <svg
                    aria-hidden="true"
                    class="flex-shrink-0 w-5 h-5 text-red-700 dark:text-red-800"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        clip-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        fill-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div class="mx-3 text-sm font-medium text-red-700 dark:text-red-800">
                    <span class="font-semibold">Ошибка! </span> {{ errorText }}
                </div>
                <button
                    aria-label="Close"
                    class="
						ml-auto
						-mx-1.5
						-my-1.5
						bg-red-100
						text-red-500
						rounded-lg
						focus:ring-2 focus:ring-red-400
						p-1.5
						hover:bg-red-200
						inline-flex
						h-8
						w-8
						dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300
					"
                    data-dismiss-target="#alert-2"
                    type="button">
                    <span class="sr-only">Close</span>
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            clip-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            fill-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'StaffLogin',
    props: ['logo'],
    data() {
        return {
            email: '',
            password: '',
            errorText: ''
        };
    },
    methods: {
        login() {
            const vue = this;
            const apiLocation = window.location.pathname.slice(1);

            axios.get('/sanctum/csrf-cookie').then((response) => {
                axios
                    .post(`/api/${apiLocation}`, {
                        email: vue.email,
                        password: vue.password
                    })
                    .then((loginResponse) => {
                        window.location.href = 'dashboard';
                    })
                    .catch((error) => {
                        console.log(error.response);
                        vue.errorText = error.response.data;
                        vue.showError();
                    });
            });
        },
        showError() {
            const targetEl = document.getElementById('alert-2');
            targetEl.classList.remove('opacity-0');
            targetEl.classList.remove('hidden');
        }
    }
};
</script>

<style scoped>
</style>
