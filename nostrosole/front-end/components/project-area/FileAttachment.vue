<template>
	<v-container fluid class="ma-0 pa-0">
		<global-title-register :title="'ANEXAR ARQUIVOS ADICIONAIS'" />
		<ProjectRegistrationAnnexList
			start-fields="2"
			@change-list="(n) => (files = n)"
		/>
		<ProjectAreaProjectRegisterFileList :files="showFiles" />
	</v-container>
</template>
<script setup>
// A ideia dessa parte do script é Repassar os arquivos que consegue pelo Annex list para o Registro dos arquivos
// Para isso ele pega os arquivos no change-list e coloca no files, o showList é para formatar o files para que o Registro de arquivos aceite as informações
const files = ref()
const showFiles = ref([])
// Watch para que toda vez que um arquivo é adicionado, ele faça com que esse arquivo seja colocado no Registro
watch(
	files,
	(newFiles) => {
		// Apaga os itens que estavam na variavel para depois serem colocadas de novo
		showFiles.value.length = 0

		// Para cada elemento em files, se tiver um arquivo dentro dele coloque no showFiles de acordo com o formato
		newFiles.forEach((element) => {
			if (element.value) {
				showFiles.value.push({
					name: element.value.name,
					updated_at: element.value.lastModifiedDate,
					file: element.value,
				})
			}
		})
	},
	{ deep: true },
)
</script>
<style scoped></style>
