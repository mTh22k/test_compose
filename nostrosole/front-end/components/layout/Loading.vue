<template>
	<v-container
		v-if="props.loading"
		fluid
		class="container ma-0 pa-0 text-center"
	>
		<h2 class="loading-text">Aguarde...</h2>
	</v-container>
</template>
<script setup>
const nuxtApp = useNuxtApp()
const props = defineProps({
	loading: {
		type: Boolean,
		required: true,
	},
})

const loading = ref(props.loading)

nuxtApp.hook("page:start", () => {
	loading.value = true
})
nuxtApp.hook("page:finish", () => {
	loading.value = false
})
</script>
<style scoped>
.container {
	position: absolute;
	top: 46vh;
}
.loading-text {
	color: #007bed;
	font-size: 600;
	font-size: 30px;
}
</style>
