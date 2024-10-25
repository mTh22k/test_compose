<template>
	<v-container>
		<!-- Titulo com linha ao lado -->
		<slot name="title"></slot>
		<!-- 
            Componente de checkbox all-pdf -> Adiciona a pequena frase "em PDF" em negrito no fim das frases
            textos -> Ao passar uma array de strings, eles serão escritos como componente checkbox
        -->
		<slot></slot>
		<!-- Area amarela -->
		<v-row class="d-flex flex-row justify-center yellow-area">
			<v-container class="yellow-container pa-6">
				<!--
                    Para cada objeto na array listaArquivos será criado uma linha com uma area para
                    colocar um file, um botao para retirar o objeto da array(apagando a linha) e 
                    um botao de adicionar que tambem adciona o botao
                -->
				<v-row
					v-for="(file, index) in listaArquivos"
					:key="index"
					class="d-flex align-start justify-center"
				>
					<v-col cols="12" md="8" class="px-2">
						<div
							v-if="index == 0"
							cols="12"
							md="8"
							class="d-flex justify-center pa-0 mb-2"
						>
							<span class="blue-text text-h6 text-center">
								NOME DO ANEXO
							</span>
						</div>
						<v-file-input
							:id="'input' + index"
							v-model="file.value"
							density="compact"
							variant="solo-filled"
							counter
							show-size
							prepend-icon=""
							:rules="[rules.fileSize, rules.requiredfile]"
							:accept="fileType"
						>
						</v-file-input>
					</v-col>
					<v-col
						cols="3"
						md="4"
						class="d-flex flex-column justify-center align-center px-2"
						style="flex: 0 0 10%"
					>
						<div
							v-if="index == 0"
							class="pa-0 d-none d-md-flex justify-center mb-2"
							style="position: relative; left: 20px"
						>
							<span class="blue-text text-h6">AÇÃO</span>
						</div>
						<div class="d-flex justify-center align-center">
							<v-btn
								class="rounded mr-2"
								color="red"
								icon="mdi-trash-can-outline"
								flat
								width="35"
								height="35"
								min-width="30"
								:disabled="index == 0"
								@click="removerArquivos(index)"
							></v-btn>
							<v-btn class="blue-button" min-width="30">
								<label :for="'input' + index">
									<span class="blue-button-text">
										ADICIONAR
									</span>
								</label>
							</v-btn>
						</div>
					</v-col>
				</v-row>
				<v-row class="d-flex justify-center pt-5 pb-2">
					<v-btn
						color="white"
						class="add-button"
						icon="mdi-plus-circle"
						flat
						@click="addFiles"
					>
						<v-icon
							class="add-icon"
							icon="mdi-plus-circle"
							color="blue"
						></v-icon>
					</v-btn>
				</v-row>
			</v-container>
		</v-row>
	</v-container>
</template>

<script setup>
const rules = commonRules
rules.requiredfile = (v) => {
	if (v.length == 0) {
		return "Insira o Arquivo aqui"
	} else {
		return true
	}
}
rules.fileSize = (v) => {
	return (
		!v ||
		!v.some((v) => v.size > 10e6) ||
		"Tamanho do PDF deve ser menor do que 10MB!"
	)
}
// Classe base para criar instancias que receberam o v-model dos files
class receiveFile {
	value = null
}

const listaArquivos = ref([])
// Lista com as intancias dos objetos para receber so files, ja tem uma instancia
// para que quando carregar a pagina ja ter uma linha

const popularArquivos = (numeroDeArquivos) => {
	for (let i = 0; i < numeroDeArquivos; i++) {
		listaArquivos.value.push(new receiveFile())
	}
}

// Função que cria uma nova instancia para receber files e adiciona na lista
const addFiles = () => {
	listaArquivos.value.push(new receiveFile())
}

// Função que cria retira a instancia dentro da lista dependendo de qual index receber
// que esta associado a cada instancia do objeto
const removerArquivos = (id) => {
	if (listaArquivos.value.length > 1) {
		listaArquivos.value.splice(id, 1)
	}
}

const emit = defineEmits({
	changeList(list) {
		return list
	},
})

watch(listaArquivos.value, (newlistaArquivos) => {
	emit("changeList", newlistaArquivos)
})

onMounted(() => {
	emit("changeList", listaArquivos.value)
})

// Receberá qual tipo de arquivo o componente tem que receber
const props = defineProps({
	fileType: String,
	startFields: Number,
})

popularArquivos(props.startFields || 1)
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");

@media (max-width: 1280px) {
	.yellow-area {
		padding: 10px 50px !important;
	}
}

.title {
	font-size: 25px;
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-weight: 600;
	position: relative;
	min-width: 230px;
}

.blue-line {
	position: relative;
	top: 50%;
	width: 70%;
	background-color: #007bed;
	height: 2px;
}

.blue-text {
	font-family: "Fredoka", sans-serif;
	color: #007bed;
	font-weight: 600;
}

.yellow-area {
	padding: 10px 100px;
}

.yellow-container {
	background-color: #ffe50026;
	border-radius: 10px;
}

.blue-button {
	background-color: #007bed;
	color: white;
	border-radius: 10px;
	font-weight: 600;
}

.blue-button-text {
	font-size: clamp(10px, 1vw, 20px);
}

.add-button {
	display: flex;
	align-items: center;
	justify-content: center;
}

.add-icon {
	font-size: 60px;
}
</style>
