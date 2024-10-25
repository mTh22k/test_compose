<!--

    Crédito da animação:
    https://css-loaders.com/dots/

-->
<template>
	<v-container
		fluid
		class="ma-0 pa-0 100w d-flex justify-center align-center"
	>
		<div class="loader" />
	</v-container>
</template>
<script setup></script>
<style scoped>
.loader {
	width: 15px;
	aspect-ratio: 1;
	border-radius: 50%;
	animation: l5 1s infinite linear alternate;
}
@keyframes l5 {
	0% {
		box-shadow:
			20px 0 #007bed,
			-20px 0 #007bed20;
		background: #007bed;
	}
	33% {
		box-shadow:
			20px 0 #007bed,
			-20px 0 #007bed20;
		background: #007bed20;
	}
	66% {
		box-shadow:
			20px 0 #007bed20,
			-20px 0 #007bed;
		background: #007bed20;
	}
	100% {
		box-shadow:
			20px 0 #007bed20,
			-20px 0 #007bed;
		background: #007bed;
	}
}
</style>
