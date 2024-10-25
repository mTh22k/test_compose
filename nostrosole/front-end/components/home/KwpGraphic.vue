<template>
	<div style="border-radius: 12.5px; background-color: #f6f8fd">
		<div
			style="
				background-color: #ebebecde;
				border-radius: 12.5px 12.5px 0px 0px;
			"
		>
			<span class="blue-text">kWp Todos os Anos</span>
		</div>
		<div class="px-4 py-16">
			<!-- Verifica se chartData está definido antes de renderizar o gráfico -->
			<Doughnut
				v-if="chartDataReady"
				:data="chartData"
				:options="options"
			/>
		</div>
	</div>
</template>

<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js"
import { Doughnut } from "vue-chartjs"

ChartJS.register(ArcElement, Tooltip, Legend)

const status = ref([]) // Array que vai receber as informações do back
const chartDataReady = ref(false) // Loading para garantir que o gráfico só é renderizado quando os dados estão prontos

useAsyncData("status", () =>
	useDataLoader("/api/projects/status-count")
		.then((response) => {
			// Para o loading
			chartDataReady.value = true
			// As informações do back chegam num objeto, é então pego somente o valor dos atributos
			// desse objeto, que são transformados em um numero e então passados para a variavel
			status.value = response
				? Object.values(response.data).map(Number)
				: []
		})
		.catch((error) => {
			showError({
				statusCode: 400,
				message: `Projeto: ${formatError(error)}`,
			})
			// Caso de erro, continue com o loading
			chartDataReady.value = false
		}),
)

// Crie a configuração do gráfico reativa
const chartData = ref({
	labels: ["Em andamento", "Cancelado", "Finalizados"],
	datasets: [
		{
			backgroundColor: ["#FFC700", "#E70000", "#008033"],
			borderColor: "Black",
			borderWidth: 0.5,
			data: status.value,
		},
	],
})

// Atualize os dados do gráfico quando `status` mudar, ou seja, qnd receber as informações
watchEffect(() => {
	chartData.value.datasets[0].data = status.value
})

const options = {
	responsive: true,
	maintainAspectRatio: false,
	aspectRatio: 0.5 | 2,
	cutout: 55,
	plugins: {
		legend: {
			position: "right",
		},
	},
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
.blue-text {
	font-family: "Fredoka", sans-serif;
	font-optical-sizing: auto;
	font-weight: 800;
	font-style: normal;
	font-variation-settings: "wdth" 100;
	color: #007bed;
}
</style>
