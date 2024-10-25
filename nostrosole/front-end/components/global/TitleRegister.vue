<template>
	<v-row>
		<v-col class="d-flex flex-row">
			<span class="title" :style="styles">
				{{ title }}
			</span>
			<div class="blue-line" />
		</v-col>
	</v-row>
</template>
<script setup>
defineProps({
	title: String,
	styles: String,
})
</script>
<style scoped>
.title {
	font-size: 25px;
	line-height: 1.1;
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-weight: 600;

	position: relative;
	min-width: 200px;
	width: min-content;
}
.blue-line {
	position: relative;
	top: 50%;
	width: 99%;
	background-color: #007bed;
	height: 1px;
}
</style>
