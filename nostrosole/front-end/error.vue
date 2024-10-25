<template>
	<v-container
		fluid
		class="background-error h-screen d-flex justify-center align-center"
	>
		<v-empty-state
			:headline="`Opa, erro ${error.statusCode}`"
			:title="errorMessage()"
			text="Se esse erro persistir, por favor, entre em contato com o suporte."
			image="/images/logo.png"
		>
			<v-btn
				prepend-icon="mdi-home"
				variant="text"
				@click.stop="handleError"
			>
				Voltar a home
			</v-btn>
			<v-btn
				prepend-icon="mdi-bug"
				variant="text"
				color="blue"
				href="https://tally.so/r/wbk9ee"
				target="_blank"
			>
				BugTracking
			</v-btn>
		</v-empty-state>
	</v-container>
</template>
<script setup>
// Handlers de erro do nuxt
const props = defineProps({
	error: { type: Object, value: () => NuxtError },
})

const handleError = () => clearError({ redirect: "/" })

function errorMessage() {
	if (!props.error) return "Um erro aconteceu!"

	const status = props.error.statusCode

	if (status === 404) return "Esta página não existe!"
	if (status === 401) return "Sem autorização necessária!"
	return props.error.message || "Um erro aconteceu!"
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Erro!",
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
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&family=Hind+Siliguri:wght@400;700&display=swap");
* {
	font-family: "Fredoka", sans-serif !important;
	color: #fff;
}

.background-error :deep(.v-empty-state__headline) {
	color: #94d8ff !important;
}

.background-error {
	background: rgb(0, 10, 88);
	background: linear-gradient(0deg, #0b132e 0%, #031958 100%);
}
</style>
