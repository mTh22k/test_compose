<template>
	<NuxtNotifications />
	<div class="pa-4">
		<div class="d-flex align-center justify-center flex-column">
			<span class="inverter-title mb-12"> INVERSOR FOTOVOLTAICO </span>
			<div class="d-flex flex-row w-100">
				<v-row>
					<!-- v-for responsável pela criação de dos botões -->
					<v-row
						v-for="(line, index) in inverterButtonsRepeated"
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
								v-model="inverterData[index][subIndex]"
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
const inverterButtons = [
	{
		text: "Marca do Inversor",
		disabled: true,
	},
	{
		text: "Modelo do Inversor",
		disabled: true,
	},
	{
		text: "Potência do Inversor",
		disabled: true,
		type: "number",
	},
	{
		text: "QTD. de Inversor",
		disabled: true,
		type: "number",
	},
	{
		text: "Potência total",
		disabled: true,
		type: "number",
	},
]

//Inicio o valor de elementos com 1
const inverter = ref(1)
//Valores iniciais pra lista
const inverterData = ref([Array(inverterButtons.length).fill("")])

//Função responsável por renderizar os itens do array moduloButtons
//É um for padrão que renderiza os 5 modulo baseado nos cliques do botão
//Uso os 3 pontos para adicionar cada modulo do vetor moduloButton indivudalmente
//evitando perdas de indices do vetor
//uso o .push para adicionar os elementos do moduloButtons ao moduloButtonsRepeated, garantindo
//que moduloButtonsRepeated receberá +5 no seu tamanho n

//É a função responsável pela renderização dos text-fields
const inverterButtonsRepeated = computed(() => {
	const repeatedButtons = []
	for (let i = 0; i < inverter.value; i++) {
		repeatedButtons.push(inverterButtons)
	}
	return repeatedButtons
})

//Função de auxilio em testes
const loadInverterData = async () => {
	try {
		const response = await useDataLoader("/api/inverter")
		const data = response.data

		inverter.value = data.length || 1
		inverterData.value = data.map((item) => [
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
.inverter-title {
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
	.inverter-title {
		font-size: 35px !important;
	}
}
</style>
