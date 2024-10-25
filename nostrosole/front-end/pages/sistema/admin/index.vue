<template>
	<div class="text-center my-6">
		<h1>Bem-vindo ao painel do Administrador</h1>
		<span>
			Aqui ficam as edições que somente você, como adminstrador, poderá
			alterar e mexer, como todos os usuários existentes e projetos do
			website da Nostrosole
		</span>
	</div>
</template>
<script setup>
definePageMeta({
	layout: "admin",
	middleware: ["guest", "admin"],
})
useSeoMeta({
	title: "Painel do Administrador",
	description:
		"Visualize e edite informações de usuários, projetos e outras configurações do sistema Nostrosole",
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
