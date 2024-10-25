<template>
	<global-banner :title="'Projetos em andamento'" />
</template>
<script setup>
definePageMeta({
	middleware: ["guest"],
})
useSeoMeta({
	title: "Projetos em andamento",
	keywords: "projeto, sistema, andamento de projeto, nostrosole",
	description: "Veja quais projetos estão em andamento na Nostrosole.",
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
