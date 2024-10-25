<template>
	<NuxtNotifications />
	<global-title-register :title="'FORMULÁRIOS E SOLICITAÇÃO DE VISTORIA'" />
	<v-container fluid class="pa-0 ma-0">
		<v-row class="d-flex align-center justify-center flex-columns">
			<!-- Colunas contendo o conteúdo da página -->
			<div class="kit-fotovoltaico-wrapper">
				<v-row>
					<div class="d-flex mt-6 mb-12">
						<v-row>
							<v-col
								v-for="(button, index) in buttons"
								:key="index"
								cols="3"
								class="buttons-width"
							>
								<v-btn
									class="personalized-buttons"
									:color="button.color"
									@click.stop="handleButtonClick(button)"
								>
									<!-- Texto dos botões -->
									<span class="button-text px-4">
										{{ button.text }}
									</span>
								</v-btn>
							</v-col>
						</v-row>
					</div>
				</v-row>
			</div>
		</v-row>
	</v-container>
</template>

<script setup>
const { notify } = useNotification() // Função de Notificação

const buttons = [
	{
		text: "Visita técnica pré instalação",
		color: "#007BED",
		to: "/sistema/projetos/pre-instalacao",
	},
	{
		text: "Visita técnica pós instalação",
		color: "#007BED",
		to: "/sistema/projetos/pos-instalacao",
	},
	{
		text: "Comissonamento da usina",
		color: "#007BED",
		to: "/sistema/projetos/comissionamento",
	},
	{
		text: "Solicitação de vistoria",
		color: "#1A8C07",
	},
]

//Função de roteamento de páginas
function pageRouter(route) {
	const router = useRouter()
	const idProject = useRoute().query?.id || "error"

	return router.push(`${route}?id=${idProject}`)
}

//Função para verificar se o botão é o de vistoria e exibir a notificação ao ser clicado
//Caso não seja somente redireciona para a rota desejada
function handleButtonClick(button) {
	if (button.text === "Solicitação de vistoria") {
		requestInspectionNotification()
		return
	}

	pageRouter(button.to)
}

//Função que exibe a notificação na tela
async function requestInspectionNotification() {
	await notify({
		text: "Enviado pedido de vistoria",
	})
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap");

.personalized-buttons {
	font-weight: 400;
	color: #ffffff;
	text-align: center;
	height: 40px;
	width: 100%;
	line-height: unset;
	text-transform: unset;
	letter-spacing: unset;
	border-radius: 10px;
	box-shadow: 0px 4px 4px 0px #00000040;
	text-transform: unset;
	padding: 1%;
}

.button-text {
	font-family: "Hind", sans-serif;
	font-size: 10px;
	line-height: 28px;
	font-weight: 800;
	letter-spacing: unset;
}

/* Responsividade em telas médias e grandes abaixo*/
@media screen and (min-width: 1280px) {
	.button-text {
		font-size: 14px !important;
	}
}

@media screen and (min-width: 1700px) and (max-width: 1919px) {
	.button-text {
		font-size: 14px !important;
	}
}

@media screen and (min-width: 1920px) {
	.button-text {
		font-size: 18px !important;
	}
}
</style>
