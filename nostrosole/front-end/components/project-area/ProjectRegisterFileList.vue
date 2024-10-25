<template>
	<v-row class="d-flex justify-center my-12">
		<div class="d-flex justify-center flex-column" style="width: 70%">
			<div v-for="file in files" :key="file.id" class="file-item">
				<v-icon
					class="file-icon"
					icon="mdi-file-search"
					color="black"
				></v-icon>
				<span class="file-name">{{ file.name + "  " }}</span>
				<span class="file-dots">
					<span class="dots"></span>
				</span>
				<span>
					{{ formatDate(file.updated_at) }}
				</span>
			</div>
			<div v-if="!files.length">
				<v-icon
					class="file-icon"
					icon="mdi-file-search"
					color="black"
				></v-icon>
				<span class="file-name">Sem arquivos...</span>
			</div>
		</div>
	</v-row>
</template>

<script setup>
const { files } = defineProps(["files"])

const formatDate = (dateString) => {
	const date = new Date(dateString)

	const day = String(date.getDate()).padStart(2, "0")
	const month = String(date.getMonth() + 1).padStart(2, "0")
	const year = date.getFullYear()

	return `${day}/${month}/${year}`
}
</script>

<style scoped>
span {
	font-family: "Fredoka", sans-serif;
	font-size: 18px;
	font-weight: 400;
	line-height: 21.78px;
	text-align: center;
}
.file-item {
	display: flex;
	align-items: center;
	margin-bottom: 0.5rem;
	font-size: 16px;
	line-height: 1.5;
}
.file-icon {
	margin-right: 8px;
	font-size: 20px;
}
.file-name {
	flex-shrink: 0;
}
.file-dots {
	flex: 1;
	height: 0.8em;
	margin: 0 4px;
}
.dots {
	display: block;
	width: 100%;
	height: 100%;
	background-image: radial-gradient(circle, black 1px, transparent 1px);
	background-size: 4px 4px;
	background-position: bottom;
	background-repeat: repeat-x;
}
</style>
