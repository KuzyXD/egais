<template>
	<div :class="getStyle">
		<p class="text-3xl text-center">
			{{ getTitle }}
			<span
				class="text-2xl material-icon"
				data-tooltip-target="tooltip-bottom"
				data-tooltip-placement="bottom">
				info
			</span>
		</p>
		<div
			id="tooltip-bottom"
			role="tooltip"
			class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0  tooltip">
			Для работы на этой странице требуется установленный плагин от КриптоПро
			<div class="tooltip-arrow" data-popper-arrow></div>
		</div>
		<div :class="getHelpStyle">
			<a
				href="https://www.cryptopro.ru/products/cades/plugin"
				target="_blank"
				class="font-semibold uppercase hover:underline"
				>Помощь в установке</a
			>
		</div>
	</div>
</template>

<script>
import { cadesplugin_initialization } from '../../cadesplugin_initialization';

export default {
	data() {
		return {
			cadesplugin_initialization
		};
	},
	computed: {
		getTitle() {
			switch (cadesplugin_initialization.state) {
				case 'loaded':
					return 'КриптоПро плагин загружен';
				case 'error':
					return 'Ошибка при загрузке КриптоПро';
				default:
					return 'Попытка загрузить КриптоПро плагин';
			}
		},
		getStyle() {
			switch (cadesplugin_initialization.state) {
				case 'loaded':
					return 'relative w-full p-10 mb-4 text-white bg-green-500';
				case 'error':
					return 'relative w-full p-10 mb-4 text-white bg-red-700';
				default:
					return 'relative w-full p-10 mb-4 text-blue-700 bg-blue-100';
			}
		},
		getHelpStyle() {
			switch (cadesplugin_initialization.state) {
				case 'loaded':
					return 'absolute text-white bottom3 left-3';
				case 'error':
					return 'absolute text-white bottom3 left-3';
				default:
					return 'absolute text-blue-700 bottom3 left-3';
			}
		}
	},
	methods: {},
	mounted() {
		cadesplugin_initialization.loadCadesPlugin();
	}
};
</script>

<style>
</style>
