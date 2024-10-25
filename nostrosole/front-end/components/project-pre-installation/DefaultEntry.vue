<template>
	<global-title-register :title="'PADRÃO DE ENTRADA'" />
	<v-row class="d-flex flex-row justify-space-between">
		<v-col
			v-for="(item, index) in data"
			:key="index"
			cols="12"
			md="6"
			:lg="item.cols"
		>
			<v-text-field
				v-if="!item.select && !item.number"
				v-model="item.model.value"
				:label="item.name"
				variant="outlined"
				hide-spin-buttons
				density="compact"
				placeholder=""
				persistent-placeholder
				:suffix="item.suffix"
				:disabled="item.disabled"
				:bg-color="
					item.name == `Carga Máxima da UC` ? `#E8E3E3` : `white`
				"
			/>
			<v-text-field
				v-else-if="item.number"
				v-model="item.model.value"
				:label="item.name"
				variant="outlined"
				hide-spin-buttons
				density="compact"
				placeholder=""
				persistent-placeholder
				:suffix="item.suffix"
				:disabled="item.disabled"
				:bg-color="
					item.name == `Carga Máxima da UC` ? `#E8E3E3` : `white`
				"
				@keydown="checkDigit"
			/>
			<v-select
				v-else
				v-model="item.model.value"
				:label="item.name"
				:items="item.items"
				autofocus
				open-text
				variant="outlined"
				density="compact"
				aria-placeholder="TEST"
				placeholder=""
				persistent-placeholder
				color="black"
				base-color="black"
			>
			</v-select>
		</v-col>
	</v-row>
</template>

<script setup>
const cargaMaxima = computed(() => {
	const tipo = data[1].model.value // Acessa diretamente o valor
	const disjuntor = data[2].model.value
	const tensao = data[3].model.value
	let Vforn = 0
	if (tipo && disjuntor && tensao) {
		switch (tipo) {
			case "Monofásico Rural":
			case "Monofásico":
				if (tensao === "127V") {
					Vforn = 127
				} else {
					Vforn = 220
				}
				return ((Vforn * disjuntor) / 1000).toFixed(5)
			case "Bifásico":
				if (tensao === "127V") {
					Vforn = 220
				} else {
					Vforn = 380
				}
				return ((Vforn * disjuntor) / 1000).toFixed(5)
			case "Trifásico":
				if (tensao === "127V") {
					Vforn = 220
				} else {
					Vforn = 380
				}
				return ((Vforn * disjuntor * Math.sqrt(3)) / 1000).toFixed(5)
		}
	} else {
		return 0
	}
})
const data = [
	{
		name: "N° UC / Instalação",
		select: false,
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 2,
		number: false,
	},
	{
		name: "Tipo de Conexão",
		select: true,
		items: ["Monofásico Rural", "Monofásico", "Bifásico", "Trifásico"],
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 2,
	},
	{
		name: "Disjuntor do Padrão",
		select: false,
		model: ref(),
		disabled: false,
		suffix: "A",
		cols: 3,
		number: true,
	},
	{
		name: "Tensão F/N",
		select: true,
		items: ["127V", "220V"],
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 2,
	},
	{
		name: "Carga Máxima da UC",
		select: false,
		model: cargaMaxima,
		disabled: true,
		suffix: "kw",
		cols: 3,
	},
	{
		name: "Tipo de Ramal",
		select: true,
		items: ["Aéreo", "Subterrâneo"],
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 3,
	},
	{
		name: "Tipo do Cabo",
		items: ["Cobre", "Alumínio"],
		select: true,
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 2,
	},
	{
		name: "Bitola cabo padrão",
		select: false,
		model: ref(),
		disabled: false,
		suffix: "mm²",
		cols: 3,
		number: true,
	},
	{
		name: "Isolamento do Cabo",
		select: true,
		items: ["PVC", "XLPE"],
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 2,
	},
	{
		name: "Padrão Agrupado?",
		select: true,
		items: ["Sim", "Não"],
		model: ref(),
		disabled: false,
		suffix: "",
		cols: 2,
	},
]

const checkDigit = (event) => {
	if (
		event.key.length === 1 &&
		(isNaN(Number(event.key)) || event.key == " ")
	) {
		event.preventDefault()
	}
}
</script>

<style scoped>
.v-text-field ::v-deep(.v-field) {
	border-radius: 10px !important;
	font-size: 0.9em;
	font-weight: 500;
}

:deep(.v-theme--light) {
	--v-disabled-opacity: 1;
	--v-medium-emphasis-opacity: 1;
}
</style>
