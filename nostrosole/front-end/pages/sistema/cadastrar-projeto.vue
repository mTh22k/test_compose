<template>
	<!-- Título da seção -->
	<global-banner :title="'Cadastro de projetos'" />
	<!-- Dialog de SUCESSO -->
	<v-dialog v-model="successDialog" persistent width="auto">
		<v-card
			max-width="800"
			min-width="300"
			elevation="4"
			rounded="lg"
			width="90vw"
		>
			<global-banner :title="'PROJETO CADASTRADO COM SUCESSO!'" />
			<v-text-field
				v-model="protocoloSolicitacao"
				class="text-test mx-8"
				hide-details="auto"
				label="PROTOCOLO DA SOLICITAÇÃO"
				:disabled="true"
				color="black"
				variant="outlined"
			/>
			<v-text-field
				v-model="prazoDeAnalise"
				class="text-test mx-8 mt-8"
				hide-details="auto"
				label="PRAZO DE ANÁLISE"
				:disabled="true"
				color="black"
				variant="outlined"
			/>
			<template #actions>
				<v-spacer />
				<v-btn
					class="ms-auto my-2"
					variant="text"
					color="primary"
					text="Fechar"
					@click="closeSucessDialog()"
				/>
				<v-spacer />
			</template>
		</v-card>
	</v-dialog>
	<!-- Conteúdo de criação de projeto -->
	<v-container fluid class="padding">
		<v-form
			v-model="valid"
			class="d-flex justify-center flex-column"
			@submit.prevent
		>
			<project-registration-general-data
				class="mb-6"
				@change-num="(n) => (titular = n)"
				@change-group="(g) => (group = g)"
			/>
			<project-registration-photovoltaic-kit-data
				@change-inverter="(n) => (inverter = n)"
				@change-module="(n) => (module = n)"
			/>
			<project-registration-annex-list
				file-type=".pdf"
				@change-list="(n) => (files = n)"
			>
				<template #title>
					<global-title-register :title="'LISTA DE ANEXOS'" />
				</template>
				<project-registration-important-docs :texts="texts" all-pdf />
			</project-registration-annex-list>
			<!-- Botao no qual ira enviar as informacoes pro back -->
			<div class="d-flex flex-row justify-center pt-4 pb-8">
				<v-btn
					type="submit"
					class="mb-1 mt-3"
					color="#007bed"
					size="x-large"
					density="comfortable"
					rounded="lg"
					:disabled="loadingRequest"
					@click="createProject"
				>
					SOLICITAR PROJETO E HOMOLOGAÇÃO
				</v-btn>
			</div>
		</v-form>
	</v-container>
</template>
<script setup>
const texts = [
	"Última fatura da Unidade Consumidora, ",
	"Cópia frente e verso do CPF e RG ou da CNH do titular ou representante da UC, ",
	"Quando CNPJ: Contrato Social, Estatuto Social ou qualquer documento de constituição do CNPJ, ",
	"Quando CNPJ: Documento nomeando o representante da UC como procurador legal da UC, ",
	"Datasheet dos Módulos Fotovoltaicos, ",
	"Datasheet dos Inversores Fotovoltaicos , ",
	"Datasheet da(s) String box - Se houver, ",
	"INMETRO dos Módulos Fotovoltaicos, ",
	"INMETRO dos Inversores Fotovoltaicos, ",
]

const titular = ref()
const group = ref()
const files = ref()
const readyFiles = []
const module = ref()
const readyModules = []
const inverter = ref()
const readyInverter = []

// Utilizar o snackbar
const { notify } = useNotification()
const valid = ref(false)
const loadingRequest = ref(false)
const successDialog = ref(false)
const protocoloSolicitacao = ref(0)
const prazoDeAnalise = `Até o dia ${getNextBusinessDay(new Date())}`

const { data: user } = useAsyncData("user", () =>
	useDataLoader("/api/user")
		.then((res) => (res ? res : {}))
		.catch((err) => {
			console.error(err)
			return []
		}),
)

async function createProject() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value && files.value.length >= 9) {
		files.value.forEach((element) => {
			readyFiles.push({
				name: element.value.name,
				file_path: element.value,
			})
		})
		module.value.forEach((line) => {
			readyModules.push({
				brand: line[0],
				model: line[1],
				power: line[2],
				quantity: line[3],
				totalPower: line[4],
			})
		})
		inverter.value.forEach((line) => {
			readyInverter.push({
				brand: line[0],
				model: line[1],
				power: line[2],
				quantity: line[3],
				totalPower: line[4],
			})
		})
		const form = new FormData()
		form.append("holder", user.value.name)
		form.append("group", group.value)
		form.append("status", "em andamento")
		form.append("statusDescription", "...")
		form.append("projectistObservation", "Ainda sem mensagens...")
		form.append("isInspectionRequested", 0)
		readyFiles.forEach((annex, index) => {
			for (const key in annex) {
				form.append(`designer_annexes[${index}][${key}]`, annex[key])
			}
		})
		readyModules.slice(0, -1).forEach((modules, index) => {
			for (const key in modules) {
				form.append(`modules[${index}][${key}]`, modules[key])
			}
		})
		readyInverter.slice(0, -1).forEach((inverter, index) => {
			for (const key in inverter) {
				form.append(`inverters[${index}][${key}]`, inverter[key])
			}
		})

		// Feedback de Loading
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})

		// Envia os dados para o backend

		await useDataLoader("/api/project", {
			method: "POST",
			body: form,
		})
			.then((res) => {
				// Feedback do erro por meio da snackbar
				notify.close("loading")
				// notify({
				// 	title: "Sucesso",
				// 	text: "Projeto criado com sucesso!",
				// 	type: "success",
				// })

				// Feedback de DIALOG
				successDialog.value = true
				protocoloSolicitacao.value = res.data.id
			})
			.catch((error) => {
				const errors = formatError(error)
				console.error(error)

				// Feedback do erro por meio da snackbar
				notify.close("loading")
				notify({
					title: "Não foi possível criar Projeto",
					text: `${errors}`,
					type: "error",
				})
			})
		readyFiles.length = 0
		readyInverter.length = 0
		readyModules.length = 0
	} else if (files.value.length < 9) {
		notify({
			text: `Necessita-se de pelo menos 9 arquivos para poder criar o projeto (Atual: ${files.value.length})`,
			type: "info",
		})
	} else {
		notify({
			text: "Preencha os campos corretamente para continuar",
			type: "info",
		})
	}

	loadingRequest.value = false
	return
}

// Retorna o dia util
function getNextBusinessDay(date = new Date()) {
	const day = date.getDay()

	const daysToAdd = day === 5 ? 3 : 2

	const nextBusinessDay = new Date(date)
	nextBusinessDay.setDate(date.getDate() + daysToAdd)

	return formatDateToBrazilian(nextBusinessDay)
}

function formatDateToBrazilian(date) {
	const day = String(date.getDate()).padStart(2, "0")
	const month = String(date.getMonth() + 1).padStart(2, "0") // Os meses em JavaScript são 0-11
	const year = date.getFullYear()

	return `${day}/${month}/${year}`
}

function closeSucessDialog() {
	const router = useRouter()

	return router.push("/sistema")
}

definePageMeta({
	middleware: ["guest"],
})
useSeoMeta({
	title: "Cadastrar projeto",
	keywords: "projeto, sistema, cadastro de projeto, nostrosole",
	description: "Registre um novo projeto no sistema Nostrosole.",
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
@media (max-width: 960px) {
	.padding {
		padding: 0px 15px !important;
	}
}

.padding {
	padding: 0px 5vw;
}

/* Sobrepoe uma classe adicionando drop shadow nos inputs*/
.text-test :deep(.v-field__outline) {
	box-shadow: rgba(0, 0, 0, 0.25) 4px 4px 10px;
}

.text-test :deep(.v-field--disabled) {
	opacity: 1;
}

.text-test {
	color: rgb(66, 66, 66);
	font-family: Fredoka, sans-serif;
	background-color: #e8e3e3;
}
</style>
