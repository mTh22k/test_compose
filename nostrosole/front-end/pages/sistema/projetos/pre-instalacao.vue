<template>
	<NuxtNotifications />
	<div v-if="!loading">
		<global-banner
			:title="'VISTORIA PRÉ-INSTALAÇÃO - MICROGERAÇÃO PESSOA FÍSICA'"
		/>
		<!-- Conteúdo da página-->
		<v-container fluid class="padding pt-6">
			<project-area-project-details
				:holder="actualProject.id"
				:kwp="kwp"
				:kw="kw"
				:status="actualProject.status"
				class="px-7 mb-2"
			></project-area-project-details>
			<project-pre-installation-default-entry />
			<project-commissioning-photovoltaic-kit-data />
			<project-pre-installation-Roof-Data />
		</v-container>
		<!-- Conteúdo da página -->
	</div>
	<global-loading-project v-else />
</template>
<script setup>
const actualProjectId = useRoute().query.id
const loading = ref(true)

const actualProject = ref({
	id: 1,
	holder: "holder",
	group: true,
	status: "em andamento",
	statusDescription: "statusDescription",
	projectistObservation: "projectistObservationb",
	isInspectionRequested: false,
	created_at: "2024-07-18T21:58:42.000000Z",
	updated_at: "2024-07-18T21:58:42.000000Z",
})

const kwp = ref(0)
const kw = ref(0)

// Requisição utilizando o ID na URL
useAsyncData("project", () =>
	useDataLoader(`/api/project/${actualProjectId}`)
		.then((response) => {
			loading.value = false
			actualProject.value = response.data

			// Atualiza os valores para booleano
			actualProject.value.group = actualProject.value.group === 1
			actualProject.value.isInspectionRequested =
				actualProject.value.isInspectionRequested === 1

			// Soma os valores de potência
			actualProject.value.modules.forEach((element) => {
				kwp.value += element.totalPower
			})
			actualProject.value.inverters.forEach((element) => {
				kw.value += element.totalPower
			})

			actualProject.value.progresses = [
				{
					info: "Informação padrão",
					data: Date(),
					color: "verde",
				},
			]
		})
		.catch((error) => {
			showError({
				statusCode: error.response.status,
				message: `Projeto: ${formatError(error)}`,
			})

			loading.value = false
		}),
)

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
