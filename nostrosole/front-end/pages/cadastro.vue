<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<!-- Retirado o componente auth-title pois não podia mudar a font, retirar o gray-scale da imagem e mudar o tamanho da imagem -->
		<!-- Titulo -->
		<div class="d-flex flex-column align-center pb-2">
			<v-img src="/images/logo.png" width="200"></v-img>
			<span class="fredoka-normal text-h5">CADASTRO DE INTEGRADOR</span>
		</div>
		<!-- 
			Forms no qual a cada item do objeto "titles" é criada uma coluna/input onde o tamanho da coluna, o seu titulo, a sua regra e 
			variavel no qual recebera o valor do campo do input(model) será ditada pelas informações do objeto, nesse caso "titulos"
			Caso a instancia de "titulos" tenha masked = true, ele coloca o text-field com mascara, se nao ele coloca um text-field sem
			nenhuma mascara, se tiver password, ele escondera a senha e tera um icone para ver a senha
		-->
		<v-form v-model="valid" @submit.prevent>
			<v-row class="mb-3">
				<v-col
					v-for="(titulos, index) in titles"
					:key="index"
					:cols="titulos.cols"
					:md="titulos.size"
					class="py-0"
				>
					<v-text-field
						v-if="titulos.masked"
						v-model="titulos.model.value"
						v-mask="titulos.mask"
						:rules="titulos.rule"
						:placeholder="titulos.title"
						:label="titulos.title"
						class="mt-3 text-test"
						variant="outlined"
						rounded="lg"
						density="compact"
						:maxlength="titulos.length"
						@keydown="checkDigit"
					/>
					<v-text-field
						v-else-if="titulos.password && !titulos.masked"
						v-model="titulos.model.value"
						:append-icon="
							titulos.show.value ? 'mdi-eye' : 'mdi-eye-off'
						"
						:type="titulos.show.value ? 'text' : 'password'"
						:rules="titulos.rule"
						:placeholder="titulos.title"
						:label="titulos.title"
						class="mt-3 text-test"
						variant="outlined"
						rounded="lg"
						density="compact"
						@click:append="titulos.show.value = !titulos.show.value"
					/>
					<v-text-field
						v-else
						v-model="titulos.model.value"
						:rules="titulos.rule"
						:placeholder="titulos.title"
						:label="titulos.title"
						class="mt-3 text-test"
						variant="outlined"
						rounded="lg"
						density="compact"
					/>
				</v-col>
			</v-row>
			<!-- Botao no qual ira enviar as informacoes pro back -->
			<v-btn
				type="submit"
				class="mb-1 mt-3"
				color="#007bed"
				size="x-large"
				density="comfortable"
				rounded="lg"
				@click="signIn"
			>
				CADASTRAR
			</v-btn>
		</v-form>
		<v-row class="mt-2 d-flex flex-column justify-center">
			<span>
				Já tem uma conta?
				<nuxt-link class="auth-link mt-2 mb-4" to="/">
					Entrar
				</nuxt-link>
			</span>
		</v-row>
	</v-container>
	<!-- Conteudo da pagina -->
</template>

<script setup>
// Imports
import { mask } from "vue-the-mask"
const vMask = { mounted: mask }

// Utilizar o snackbar
const { notify } = useNotification()

// Regras e validade do formulário
const valid = ref(false)
const rules = {
	name: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
	],
	email: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
		(value) => {
			if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test(value))
				return true
			return "O e-mail deve ser válido"
		},
	],
	password: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
	],
	// A segunda validação é para não enviar um dado com mais ou menos caractecteres
	cpf: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
		(value) => {
			if (value && value.length == 14) return true
			return "O CPF tem que ter 11 Caracteres"
		},
	],
	cnpj: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
		(value) => {
			if (value && value.length == 18) return true
			return "O CNPJ tem que ter 14 Caracteres"
		},
	],
	telephone: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
		(value) => {
			if (value && value.length <= 15 && value.length >= 14) return true
			return "O Telefone tem que ter entre 10 e 11 Caracteres"
		},
	],
	// A segunda validação é para conferir se é um numero ou não
	number: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
		(value) => {
			if (!/\D/g.test(value)) return true
			return "O Numero deve ser válido"
		},
		(value) => {
			if (value && value.length <= 6) return true
			return "O numero não pode ser maior do que 6 digitos"
		},
	],
	cep: [
		(value) => {
			if (value) return true
			return "O campo é necessário"
		},
		(value) => {
			if (value && value.length == 9) return true
			return "O CEP tem que ter 8 Caracteres"
		},
	],
}

// Campos do formulário
/* Objeto titles -> [Campo do formulario] :
{
	title : [nome do campo],
	size: [tamanho da coluna em md],
	cols: [tamanho da coluna em cols],
	rule: [rule utilizada],
	model: [informação dos inputs]
	masked: [Se utilizara mask]
	mask: [A mask utilizada]
	password: [Se é um password],
	show: [Se mostrara a Password],
}*/
const titles = {
	nameEmp: {
		title: "Empresa",
		name: "company",
		cols: 12,
		size: 6,
		rule: rules.name,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	cnpj: {
		title: "CNPJ",
		name: "cnpj",
		cols: 6,
		size: 6,
		rule: rules.cnpj,
		model: ref(""),
		masked: true,
		mask: ["##.###.###/####-##"],
		length: 18,
		password: false,
		show: ref(false),
	},
	cep: {
		title: "CEP",
		name: "cep",
		cols: 6,
		size: 3,
		rule: rules.cep,
		model: ref(""),
		masked: true,
		mask: ["#####-###"],
		length: 9,
		password: false,
		show: ref(false),
	},
	city: {
		title: "Cidade/UF",
		name: "city_state",
		cols: 12,
		size: 4,
		rule: rules.name,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	neighborhood: {
		title: "Bairro",
		name: "neighborhood",
		cols: 12,
		size: 5,
		rule: rules.name,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	place: {
		title: "Logradouro",
		name: "street",
		cols: 12,
		size: 7,
		rule: rules.name,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	number: {
		title: "N°",
		name: "addressNumber",
		cols: 4,
		size: 2,
		rule: rules.number,
		model: ref(""),
		masked: true,
		mask: ["######"],
		length: 6,
		password: false,
		show: ref(false),
	},
	complement: {
		title: "Complemento",
		name: "additionalAddress",
		cols: 8,
		size: 3,
		rule: rules.name,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	email: {
		title: "EMAIL",
		name: "email",
		cols: 12,
		size: 6,
		rule: rules.email,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	telephone: {
		title: "TELEFONE",
		name: "phone",
		cols: 12,
		size: 6,
		rule: rules.telefon,
		model: ref(""),
		masked: true,
		mask: ["(##) ####-####", "(##) #####-####"],
		length: 15,
		password: false,
		show: ref(false),
	},
	nameRes: {
		title: "NOME DO RESPONSÁVEL",
		name: "name",
		cols: 12,
		size: 6,
		rule: rules.name,
		model: ref(""),
		masked: false,
		password: false,
		show: ref(false),
	},
	cpfRes: {
		title: "CPF DO RESPONSÁVEL",
		name: "cpf",
		cols: 12,
		size: 6,
		rule: rules.cpf,
		model: ref(""),
		masked: true,
		mask: ["###.###.###-##"],
		length: 14,
		password: false,
		show: ref(false),
	},
	password: {
		title: "Escolha uma senha",
		name: "password",
		cols: 12,
		size: 12,
		rule: rules.password,
		model: ref(""),
		masked: false,
		password: true,
		show: ref(false),
	},
}

// Funções
// Função que checa se o que esta sendo digitado é um numero, se não ele prevem que o input seja colocado
const checkDigit = (event) => {
	if (
		event.key.length === 1 &&
		(isNaN(Number(event.key)) || event.key == " ")
	) {
		event.preventDefault()
	}
}

async function signIn() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value) {
		// Feedback de Loading
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})

		// Envia os dados para o backend
		const formSignup = new FormData()
		// Pega todos os objetos com os dados e coloca numa variavel para ser enviado para o back
		Object.keys(titles).map((key) => {
			formSignup.append(titles[key].name, titles[key].model.value)
		})
		formSignup.append("admin", 0)
		useDataLoader("/api/signup", {
			method: "POST",
			body: formSignup,
		})
			.then(() => {
				// Feedback do erro por meio da snackbar
				notify.close("loading")
				notify({
					title: "Sucesso",
					text: "Usuário criado com sucesso!",
					type: "success",
				})

				const router = useRouter()
				router.push("/")
			})
			.catch((error) => {
				const errors = formatError(error)
				console.error(error)

				// Feedback do erro por meio da snackbar
				notify.close("loading")
				notify({
					title: "Não foi possível registrar",
					text: `${errors}`,
					type: "error",
				})
			})
	} else {
		notify({
			text: "Preencha os campos corretamente para continuar",
			type: "info",
		})
	}
}

// Layout da página e cabeçalho
definePageMeta({
	layout: "register",
	middleware: ["auth"],
})
useSeoMeta({
	title: "Registro - Nostrosole",
	description: "Registre-se para acessar o sistema Nostrosole",
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

<style scoped>
/* Font do titulo */
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
.fredoka-normal {
	font-family: "Fredoka", sans-serif;
	font-optical-sizing: auto;
	font-weight: 800;
	font-style: normal;
	font-variation-settings: "wdth" 100;
	color: #007bed;
}

/* Sobrepoe uma classe adicionando drop shadow nos inputs*/
.text-test :deep(.v-field__outline) {
	box-shadow: rgba(0, 0, 0, 0.25) 4px 4px 10px;
}

.auth-link {
	color: #007bed;
	font-size: 1.1rem;
	text-decoration: none;
	font-weight: 600;
}

.auth-link:hover {
	color: #003e79;
}
</style>
