<template>
	<v-row>
		<v-col cols="12" lg="4">
			<v-text-field
				:value="holder"
				label="Projeto / Protocolo da Solicitação"
				variant="outlined"
				:disabled="true"
				focused
				hide-spin-buttons
				bg-color="#E8E3E3"
			></v-text-field>
		</v-col>
		<v-col cols="12" lg="2">
			<v-text-field
				:value="kwp"
				label="Pot. Módulos"
				variant="outlined"
				:disabled="true"
				focused
				hide-spin-buttons
				bg-color="#E8E3E3"
			></v-text-field>
		</v-col>
		<v-col cols="12" lg="2">
			<v-text-field
				:value="kw"
				label="Pot. Inversor(es)"
				variant="outlined"
				:disabled="true"
				focused
				hide-spin-buttons
				bg-color="#E8E3E3"
			></v-text-field>
		</v-col>
		<v-col cols="12" lg="4">
			<v-text-field
				label="Status da Solicitação"
				variant="outlined"
				:disabled="true"
				focused
				hide-spin-buttons
				bg-color="#E8E3E3"
			>
				{{ status[0].toUpperCase() + status.slice(1) }}
			</v-text-field>
		</v-col>
	</v-row>
</template>

<script setup>
defineProps({
	holder: String,
	kwp: String,
	kw: String,
	status: String,
})
</script>

<style scoped>
.v-text-field ::v-deep(.v-field) {
	border-radius: 10px !important;
}

:deep(.v-theme--light) {
	--v-disabled-opacity: 1;
}
</style>
