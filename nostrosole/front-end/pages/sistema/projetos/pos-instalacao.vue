<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="padding">
		<project-commissioning-photovoltaic-kit-data />
		<project-pos-installation-Roof-Data />
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
</style>
