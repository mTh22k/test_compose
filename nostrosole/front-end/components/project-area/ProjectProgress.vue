<template>
	<NuxtNotifications />
	<!-- <global-title-register :title="'ANDAMENTO DO PROJETO'" /> -->
	<global-title-register :title="'ANDAMENTO DO PROJETO'" />
	<v-container class="pa-0 mb-8">
		<v-row class="d-flex align-center justify-center flex-columns">
			<v-col cols="9">
				<v-row v-for="(item, index) in progressItems" :key="index">
					<v-col cols="12">
						<v-row class="d-flex justify-center align-center">
							<!-- Faz a verificação do status do checkBox e muda o icone -->
							<v-checkbox
								:false-icon="getLineColor(item.color).falseIcon"
								:class="getLineColor(item.color).checkbox"
								hide-details
								disabled
							/>

							<!-- Formata o texto de andamento -->
							<div class="d-flex align-center">
								&nbsp;
								<span
									:class="getLineColor(item.color).progress"
								>
									Andamento
								</span>
							</div>

							<!-- Formata a cor da linha -->
							<v-col cols="5" lg="7" class="d-flex align-center">
								<v-divider
									:color="getLineColor(item.color).line"
									thickness="2"
									opacity="1"
								/>
							</v-col>

							<!-- Formata a data e a cor da data -->
							<div class="d-flex align-center">
								<span :class="getLineColor(item.color).data">
									&nbsp;
									{{ dataFormated(item.data) }}
								</span>
							</div>
						</v-row>
					</v-col>
				</v-row>
			</v-col>
		</v-row>
	</v-container>
</template>

<script setup>
defineProps({
	progressItems: {
		type: Array,
		required: true,
	},
})

//Função pra formatar a data do estilo estrangeiro pro brasileiro
function dataFormated(data) {
	var dataMod = new Date(data),
		dia = dataMod.getDate().toString(),
		diaF = dia.length == 1 ? "0" + dia : dia,
		mes = (dataMod.getMonth() + 1).toString(),
		mesF = mes.length == 1 ? "0" + mes : mes,
		anoF = dataMod.getFullYear()
	return diaF + "/" + mesF + "/" + anoF
}

//análise para ver qual a cor do status. Faz uma comparação para ver se a string é igual a cor.
//A string tem o nome da cor em portugues por ser da forma que está no back.
const getLineColor = (color) => {
	const matchingColors = {
		verde: {
			checkbox: "icon-green",
			line: "#1a8c07",
			progress: "progress-text-green",
			data: "progress-data-green",
			falseIcon: "mdi mdi-checkbox-marked",
		},
		vermelho: {
			checkbox: "icon-red",
			line: "#ff0000",
			progress: "progress-text-red",
			data: "progress-data-red",
			falseIcon: "mdi mdi-file-excel-box",
		},
		amarelo: {
			checkbox: "icon-yellow",
			line: "#a7aa21",
			progress: "progress-text-yellow",
			data: "progress-data-yellow",
			falseIcon: "mdi mdi-alert-box",
		},
		cinza: {
			checkbox: "icon-grey",
			line: "#aeaeae",
			progress: "progress-text-grey",
			data: "progress-data-grey",
			falseIcon: "mdi mdi-checkbox-blank",
		},
	}

	return matchingColors[color] ? matchingColors[color] : ""
}
</script>

<style scoped>
.icon-green {
	color: #1a8c07;
}

.icon-red {
	color: #ff0000;
}

.icon-yellow {
	color: #a7aa21;
}

.icon-grey {
	color: #aeaeae;
}

/* Mudar a cor do texto dependendo do retorno do back */
.progress-text-green,
.progress-text-red,
.progress-text-yellow,
.progress-text-grey {
	font-family: "Fredoka", sans-serif;
	font-size: 20px;
	font-weight: 400;
	line-height: 24.2px;
	text-align: right;
}

.progress-text-green {
	color: #1a8c07;
}

.progress-text-yellow {
	color: #a7aa21;
}

.progress-text-red {
	color: #ff0000;
}

.progress-text-grey {
	color: #aeaeae;
}

/* Cores da data dependendo do retorno do back */
.progress-data-green,
.progress-data-yellow,
.progress-data-red,
.progress-data-grey {
	font-family: "Fredoka", sans-serif;
	font-weight: 400;
}

.progress-data-green {
	color: #1a8c07;
}

.progress-data-yellow {
	color: #a7aa21;
}

.progress-data-grey {
	color: #aeaeae;
}

.progress-data-red {
	color: #ff0000;
}

/* Mudar a opacidade do disabled do checkbox */
:deep(.v-theme--light) {
	--v-disabled-opacity: 1;
}
</style>
