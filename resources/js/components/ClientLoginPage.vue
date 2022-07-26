<template>
	<div class="min-h-screen">
		<crypto-pro-setup></crypto-pro-setup>
		<client-login :logo="logo"></client-login>
	</div>
</template>

<script>
export default {
	props: ['logo']
};
</script>

<style>
</style>


