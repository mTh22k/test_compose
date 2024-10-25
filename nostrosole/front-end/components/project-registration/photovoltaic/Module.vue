<template>
	<NuxtNotifications />
	<div class="pa-4">
		<div class="d-flex align-center justify-center flex-column">
			<span class="module-title mb-12"> MÓDULO FOTOVOLTAICO </span>
			<div class="d-flex flex-row" style="width: 100%">
				<v-row>
					<!-- v-for responsável pela criação de dos botões-->
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
							style="margin-left: 8px"
							@click="delModule(index)"
						>
						</v-btn>
					</v-row>
				</v-row>
			</div>
			<!-- Botão para criar novos text-fields -->
			<v-btn
				color="transparent"
				class="add-button my-4"
				icon="mdi-plus-circle"
				flat
				@click="addModule"
			>
				<v-icon class="add-icon" icon="mdi-plus-circle" color="blue" />
			</v-btn>
		</div>
	</div>
</template>

<script setup>
const moduleButtons = [
	{
		text: "Marca do Modulo",
		disabled: false,
	},
	{
		text: "Modelo do Módulo",
		disabled: false,
	},
	{
		text: "Potência do Módulo",
		disabled: false,
		suffix: "Wp",
		type: "number",
	},
	{
		text: "QTD. de Módulos",
		disabled: false,
		suffix: "UND",
		type: "number",
	},
	{
		text: "Potência total",
		disabled: true,
		suffix: "kWp",
		type: "number",
	},
]

const module = ref(0)
const moduleData = ref([Array(moduleButtons.length).fill("")])

onMounted(() => {
	addModule()
})

//Função responsável pelo botão de adicionar
const addModule = () => {
	module.value++

	moduleData.value.push(Array(moduleButtons.length).fill(""))
}

//Função responsável pelo botão de deletar, como limitação de mais de 1
const delModule = (index) => {
	if (module.value > 1) {
		moduleData.value.splice(index, 1)
		module.value--
	}
}

//Função responsável por renderizar os itens do array moduleButtons
//É um for padrão que renderiza os 5 modulo baseado nos cliques do botão
//Uso os 3 pontos para adicionar cada modulo do vetor moduloButton indivudalmente
//evitando perdas de indices do vetor
//uso o .push para adicionar os elementos do moduleButtons ao moduleButtonsRepeated, garantindo
//que moduleButtonsRepeated receberá +5 no seu tamanho n
const moduleButtonsRepeated = computed(() => {
	const repeatedButtons = []
	for (let i = 0; i < module.value; i++) {
		repeatedButtons.push(moduleButtons)
	}
	return repeatedButtons
})

//Calcular a potencia total baseado na potencia e quantidade
const totalPower = (index) => {
	const power = parseFloat(moduleData.value[index][2]) || 0
	const quantity = parseFloat(moduleData.value[index][3]) || 0
	moduleData.value[index][4] = power * quantity
}

const emit = defineEmits({
	changeModule(module) {
		return module
	},
})

//Renderizar a potencial total no campo correto
watch(
	moduleData,
	(newValue) => {
		newValue.forEach((line, index) => {
			totalPower(index)
		})
		emit("changeModule", newValue)
	},
	{ deep: true },
)
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
	width: 150px;
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
	.module-title {
		font-size: 35px !important;
	}
}
</style>
