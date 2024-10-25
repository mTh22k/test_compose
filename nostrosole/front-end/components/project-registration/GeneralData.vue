<!-- 
	Componente de dados gerais das paginas de cadastro e area de projeto
	- Cadastro: 2 escolhas divivido em numero(cpf ou cnpj) e group (A ou B)
	<sistema-dados-gerais 
		@change-num="(n) => (var1 = n)" -> Altera a variavel em relacao ao numero
		@change-group="(n) => (var2 = n)" -> Altera a variavel em relacao ao group
	/>
	Dependo da opção escolhida no componente, ele ira emitir o valor para o componente pai
	- Area : Mostra o resultado das escolhas no cadastro
	<sistema-dados-gerais
		done -> O componente mostra apenas as opções escolhidas
		numero-x="XXXX" -> Passa o tipo do Titular do UC escolhido
		group-x="X" -> Passa o group escolhido
		demanda="xxx" -> Passa o tipo de demanda
	/>
-->
<template>
	<v-container fluid class="ma-0 pa-0">
		<global-title-register :title="'DADOS GERAIS'" />
		<!-- Dados Gerais Cadastro de Projetos -->
		<v-row v-if="!done" class="d-flex flex-row justify-center">
			<v-col cols="12" md="4" lg="4">
				<v-radio-group v-model="num" :rules="[compNum]">
					<v-radio value="cnpj" color="blue" base-color="blue">
						<template #label>
							<div class="blue-text">
								Clique aqui se o titular da UC for um
								<span class="red-text">CNPJ</span>
							</div>
						</template>
					</v-radio>
					<v-radio value="cpf" color="blue" base-color="blue">
						<template #label>
							<div class="blue-text">
								Clique aqui se o titular da UC for um
								<span class="red-text">CPF</span>
							</div>
						</template>
					</v-radio>
					<template #message="{ message }">
						<div
							v-if="message == 'E' && !num"
							class="red-text font-weight-bold"
						>
							Escolha uma opção
						</div>
					</template>
				</v-radio-group>
			</v-col>
			<v-col cols="12" md="6" lg="6">
				<v-radio-group v-model="group" :rules="[compGroup]">
					<v-radio :value="0" color="blue" base-color="blue">
						<template #label>
							<div class="blue-text">
								Clique aqui se o titular da UC for
								<span class="red-text">GRUPO A</span>
								(Com demanda contratada)
							</div>
						</template>
					</v-radio>
					<v-radio :value="1" color="blue" base-color="blue">
						<template #label>
							<div class="blue-text">
								Clique aqui se o titular da UC for
								<span class="red-text">GRUPO B</span>
								(Com demanda contratada)
							</div>
						</template>
					</v-radio>
					<template #message="{ message }">
						<div
							v-if="message == 'E' && group == undefined"
							class="red-text font-weight-bold"
						>
							Escolha uma opção
						</div>
					</template>
				</v-radio-group>
			</v-col>
		</v-row>
		<!-- Dados Gerais Area de Projetos -->
		<v-row v-else class="d-flex flex-row justify-center">
			<v-radio-group
				v-model="active"
				hide-details
				inline
				class="d-flex justify-center"
			>
				<v-radio
					value="active"
					color="blue"
					base-color="blue"
					class="pr-sm-16 mr-sm-16"
				>
					<template #label>
						<div class="blue-text">
							Titular da UC é um
							<span class="red-text">
								{{ numberX ? "CPF" : "CNPJ" }}
							</span>
						</div>
					</template>
				</v-radio>
				<v-radio value="active" color="blue" base-color="blue">
					<template #label>
						<div class="blue-text">
							A UC é do
							<span class="red-text">
								Grupo {{ groupX ? "A" : "B" }}</span
							>
							(
							<span class="red-text">
								{{ demanda ? "Com" : "Sem" }}
							</span>
							demanda contratada)
						</div>
					</template>
				</v-radio>
			</v-radio-group>
		</v-row>
	</v-container>
</template>

<script setup>
// Recebem o valor das escolhas no cadastro do projeto
const num = ref()
const group = ref()
// Varriavel na pagina de area de projetos que força que as opções estejam selecionadas
const active = ref("active")

const compNum = computed(() => {
	return !!num.value || "Escolha uma opção"
})

const compGroup = computed(() => {
	return group.value == 0 || group.value == 1 || "Escolha uma opção"
})

// Props
// Irao Receber os props para mostrar os dados na area de projetos
defineProps({
	done: Boolean,
	numberX: String,
	groupX: Boolean,
	demanda: String,
})

// Emits
// Caso uma opção seja escolhida no cadastro, ele irá emitir um evento para que se altere o valor
// de uma variavel componente pai
const emit = defineEmits({
	changeNum(num) {
		return num
	},
	changeGroup(group) {
		console.log(group)
		return group
	},
})

// Watchers
// Irão observar caso a variavel que contem a opção da escolha no cadastro se alterar, ou seja, o usuario
//  escolher uma outra opção, ele irá emitir o evento para alterar uma variavel no componente pai
watch(num, (newNum) => {
	emit("changeNum", newNum)
})
watch(group, (newGrupo) => {
	emit("changeGroup", newGrupo)
})
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");

.kit-fotovoltaico-wrapper {
	height: 100vh;
	width: 100vw;
}

.blue-text {
	font-family: "Fredoka", sans-serif;
	color: #007bed;
	font-weight: 800;
}
.red-text {
	color: #ed0000;
}
</style>
