<template>
	<global-title-register :title="'DADOS DO TELHADO DA UC'" />
	<div class="pa-3">
		<div class="d-flex align-center justify-center flex-column">
			<div class="d-flex pa-8 flex-column" style="width: 95%">
				<!-- Renderiza os arranjos usando v-for -->
				<v-row
					v-for="(arrangement, index) in arrangements"
					:key="index"
					class="d-flex justify-center mb-4"
				>
					<v-col cols="4">
						<span class="type-of-action mb-8">TIPO DE TELHADO</span>
						<div class="d-flex justify-center align-center">
							<v-select
								v-model="arrangement.typeOfRoof"
								:items="[
									'Fibrociamento Ondulado',
									'Colonial (Telha Cerâmica)',
									'Metálico Ondulado',
									'Metálico Trapezoidal',
									'Laje',
									'CARPORT',
									'Solo Monoposte',
									'Solo Biposte',
								]"
								max-width="25rem"
								variant="solo"
								density="compact"
								bg-color="#ECECEC"
							></v-select>
						</div>
					</v-col>
					<v-col cols="3" class="ml-9">
						<span class="double-type-of-action mb-3"
							>QUANTIDADE DE ARRANJOS</span
						>
						<div
							style="width: 65%; background-color: #d9d9d9"
							class="ml-8"
						>
							<VNumberInput
								v-model="arrangement.quantity"
								control-variant="split"
								density="compact"
								:min="0"
							></VNumberInput>
						</div>
					</v-col>
					<v-col cols="3">
						<span class="double-type-of-action mb-3"
							>MÓDULOS POR ARRANJO</span
						>

						<div
							class="ml-7"
							style="width: 65%; background-color: #d9d9d9"
						>
							<VNumberInput
								v-model="arrangement.modulesPerArrangement"
								control-variant="split"
								density="compact"
								:min="0"
							></VNumberInput>
						</div>
					</v-col>
					<v-col cols="1">
						<span class="type-of-action mb-9">AÇÃO</span>
						<div class="d-flex justify-center align-center">
							<v-btn
								:disabled="index === 0"
								class="delete-btn rounded mb-1"
								color="error"
								icon="mdi-trash-can"
								flat
								width="2.5rem"
								height="2rem"
								@click="delArrangement(index)"
							></v-btn>
						</div>
					</v-col>
					<div class="div-line mb-2"></div>
				</v-row>

				<!-- Outras seções, se necessário -->
				<div class="d-flex justify-center mb-5 Alloc-modules">
					<span class="modules-text">Modulos Alocados</span>
					<div class="ml-12">{{ calculateTOtalModulesX() }}</div>
				</div>
				<div class="black-line w-100 mb-5"></div>
				<!-- O valor de modulo não alocados é o total menos a quantidade total de modulos do componente de cima -->
				<div class="d-flex justify-center Not-Alloc-modules">
					<span class="modules-text-red">Modulos Não Alocados</span>
					<div class="ml-5 mb-5">
						<span class="unnallocated-modules" :min="0">
							{{ x }}</span
						>
					</div>
				</div>
				<div class="div-line mb-2"></div>
				<!-- Botão para adicionar novo arranjo -->
				<div class="d-flex justify-center mb-5">
					<v-btn class="add-btn my-4" @click="addArrangement">
						<div>
							<span class="btn-text"> Adicionar Arranjo</span>
						</div>
					</v-btn>
				</div>
				<div class="d-flex justify-center mb-5">
					<v-btn class="submit-btn my-4" @click="handleEnviarDados">
						<div>
							<span class="btn-text">Enviar Dados</span>
						</div>
					</v-btn>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
//Componente que precisou ser importado
import { VNumberInput } from "vuetify/labs/VNumberInput"

//Recebo a variável global com a quantidade de modulos armazenada
//Vem o valor calculado em components/project-commissioning/photovoltaic/Module.vue
import { totalModules } from "../global/TotalModules"

// Inicializa a lista de arranjos com um arranjo padrão

const arrangements = ref([
	{ typeOfRoof: "", quantity: 0, modulesPerArrangement: 0 },
])

const testeArrangements = ref(1)

//Variavel auxiliar
const x = ref(0)

// Função para adicionar um novo arranjo
const addArrangement = () => {
	console.log(totalModules)
	testeArrangements.value++
	arrangements.value.push({
		typeOfRoof: "",
		quantity: 0,
		modulesPerArrangement: 0,
	})
}

// Função para remover um arranjo
const delArrangement = (index) => {
	if (arrangements.value.length > 1) {
		arrangements.value.splice(index, 1)
	}
}

//Função que calcula o total de modulos e subtrai pelos arranjos adicionados. Objetivo é fazer o usuário informar a quantidade suficiente de modulos para alocar corretamente
// totalModules é importado da função caclularModulos
const calculateTOtalModulesX = () => {
	const total = arrangements.value.reduce((total, arrangement) => {
		return total + arrangement.quantity * arrangement.modulesPerArrangement
	}, 0)

	x.value = totalModules.value - total
	return total
}

//Função para realizar testes de envio de dados
const handleEnviarDados = async () => {
	const formArrangements = new FormData()

	formArrangements.append("project_id", 1)

	arrangements.value.forEach((arrangement, index) => {
		formArrangements.append(
			`roof_data[${index}][arrangement_number]`,
			index + 1,
		)
		formArrangements.append(
			`roof_data[${index}][modules_per_arrangement]`,
			arrangement.modulesPerArrangement,
		)
		formArrangements.append(
			`roof_data[${index}][type]`,
			arrangement.typeOfRoof,
		)
	})

	const ucData = {
		nearest_post_number: "50",
		cep: "69945-970",
		city_state: "PauloMuitoFoda",
		neighborhood: "NarniaBr",
		street: "ao lado",
		adressNumber: "81",
		additionalAddress: "Ao lado da casa",
		latitude: "830",
		longitude: "81",
		google_maps_link:
			"https://www.google.com.br/maps/@-25.5197184,-49.1487232,10z?entry=ttu",
	}
	for (const key in ucData) {
		formArrangements.append(`uc_data[${key}]`, ucData[key])
	}

	const inputPattern = {
		uc_number: "81",
		connection_type: "monofasico rural",
		stardart_circuit_breaker: "nada",
		tension: "127V",
		maximum_uc_load: "9",
		extension_type: "aereo",
		cable_insulation: "PVC",
		cable_type: "cobre",
		grouped_pattern: "sim",
		standard_cable_gauge: "200",
	}
	for (const key in inputPattern) {
		formArrangements.append(`input_pattern[${key}]`, inputPattern[key])
	}

	const qdg = {
		circuit_breaker: "circuito breaker",
		connection_type: "monofasico rural",
		tension: "127V",
		maximum_uc_load: "maximun_load",
		cable_type: "cobre",
		standard_cable_gauge: "14",
		cable_insulation: "PVC",
	}
	for (const key in qdg) {
		formArrangements.append(`qdg[${key}]`, qdg[key])
	}

	const holderData = {
		cpf: "111.111.111-11",
		name: "sergio",
		email: "sergio@email.com",
		phone: "(41) 4444-4444",
		cellphone: "(41) 44444-4444",
		cep: "55555-333",
		city_state: "Parana",
		neighborhood: "NarniaOutraVez",
		street: "aaa",
		adressNumber: "123",
		additionalAddress: "Ao lado de narnia",
	}
	for (const key in holderData) {
		formArrangements.append(`holder_data[${key}]`, holderData[key])
	}

	console.log(
		"Dados que estão sendo enviados:",
		Object.fromEntries(formArrangements.entries()),
	)

	try {
		await useDataLoader("/api/pre-installation", {
			method: "POST",
			body: formArrangements,
		})
		console.log("Dados enviados com sucesso!")
	} catch (error) {
		console.error("Erro ao enviar dados:", error)
		if (error.response && error.response.data) {
			console.log("Detalhes do erro:", error.response.data)
		}
	}
}
</script>

<style scoped>
.type-of-action {
	font-family: "Fredoka", sans-serif;
	line-height: 1.1;
	font-weight: 650;
	display: flex;
	text-align: center;
	justify-content: center;
	align-items: center;
	font-size: 18px;
	color: #007bed;
	line-height: 21.78px;
	position: relative;
	top: 15%;
}

.double-type-of-action {
	font-family: "Fredoka", sans-serif;
	line-height: 1.1;
	font-weight: 650;
	display: flex;
	text-align: center;
	font-size: 18px;
	color: #007bed;
	line-height: 21.78px;
	min-width: 139px;
	width: min-content;
	position: relative;
	left: 1.5vw;
}

.delete-btn {
	display: flex;
	justify-content: center;
}

.add-btn {
	background: #007bed;
	box-shadow: 0px 4px 4px 0px #00000040;
	width: 199.31px;
	height: 38px;
	gap: 0px;
	border-radius: 10px;
	opacity: 0px;
}

.black-line {
	background-color: black;
	height: 1px;
}

.btn-text {
	font-family: "Fredoka", sans-serif;
	font-size: 15px;
	font-weight: 600;
	line-height: 24px;
	display: flex;
	align-items: center;
	text-align: center;
	justify-content: center;
	color: #ffffff;
}

.modules-text {
	font-family: "Fredoka", sans-serif;
	font-size: 15px;
	font-weight: 400;
	line-height: 18.15px;
}

.unnallocated-modules {
	color: red;
}

>>> .mdi-menu-down {
	color: #007bed;
	opacity: 1;
}

>>> .mdi-plus {
	color: blue;
}

>>> .mdi-minus {
	color: blue;
}

/* Propriedade de deep insana */
>>> .v-number-input__control .v-btn {
	background-color: #007bed;
	width: 2vw;
	height: 35.47px;
	border-radius: 1px !important;
}

>>> .v-input__details {
	background-color: #ffffff;
}

.div-line {
	background-color: #00000029;
	height: 1px;
	width: 100%;
}

@media (min-width: 1618px) {
	.type-of-action {
		margin-bottom: 2rem !important;
	}
}
</style>
