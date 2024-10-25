<template>
	<NuxtNotifications />
	<div class="pa-4">
		<div class="d-flex align-center justify-center flex-column">
			<span class="inverter-title mb-12"> INVERSOR FOTOVOLTAICO </span>
			<div class="d-flex flex-row" style="width: 100%">
				<v-row>
					<!-- v-for responsável pela criação de dos botões-->
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
								style="width: 100%; gap: 2px"
							/>
						</v-col>
						<v-btn
							:disabled="index === 0"
							class="delete-btn rounded mb-6"
							color="error"
							icon="mdi-trash-can"
							flat
							width="35"
							height="35"
							@click="delInverter(index)"
						>
						</v-btn>
					</v-row>

					<!-- Botão para remover os text-fields, como limite de mais de 1 -->
				</v-row>
			</div>
			<!-- Botão para criar novos text-fields -->
			<v-btn
				color="transparent"
				class="add-button my-4"
				icon
				flat
				@click="addInverter"
			>
				<v-icon class="add-icon" icon="mdi-plus-circle" color="blue" />
			</v-btn>
		</div>
	</div>
</template>

<script setup>
const inverterButtons = [
	{
		text: "Marca do Inversor",
		disabled: false,
	},
	{
		text: "Modelo do Inversor",
		disabled: false,
	},
	{
		text: "Potência do Inversor",
		disabled: false,
		suffix: "Kw",
		type: "number",
	},
	{
		text: "QTD. de Inversor",
		disabled: false,
		suffix: "UND",
		type: "number",
	},
	{
		text: "Potência total",
		disabled: true,
		suffix: "W",
		type: "number",
	},
]

//Inicio o valor de elementos com 1
const inverter = ref(0)
//Valores iniciais pra lista
const inverterData = ref([Array(inverterButtons.length).fill("")])

onMounted(() => {
	addInverter()
})

//Função responsável pelo botão de adicionarr
const addInverter = () => {
	inverter.value++
	inverterData.value.push(Array(inverterButtons.length).fill(""))
}

//Funcionando com o v-model e removendo o certo. Resolvido
//Utiliza o index do v-for atual para deletar a linha correta
//Função responsável pelo botão de deletar, como limitação de mais de 1
const delInverter = (index) => {
	if (inverter.value > 1) {
		inverterData.value.splice(index, 1)
		inverter.value--
	}
}

//Função responsável por renderizar os itens do array moduloButtons
//É um for padrão que renderiza os 5 modulo baseado nos cliques do botão
//Uso os 3 pontos para adicionar cada modulo do vetor moduloButton indivudalmente
//evitando perdas de indices do vetor
//uso o .push para adicionar os elementos do moduloButtons ao moduloButtonsRepeated, garantindo
//que moduloButtonsRepeated receberá +5 no seu tamanho n
const inverterButtonsRepeated = computed(() => {
	const repeatedButtons = []
	for (let i = 0; i < inverter.value; i++) {
		repeatedButtons.push(inverterButtons)
	}
	return repeatedButtons
})

//Função para realizar uma multiplicação na matriz,pegando o index do v-for representando a linha
//e multiplicando os valores dos índices 2 (Potência de inversor) pelo índice 3 (Quantidade de inversor)
//armazenando no índice 4 do vetor,que é o campo potencia total
const totalPower = (index) => {
	const power = parseFloat(inverterData.value[index][2]) || 0
	const quantity = parseFloat(inverterData.value[index][3]) || 0
	inverterData.value[index][4] = power * quantity
}

const emit = defineEmits({
	changeInverter(inverter) {
		return inverter
	},
})

watch(
	inverterData,
	(newValue) => {
		newValue.forEach((line, index) => {
			totalPower(index)
		})
		emit("changeInverter", newValue)
	},
	{ deep: true },
)
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
	width: 150px;
}

.buttons-width {
	min-width: 100px;
	max-width: 165px;
	width: 300px;
}

.add-button {
	display: flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 20px;
}

.add-icon {
	font-size: 60px;
}

.delete-btn {
	width: 10px;
	height: 10px;
	min-width: auto;
	background-color: transparent;
}

.v-text-field ::v-deep(.v-field) {
	border-radius: 10px !important;
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
