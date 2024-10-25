<template>
	<v-container>
		<v-row class="d-flex flex-row justify-center px-16">
			<!-- Titulo -->
			<v-col cols="12" class="pb-2">
				<span class="blue-text pl-1">DOCUMENTOS IMPORTANTES!</span>
			</v-col>
			<!-- 
                A cada string da array que receber, sera criado uma checkbox com o texto do
                Item da Array. Caso "allPdf" esteja ativado, será adicionando o "em PDF"
                no fim da string em negrito
            -->
			<v-col cols="12" class="pt-0">
				<v-checkbox
					v-for="(text, index) in texts"
					:key="index"
					:value="index"
					hide-details
					color="black"
					density="compact"
					bg-color="gray"
				>
					<template #label>
						<span class="black-text">
							{{ text }}
							<span
								v-if="allPdf"
								class="black-text font-weight-black pl-1"
							>
								em PDF
							</span>
						</span>
					</template>
				</v-checkbox>
			</v-col>
		</v-row>
	</v-container>
</template>

<script setup>
defineProps({
	allPdf: Boolean,
	texts: Array,
})
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
.blue-text {
	font-family: "Fredoka", sans-serif;
	color: #007bed;
	font-weight: 600;
}
.black-text {
	font-family: "Fredoka", sans-serif;
	color: #000;
	font-weight: 500;
}
</style>
