<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="padding">
		<project-commissioning-photovoltaic-kit-data />
	</v-container>
	<!-- Conteudo da pagina -->
</template>
<script setup>
definePageMeta({
	middleware: ["guest", "project"],
})
useSeoMeta({
	title: "Meu perfil",
	keywords: "perfil, usuário, sistema, nostrosole",
	description:
		"Visualize e edite suas informações de perfil do sistema Nostrosole",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/ico",
			href: "/favicon.ico",
		},
	],
})
</script>

<style scoped>
@media (max-width: 960px) {
	.padding {
		padding: 0px 15px !important;
	}
}

.padding {
	padding: 0px 5vw;
}

/* Sobrepoe uma classe adicionando drop shadow nos inputs*/
.text-test :deep(.v-field__outline) {
	box-shadow: rgba(0, 0, 0, 0.25) 4px 4px 10px;
}
</style>
