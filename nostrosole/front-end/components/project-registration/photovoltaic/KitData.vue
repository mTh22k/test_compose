<template>
	<v-container fluid class="pa-0 ma-0">
		<global-title-register :title="'DADOS DO KIT FOTOVOLTÁICO'" />
		<project-registration-photovoltaic-module
			class="mb-6"
			@change-module="(n) => (module = n)"
		/>
		<project-registration-photovoltaic-inversor
			class="mb-6"
			@change-inverter="(n) => (inverter = n)"
		/>
	</v-container>
</template>

<script setup>
const module = ref()
const inverter = ref()

const emit = defineEmits({
	changeInverter(inverter) {
		return inverter
	},
	changeModule(module) {
		return module
	},
})

watch(
	inverter,
	(newValue) => {
		emit("changeInverter", newValue)
	},
	{ deep: true },
)
watch(
	module,
	(newValue) => {
		emit("changeModule", newValue)
	},
	{ deep: true },
)
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap");

.kit-fotovoltaico-wrapper {
	height: 100vh;
	width: 100vw;
}

.title {
	font-size: 25px;
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-weight: 600;
	position: relative;
	min-width: 200px;
}
.blue-line {
	position: relative;
	top: 50%;
	width: 99%;
	background-color: #007bed;
	height: 1px;
}
</style>
