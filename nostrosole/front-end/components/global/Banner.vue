<template>
	<v-container fluid class="background text-center">
		{{ title }}
	</v-container>
</template>
<script setup>
defineProps({
	title: {
		required: true,
		type: String,
	},
})
</script>
<style scoped>
.background {
	margin: 20px 0;
	padding: 15px 0;
	background-color: #ebebecde;

	font-family: Fredoka, sans-serif;
	color: #007bed;
	font-size: 25px;
	font-weight: 600;
	text-transform: uppercase;
	line-height: 30.25px;
	text-align: center;
}
</style>
