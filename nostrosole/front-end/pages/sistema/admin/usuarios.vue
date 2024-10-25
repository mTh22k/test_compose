<template>
	<!-- Conteudo da pagina -->
	<NuxtNotifications v-if="!loading" />
	<!-- Conteudo da pagina -->
	<layout-loading :loading="loading" />
	<v-container v-if="!loading" fluid>
		<section id="dash-table">
			<div class="mx-6">
				<!-- Primeira seção: Title, ADD, Search -->
				<v-row class="ml-1 mt-6">
					<h1>Dashboard de usuários</h1>
				</v-row>
				<v-row class="my-6 mx-1 d-flex align-center">
					<v-btn color="primary" @click="openCreate">
						Adicionar usuário
					</v-btn>
					<v-spacer />
					<v-text-field
						v-model="search"
						label="Pesquisar"
						variant="solo"
						hide-details
						prepend-icon="mdi-magnify"
						clearable
					/>
				</v-row>
				<!-- Primeira seção: Title, ADD, Search -->
				<!-- Data Table -->
				<v-data-table
					:headers="headers"
					:items="users"
					:loading="pending"
				>
					<template #no-data>
						Ainda não foi registrado nenhum usuário.
					</template>
					<template #[`item.admin`]="{ item }">
						<v-chip :color="item.admin ? 'info' : 'error'">
							{{ item.admin ? "Sim" : "Não" }}
						</v-chip>
					</template>
					<template #[`item.actions`]="{ item }">
						<div class="d-flex flex-column" style="gap: 5px">
							<!-- EDIT button -->
							<v-btn
								variant="text"
								color="blue-accent-3"
								prepend-icon="mdi-pencil"
								@click="openEdit(item)"
							>
								Editar
							</v-btn>
							<!-- EDIT button -->
							<!-- DELETE button -->
							<v-btn
								variant="text"
								color="red-accent-3"
								prepend-icon="mdi-delete"
								@click="deleteUser(item.id)"
							>
								Deletar
							</v-btn>
							<!-- DELETE button -->
						</div>
					</template>
				</v-data-table>
				<!-- Data Table -->
			</div>
		</section>
		<!-- Dialog de ADIÇÃO e EDIÇÃO -->
		<v-dialog
			v-model="dialog"
			width="95vw"
			max-width="1000px"
			persistent
			scrim="black"
		>
			<!-- Card Container do Formulário -->
			<v-card class="pa-3">
				<!-- Título do Formulário -->
				<v-card-title>
					<span>
						{{ editing ? "Editar" : "Adicionar" }} Usuário
					</span>
				</v-card-title>
				<v-form v-model="valid" @submit.prevent>
					<!-- Campos do Formulário (Conteúdo do Card) -->
					<v-card-text>
						<v-row>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.name"
									variant="outlined"
									label="Nome"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.email"
									variant="outlined"
									label="E-mail"
									:disabled="editing"
									:rules="[rules.required, rules.email]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.company"
									variant="outlined"
									label="Empresa"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col v-if="!editing" cols="12" md="6">
								<v-text-field
									v-model="user.password"
									variant="outlined"
									label="Senha"
									:rules="[rules.required]"
									type="password"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.phone"
									v-mask="[
										'(##) ####-####',
										'(##) #####-####',
									]"
									variant="outlined"
									label="Telefone"
									:rules="[rules.required, rules.phone]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.cpf"
									v-mask="['###.###.###-##']"
									variant="outlined"
									label="CPF"
									:rules="[rules.required, rules.cpf]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.cnpj"
									v-mask="['##.###.###/####-##']"
									variant="outlined"
									label="CNPJ"
									:rules="[rules.required, rules.cnpj]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-checkbox
									v-model="user.admin"
									label="É admin?"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.cep"
									v-mask="['#####-###']"
									variant="outlined"
									label="CEP"
									:rules="[rules.required, rules.cep]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.addressNumber"
									variant="outlined"
									label="Endereço"
									:rules="[
										rules.required,
										rules.addressNumber,
									]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.additionalAddress"
									variant="outlined"
									label="Complemento"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.neighborhood"
									variant="outlined"
									label="Vizinhança"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.street"
									variant="outlined"
									label="Rua"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="user.city_state"
									variant="outlined"
									label="Cidade/Estado"
									:rules="[rules.required]"
								/>
							</v-col>
						</v-row>
					</v-card-text>
					<!-- Ações do Formulário-->
					<v-card-actions>
						<v-btn
							v-if="!editing"
							:disabled="loadingButton"
							color="success"
							type="submit"
							@click="createUser"
						>
							Salvar
						</v-btn>
						<v-btn
							v-else
							:disabled="loadingButton"
							color="success"
							type="submit"
							@click="updateUser"
						>
							Atualizar
						</v-btn>
						<v-btn color="red" @click="dialog = false">
							Cancelar
						</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</v-container>
</template>
<script setup>
// Imports
import { mask } from "vue-the-mask"
const vMask = { mounted: mask }

const { notify } = useNotification()

const loading = ref(true)
const valid = ref(false)
const dialog = ref(false)
const editing = ref(false)
const loadingButton = ref(false)
const search = ref("")

const user = reactive({
	id: null,
	name: "",
	admin: 0,
	email: "",
	password: "",
	company: "",
	phone: "",
	cpf: "",
	cnpj: "",
	cep: "",
	addressNumber: "",
	additionalAddress: "",
	neighborhood: "",
	street: "",
	city_state: "",
})

// Regras de validação
const rules = {
	email: (value) => {
		if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test(value))
			return true
		return "O e-mail deve ser válido"
	},
	cpf: (value) => {
		if (value && value.length == 14) return true
		return "O CPF tem que ter 11 Caracteres"
	},
	cnpj: (value) => {
		if (value && value.length == 18) return true
		return "O CNPJ tem que ter 14 Caracteres"
	},
	phone: (value) => {
		if (value && value.length <= 15 && value.length >= 14) return true
		return "O Telefone tem que ter entre 10 e 11 Caracteres"
	},
	addressNumber: (value) => {
		if (value && value.length <= 6) return true
		return "O Endereço não pode ter mais que 6 Caracteres"
	},
	cep: (value) => {
		if (value && value.length == 9) return true
		return "O CEP tem que ter 8 Caracteres"
	},
	required: (value) => !!value || "Campo obrigatório",
}

const headers = createTableHeaders(
	new Map([
		["ID", "id"],
		["Admin", "admin"],
		["Nome", "name"],
		["Email", "email"],
		["Empresa", "company"],
		["Telefone", "phone"],
		["CPF", "cpf"],
		["CNPJ", "cnpj"],
		["CEP", "cep"],
		["Endereço", "addressNumber"],
		["Complemento", "additionalAddress"],
		["Rua", "street"],
		["Vizinhança", "neighborhood"],
		["Cidade/Estado", "city_state"],
	]),
)
headers.push({
	title: "Ações",
	key: "actions",
	sortable: false,
	align: "center",
})

const users = ref([])
const { refresh, pending } = useAsyncData("usuarios", () =>
	useDataLoader("/api/users")
		.then((res) => (users.value = res.data ? res.data : []))
		.catch((err) => {
			console.error(err)
			return (users.value = [])
		}),
)

function openCreate() {
	dialog.value = true
	editing.value = false

	Object.keys(user).forEach((key) => {
		key === "id" ? (user[key] = null) : (user[key] = "")
	})
}

function openEdit(item) {
	dialog.value = true
	editing.value = true

	Object.keys(user).forEach((key) => {
		if (key === "admin") {
			user[key] = !!item[key]
		} else {
			user[key] = item[key]
		}
	})
}

async function createUser() {
	// Caso a validação não passe, a função é interrompida
	if (!valid.value) return

	const formData = new FormData()
	Object.keys(user).forEach((key) => {
		if (key === "admin") {
			formData.append(key, user[key] ? 1 : 0)
			return
		}
		if (key !== "id") formData.append(key, user[key])
	})

	loadingButton.value = true
	await useDataLoader("/api/users", {
		method: "POST",
		body: formData,
	})
		.then(() => {
			notify({
				text: "Usuário criado com sucesso.",
				type: "success",
			})
			dialog.value = false
			loadingButton.value = false
			refresh()
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			loadingButton.value = false
			notify({
				title: `Erro ao criar usuário`,
				text: `${formatError(error)}`,
				type: "error",
			})
		})
}

async function updateUser() {
	// Caso a validação não passe, a função é interrompida
	if (!valid.value) return

	const userUpdate = {}

	Object.keys(user).forEach((key) => {
		if (key === "admin") {
			userUpdate[key] = user[key] ? 1 : 0
			return
		}
		if (key !== "id" && key !== "email" && key !== "password")
			userUpdate[key] = user[key]
	})

	loadingButton.value = true
	await useDataLoader("/api/users/" + user.id, {
		method: "PUT",
		body: userUpdate,
	})
		.then(() => {
			notify({
				text: "Usuário atualizado com sucesso.",
				type: "success",
			})
			dialog.value = false
			refresh()
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			console.error(error)

			notify({
				title: `Erro ao criar usuário`,
				text: `${formatError(error)}`,
				type: "error",
			})
		})
	loadingButton.value = false
}

async function deleteUser(id) {
	// Caso o usuário cancele a ação, a função é interrompida
	const ok = confirm("Deseja realmente deletar esse usuário?")
	if (!ok) return

	let currentUserID = null

	await useDataLoader(`/api/user`)
		.then((response) => {
			currentUserID = response.id
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			console.error(error)

			notify({
				title: `Erro ao deletar usuário`,
				text: `${formatError(error)}`,
				type: "error",
			})
			return
		})

	// Verifica se o usuario nao esta deletando a si mesmo
	if (currentUserID === id) {
		notify({
			title: `Erro ao deletar usuário`,
			text: `Você não pode deletar a si mesmo`,
			type: "error",
		})
		return
	}

	await useDataLoader(`/api/users/${id}`, {
		method: "DELETE",
	})
		.then(() => {
			notify({
				text: "Usuário deletado com sucesso.",
				type: "success",
			})
			refresh()
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			console.error(error)

			notify({
				title: `Erro ao deletar usuário`,
				text: `${formatError(error)}`,
				type: "error",
			})
		})
}

// Termina o loading da página
onMounted(() => {
	loading.value = false
})

definePageMeta({
	layout: "admin",
	middleware: ["guest", "admin"],
})
useSeoMeta({
	title: "Edição de usuários",
	keywords: "perfil, usuário, sistema, nostrosole",
	description:
		"Visualize as suas informações dos usuários do sistema Nostrosole",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/ico",
			href: "/favicon.ico",
		},
	],
})
</script>
