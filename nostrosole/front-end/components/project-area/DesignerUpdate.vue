<template>
	<v-container fluid class="ma-0 pa-0">
		<global-title-register :title="'ATUALIZAÇÕES DO PROJETISTA'" />

		<div class="px-6 pt-8">
			<div class="yellow-container pa-4 pt-2">
				<span class="title text-center pb-2">
					OBSERVAÇÕES DO PROJETISTA
				</span>
				<span class="pt-2 pb-4" style="color: #00000094">
					{{ observations }}
				</span>
			</div>
		</div>

		<slot />
	</v-container>
</template>

<script setup>
defineProps({
	observations: String,
})
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");

.title {
	font-size: 20px;
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-weight: 600;
}
.yellow-area {
	padding: 10px 70px;
}

.yellow-container {
	background-color: #ffe50026;
	border-radius: 10px;
	display: flex;
	flex-direction: column;
	flex-wrap: wrap;
}
</style>
