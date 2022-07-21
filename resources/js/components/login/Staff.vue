<template>
	<div class="min-h-screen overflow-hidden bg-gray-50">
		<div
			class="relative flex flex-col items-center justify-center min-h-screen py-12  lg:py-6">
			<div class="p-5">
				<span class="text-green text-7xl">ПНК.</span>
				<span class="text-light-blue text-7xl">ЕГАИС</span>
			</div>
			<div
				class="w-1/3 max-w-md p-6 bg-white border border-gray-200 shadow-md  md:rounded-lg lg:p-8">
				<form class="space-y-6" @submit.prevent="login">
					<h5 class="text-2xl font-medium text-center text-black">
						Вход для сотрудников
					</h5>
					<div>
						<label
							for="name"
							class="block mb-2 text-sm font-medium text-gray-900"
							>Имя пользователя</label
						>
						<input
							name="name"
							id="name"
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
							placeholder="kio"
							required="true"
							v-model="name" />
					</div>
					<div>
						<label
							for="password"
							class="block mb-2 text-sm font-medium text-gray-900"
							>Пароль</label
						>
						<input
							type="password"
							name="password"
							id="password"
							placeholder="••••••••"
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
							required="true"
							v-model="password" />
					</div>
					<div class="flex items-start">
						<div class="flex items-start">
							<div class="flex items-center h-5">
								<input
									id="remember"
									aria-describedby="remember"
									type="checkbox"
									class="w-4 h-4 border border-gray-300 rounded  bg-gray-50 focus:ring-3 focus:ring-blue-300" />
							</div>
							<div class="ml-3 text-sm">
								<label for="remember" class="font-medium text-gray-900"
									>Запомнить меня</label
								>
							</div>
						</div>
					</div>
					<button
						type="submit"
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
						">
						Войти
					</button>
				</form>
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
			name: '',
			password: ''
		};
	},
	methods: {
		login() {
			const vue = this;

			axios.get('/sanctum/csrf-cookie').then((response) => {
				console.log(response);
				axios
					.post('api/login', {
						name: vue.name,
						password: vue.password
					})
					.then((loginResponse) => {
						console.log(loginResponse);
					})
					.catch((error) => {
						console.log(error.response.data);
					});
			});
		}
	}
};
</script>

<style scoped>
</style>
