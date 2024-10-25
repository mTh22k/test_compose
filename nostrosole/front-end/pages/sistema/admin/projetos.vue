<template>Futura dashboard de projetos do admin</template>
<script setup>
definePageMeta({
	layout: "admin",
	middleware: ["guest", "admin"],
})
useSeoMeta({
	title: "Meu perfil",
	keywords: "projeto, gerenciamento, sistema, nostrosole",
	description: "Visualize e edite os projetos do sistema Nostrosole",
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
