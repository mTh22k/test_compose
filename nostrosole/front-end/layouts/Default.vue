<template>
	<v-app full-height>
		<layout-loading :loading="loading" />
		<layout-lateral-menu v-if="!loading" />
		<v-main v-if="!loading">
			<NuxtPage />
			<layout-footer />
		</v-main>
	</v-app>
</template>
<script setup>
const loading = ref(true)

onMounted(() => {
	loading.value = false
})

// Cabeçalhos da pagina
useSeoMeta({
	title: "Nostrosole",
	description: "Home page do sistema Nostrosole",
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
