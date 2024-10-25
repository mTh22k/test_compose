<template>
	<global-banner :title="'DADOS DO USUÁRIO'" />
</template>
<script setup>
definePageMeta({
	middleware: ["guest"],
})
useSeoMeta({
	title: "Meu perfil",
	keywords: "perfil, usuário, sistema, editar, nostrosole",
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
