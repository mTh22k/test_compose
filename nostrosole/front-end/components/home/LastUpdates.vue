<template>
	<v-container>
		<div class="w-100 home-title pa-2">
			<h3 class="title">ÚLTIMAS ATUALIZAÇÕES</h3>
		</div>
		<v-data-table
			:headers="headers"
			:items="currentItems"
			:items-per-page="itemsPerPage"
			hide-default-footer
			class="data-table"
		>
			<!-- CABEÇALHOS DA TABELA -->
			<template #headers="{ columns }">
				<tr>
					<template v-for="column in columns" :key="column.key">
						<td>
							<h3 class="title px-9 ml-8" style="font-size: 20px">
								{{ column.title }}
							</h3>
						</td>
					</template>
				</tr>
			</template>
			<!-- ITENS DA TABELA (CASO A LINHA SEJA PAR OU IMPAR ELE MUDA DE COR) -->
			<template #item="{ item, index }">
				<tr v-if="index % 2 === 0" style="background-color: white">
					<td>{{ item.protocol }}</td>
					<td>{{ item.kwp }}</td>
					<td>{{ item.kw }}</td>
					<td>{{ item.status }}</td>
					<td>{{ item.prazoAtual }}</td>
				</tr>
				<tr v-if="index % 2 !== 0">
					<td>{{ item.protocol }}</td>
					<td>{{ item.kwp }}</td>
					<td>{{ item.kw }}</td>
					<td>{{ item.status }}</td>
					<td>{{ item.prazoAtual }}</td>
				</tr>
			</template>
			<template #no-data> Nenhum dado encontrado </template>
		</v-data-table>
		<!-- BOTOES DE PAGINACAO -->
		<div class="d-flex justify-space-between align-center mt-4 float-right">
			<div class="mx-4">
				<v-btn
					id="pagination-previous"
					class="mr-1"
					color="primary"
					:disabled="currentPage === 1"
					text
					@click="currentPage--"
				>
					Anterior
				</v-btn>
				<v-btn
					v-for="page in totalPages"
					:key="page"
					:color="currentPage === page ? 'primary' : ''"
					text
					:class="
						currentPage !== page
							? 'pagination-numbers text-primary'
							: 'pagination-numbers'
					"
					@click="currentPage = page"
				>
					{{ page }}
				</v-btn>
				<v-btn
					id="pagination-next"
					class="ml-1"
					color="primary"
					:disabled="currentPage === totalPages"
					text
					@click="currentPage++"
				>
					Seguinte
				</v-btn>
			</div>
		</div>
	</v-container>
</template>
<script setup>
// Headers da tabela
const headers = [
	{
		title: "PROJETO / PROTOCOLO",
		align: "center",
		sortable: false,
		value: "protocol",
	},
	{
		title: "KWP",
		align: "center",
		sortable: false,
		value: "kwp",
	},
	{
		title: "KW",
		align: "center",
		sortable: false,
		value: "kw",
	},
	{
		title: "STATUS",
		align: "center",
		sortable: false,
		value: "status",
	},
	{
		title: "PRAZO ATUAL",
		align: "center",
		sortable: false,
		value: "prazoAtual",
	},
]

const items = [
	{
		protocol: "1 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "2 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "3 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "4 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "5 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "6 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "7 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "8 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "9 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "10 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "11 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
	{
		protocol: "12 [Projeto / Protocolo da solicitação]",
		kwp: "[Potência Módulo]",
		kw: "[Potência Inversor]",
		status: "[Status da solicitação]",
		prazoAtual: "[Status da solicitação]",
	},
]

/* 
	currentPage, itemsPerPage e totalPages são usados para paginação,
	onde currentPage define qual é a página atual, itemsPerPage define quantos itens serão exibidos na tabela
	e totalPages define quantas páginas serão exibidas na tabela por vez.
*/
const currentPage = ref(1)
const itemsPerPage = ref(4)
const totalPages = ref(4)

/* 
	O computed currentItems define os itens que serão exibidos na tabela na página atual,
	basicamente: se currentPage = 1, ele exibe os itens de 0 a 3, se currentPage = 2, 
	ele exibe os itens de 4 a 7 e assim por diante 
*/
const currentItems = computed(() => {
	const start = (currentPage.value - 1) * itemsPerPage.value
	const end = start + itemsPerPage.value
	return items.slice(start, end)
})
</script>
<style scoped>
.home-title {
	display: flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 10px;
	background-color: #ebebecde;
	border-radius: 10px 10px 0 0;
}
.title {
	font-size: 20px;
	line-height: 1.1;
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-weight: 600;

	position: relative;
	min-width: 200px;
	width: min-content;
	text-wrap: nowrap;
}
.data-table {
	border-radius: 15px;
	background-color: #f6f8fd;
}

#pagination-previous,
#pagination-next {
	font-family: Hind;
	font-size: 16px;
	font-weight: 400;
	line-height: 32.02px;
	text-align: center;
	text-transform: capitalize;
}

.pagination-numbers {
	min-width: 42px !important;
}
</style>
