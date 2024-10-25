<template>
	<global-banner :title="'Projetos finalizados'" />
</template>
<script setup>
definePageMeta({
	middleware: ["guest"],
})
useSeoMeta({
	title: "Projetos finalizados",
	keywords: "projeto, sistema, finalizados, concluídos, nostrosole",
	description: "Veja quais projetos foram finalizados na Nostrosole.",
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
