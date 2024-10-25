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
					<!-- Renderiza cada roofData -->
					<v-col
						v-for="(roof, roofIndex) in arrangement.roofData"
						:key="roofIndex"
						cols="12"
					>
						<v-row>
							<v-col cols="5" class="mr-6">
								<span class="type-of-action mb-8"
									>TIPO DE TELHADO</span
								>

								<v-text-field
									v-model="roof.type"
									disabled
									variant="outlined"
									bg-color="#ECECEC"
								>
								</v-text-field>
							</v-col>
							<v-col cols="3" class="mr-6">
								<span class="double-type-of-action mb-3 ml-4"
									>QUANTIDADE DE ARRANJOS</span
								>

								<v-text-field
									v-model="roof.arrangementNumber"
									disabled
									variant="outlined"
									class="modules-arrangement"
								></v-text-field>
							</v-col>
							<v-col cols="3">
								<span class="double-type-of-action mb-3 ml-4"
									>MÓDULOS POR ARRANJO</span
								>

								<v-text-field
									v-model="roof.modulesPerArrangement"
									class="modules-arrangement"
									disabled
									variant="outlined"
								></v-text-field>
							</v-col>
						</v-row>
					</v-col>

					<div class="div-line mb-2"></div>
				</v-row>
			</div>
		</div>
	</div>
</template>

<script setup>
// Inicializa a lista de arranjos com um arranjo padrão
const arrangements = ref([
	{ typeOfRoof: "", quantity: 0, modulesPerArrangement: 0, roofData: [] },
])

// Função para adicionar um novo arranjo
const loadArrangementData = async () => {
	try {
		const response = await useDataLoader("/api/pre-installation")

		console.log("Dados brutos recebidos:", response.data)
		console.log("valor final", response.data.length)

		// Mapear dados do response para a estrutura do arrangement
		arrangements.value = response.data.map((item) => ({
			typeOfRoof: item.typeOfRoof || "",
			quantity: item.quantity || 0,
			modulesPerArrangement: item.modulesPerArrangement || 0,
			roofData: item.roofData || [],
		}))
	} catch (error) {
		console.error("Erro ao carregar dados dos arranjos:", error)
	}
}
onMounted(loadArrangementData)
</script>

<style scoped>
.modules-arrangement {
	background-color: #d9d9d9;
}

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
}

.double-type-of-action {
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
	min-width: 139px;
	width: min-content;
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

>>> .v-text-field {
	display: grid;
	text-align: center;
	justify-content: center;
}

>>> .mdi-menu-down {
	color: transparent;
}

>>> .v-number-input__control .v-btn {
	background-color: #007bed;
	width: 0vw;
	height: 0px;
	border-radius: 3px !important;
}

>>> .v-input__details {
	background-color: #ffffff;
}

>>> .mdi-plus {
	color: transparent;
}

>>> .mdi-minus {
	color: transparent;
}

.div-line {
	background-color: #00000029;
	height: 1px;
	width: 100%;
}

:deep(.v-theme--light) {
	--v-disabled-opacity: 1;
}

@media (min-width: 1618px) {
	.type-of-action {
		margin-bottom: 2rem !important;
	}

	.double-type-of-action {
		position: relative;
		left: 15%;
	}
}

@media (min-width: 1900px) {
	.double-type-of-action {
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

		width: 80%;
		margin-top: 20px;
		position: relative;
		top: -10%;
		left: 5%;
	}

	.modules-arrangement {
		margin-bottom: 10px;
	}
}
</style>
