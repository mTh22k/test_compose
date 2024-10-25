<template>
	<NuxtNotifications />
	<div class="pa-4">
		<div class="d-flex align-center justify-center flex-column">
			<span class="module-title mb-12"> MODULO FOTOVOLTAICO </span>
			<div class="d-flex flex-row w-100">
				<v-row>
					<!-- v-for responsável pela criação de dos botões -->
					<v-row
						v-for="(line, index) in moduleButtonsRepeated"
						:key="index"
						class="mb-4 align-center justify-start justify-lg-center"
					>
						<v-col
							v-for="(button, subIndex) in line"
							:key="subIndex"
							cols="4"
							lg="2"
							class="textfield-cols pa-1"
						>
							<v-text-field
								v-model="moduleData[index][subIndex]"
								:label="button.text"
								variant="outlined"
								:suffix="button.suffix"
								:disabled="button.disabled"
								focused
								:type="button.type"
								hide-spin-buttons
								style="gap: 1px"
							/>
						</v-col>
					</v-row>
				</v-row>
			</div>
		</div>
	</div>
</template>

<script setup>
const moduleButtons = [
	{
		text: "Marca do modulo",
		disabled: true,
	},
	{
		text: "Modelo do modulo",
		disabled: true,
	},
	{
		text: "Potência do modulo",
		disabled: true,
		type: "number",
	},
	{
		text: "QTD. de Modulo",
		disabled: true,
		type: "number",
	},
	{
		text: "Potência total",
		disabled: true,

		type: "number",
	},
]

//Váriavel totalModules que foi definida na pasta global. Eu calculo o valor nesse componente e exporto
import { totalModules } from "../../global/TotalModules"

//Inicio o valor de elementos com 1
const module = ref(1)
//Valores iniciais pra lista
const moduleData = ref([Array(moduleButtons.length).fill("")])

//FUnção responsável por calcular a quantidade de modulos total. É baseado na soma de todos os valores da colune 3 da matriz
const calculateTotalModules = () => {
	totalModules.value = moduleData.value.reduce((total, module) => {
		const quantity = parseInt(module[3], 10) // A quantidade está no índice 3
		return total + (isNaN(quantity) ? 0 : quantity)
	}, 0)
}

//Função responsável por renderizar os itens do array moduloButtons
//É um for padrão que renderiza os 5 modulo baseado nos cliques do botão
//Uso os 3 pontos para adicionar cada modulo do vetor moduloButton indivudalmente
//evitando perdas de indices do vetor
//uso o .push para adicionar os elementos do moduloButtons ao moduloButtonsRepeated, garantindo
//que moduloButtonsRepeated receberá +5 no seu tamanho n

//É a função responsável pela renderização dos text-fields
const moduleButtonsRepeated = computed(() => {
	const repeatedButtons = []
	for (let i = 0; i < module.value; i++) {
		repeatedButtons.push(moduleButtons)
	}
	return repeatedButtons
})

//Renderiza o total de modulos
watch(totalModules, (newValue) => {
	console.log("Total Modules Atualizado:", newValue)
})

//Renderiza o total de modulos da função calculateTotalModules
watch(moduleData, calculateTotalModules, { deep: true })

//Função de auxilio em testes
const loadInverterData = async () => {
	try {
		const response = await useDataLoader("/api/module")
		const data = response.data

		module.value = data.length || 1
		moduleData.value = data.map((item) => [
			item.brand || "",
			item.model || "",
			item.power || "",
			item.quantity || "",
			item.totalPower || "",
		])
	} catch (error) {
		console.error("Erro ao carregar dados:", error)
	}
}

onMounted(loadInverterData)
</script>

<style scoped>
.module-title {
	font-size: 25px;
	line-height: 1.1;
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-weight: 600;
	position: relative;
	min-width: 200px;
}

.textfield-cols {
	width: 154px;
}

.v-text-field ::v-deep(.v-field) {
	border-radius: 10px !important;
}

:deep(.v-theme--light) {
	--v-disabled-opacity: 1;
}

@media (min-width: 2000px) {
	.textfield-cols {
		width: 250px;
	}
}

@media (min-width: 1920px) {
	.module-title {
		font-size: 35px !important;
	}
}
</style>
