<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<auth-title :title="'Esqueceu a senha?'" />
		<nuxt-link to="/">voltar</nuxt-link>
	</v-container>
	<!-- Conteudo da pagina -->
</template>
<script setup>
// Layout da página e cabeçalho
definePageMeta({
	layout: "register",
	middleware: ["auth"],
})
useSeoMeta({
	title: "Esqueceu a senha - Nostrosole",
	description:
		"Esqueceu a senha? Não se preocupe, nós te ajudamos a recuperá-la.",
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
.auth-link {
	color: #3a7700;
	font-size: 1.1rem;
	text-decoration: none;
	font-weight: 600;
}

.auth-link:hover {
	color: #244407;
}
</style>
