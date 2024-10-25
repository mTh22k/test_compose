<template>
	<v-app full-height>
		<layoutLoading :loading="loading" />
		<v-main
			v-if="!loading"
			fluid
			class="register-wrapper d-flex justify-center align-center pa-4"
		>
			<v-card
				min-width="300px"
				width="90vw"
				max-width="1000px"
				min-height="670px"
				class="rounded-xl pa-4 pa-sm-8"
			>
				<NuxtPage />
			</v-card>
		</v-main>
	</v-app>
</template>
<script setup>
const loading = ref(true)

onMounted(() => {
	loading.value = false
})
</script>
<style scoped>
.register-wrapper {
	background-color: #007bed;
}
</style>
