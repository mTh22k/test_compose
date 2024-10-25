<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container v-if="!loading" fluid class="ma-0 pa-0">
		<!-- Título da seção -->
		<global-banner :title="'Área do projeto'" />
		<div class="mt-12" />
		<div class="padding">
			<project-area-project-details
				:holder="actualProject.id"
				:kwp="kwp"
				:kw="kw"
				:status="actualProject.status"
			></project-area-project-details>
			<project-area-project-progress
				:progress-items="actualProject.progresses"
			/>
			<project-registration-general-data
				done
				:numero-x="actualProject.holder"
				:group-x="actualProject.group"
				:demanda="actualProject.group"
			/>

			<global-title-register class="mt-4" :title="'LISTA DE ANEXOS'" />
			<ProjectAreaProjectRegisterFileList
				:files="actualProject.designer_annexes"
			/>

			<project-area-designer-update
				class="my-4"
				:observations="actualProject.projectistObservation"
			>
				<ProjectAreaProjectRegisterFileList
					:files="actualProject.attachments"
				/>
			</project-area-designer-update>

			<div class="mt-12" />
			<project-commissioning-photovoltaic-kit-data />
			<project-area-request-inspection />
			<project-area-file-attachment />
		</div>
	</v-container>
	<global-loading-project v-else />
	<!-- Conteudo da pagina -->
</template>
<script setup>
// Id do projeto atual (no query da pagina)
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

// Requisição para o projeto atual
useAsyncData("project", () =>
	useDataLoader(`/api/project/${actualProjectId}`)
		.then((response) => {
			loading.value = false
			actualProject.value = response.data

			// Atualiza os valores para booleano
			actualProject.value.group = actualProject.value.group === 1
			actualProject.value.isInspectionRequested =
				actualProject.value.isInspectionRequested === 1
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
				statusCode: 400,
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
