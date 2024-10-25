<template>
	<v-container
		fluid
		fill-height
		class="pa-0"
		style="min-height: calc(100vh - 30px)"
	>
		<home-carousel class="pa-0 pa-md-4" />
		<div
			class="pa-0 d-flex flex-column justify-center align-center text-center"
		>
			<v-row class="w-100">
				<v-col cols="12" lg="8">
					<div
						style="
							border-radius: 12.5px;
							background-color: #f6f8fd;
							height: 100%;
						"
					>
						<div
							style="
								background-color: #ebebecde;
								border-radius: 12.5px 12.5px 0px 0px;
							"
						>
							<span class="blue-text">KWP SOLICITADO (2024)</span>
						</div>
						<div>A</div>
					</div>
				</v-col>
				<v-col cols="12" lg="4">
					<home-kwp-graphic />
				</v-col>
				<div class="w-100">
					<home-last-updates />
				</div>
			</v-row>

			<!-- Deletar no futuro (TESTES DE DEMO) -->
			<div style="margin-top: 500px" class="d-flex flex-column">
				<h1 class="mt-6">Bem-vindo ao sistema</h1>
				<p><b>Suporte:</b> 960px a 2560px (mais eh incerto)</p>
				<p>Aqui terão outros componentes futuramente</p>
				<nuxt-link to="/sistema/projetos?id=1"
					>Teste de projeto (1)</nuxt-link
				>
				<nuxt-link to="/sistema/projetos?id=10"
					>Teste de projeto (10)</nuxt-link
				>
				<nuxt-link to="/sistema/projetos?id=555"
					>Teste de projeto (555)</nuxt-link
				>
				<nuxt-link to="/sistema/projetos">
					Teste de projeto inválido (não funciona por conta do
					middleware)
				</nuxt-link>
				<nuxt-link to="/sistema/error-page-404">
					Teste da página de erro
				</nuxt-link>
			</div>
		</div>
	</v-container>
</template>
<script setup>
const loading = ref(true)
const statusCount = reactive({
	in_progress: 1,
	completed: 1,
	cancelled: 1,
})

// Requisição ao back-end para os dados de PROGRESSO
useAsyncData("project", () =>
	useDataLoader(`/api/projects/status-count`)
		.then((response) => {
			loading.value = false
			statusCount.in_progress = response.data.in_progress
		})
		.catch((error) => {
			showError({
				statusCode: 400,
				message: `Erro: ${formatError(error)}`,
			})

			loading.value = false
		}),
)

definePageMeta({
	middleware: ["guest"],
})
useSeoMeta({
	title: "Nostrosole",
	keywords: "projeto, sistema, nostrosole",
	description: "Página inicial da Nostrosole.",
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
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
.blue-text {
	font-family: "Fredoka", sans-serif;
	font-optical-sizing: auto;
	font-weight: 800;
	font-style: normal;
	font-variation-settings: "wdth" 100;
	color: #007bed;
}
</style>
