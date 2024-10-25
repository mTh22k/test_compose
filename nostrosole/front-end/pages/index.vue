<template>
	<!-- Conteudo da pagina -->
	<NuxtNotifications v-if="!loading" />
	<!-- Conteudo da pagina -->
	<layout-loading :loading="loading" />
	<v-container v-if="!loading" fluid class="ma-0 pa-0 text-center">
		<v-row>
			<v-col
				class="left-side d-flex flex-column justify-center align-center"
				cols="6"
			>
				<div>
					<h2 class="welcome-title">Bem-vindo, integrador!</h2>
					<v-img src="/images/logo.png" />
				</div>
				<span class="my-6 register-hint">Ainda não tem cadastro?</span>
				<div class="d-flex flex-column mb-9">
					<v-btn
						class="btn-register text-none"
						size="large"
						rounded="lg"
						height="58"
						min-width="184"
						to="/cadastro"
					>
						Cadastrar
					</v-btn>
				</div>
				<div
					class="d-flex justify-space-around align-center mr-6"
					style="min-width: 180px"
				>
					<v-img
						src="/images/auth/fale-conosco.svg"
						width="52"
						height="52"
					/>
					<a
						:href="contactLink"
						target="_blank"
						class="fale-conosco-link"
					>
						Fale Conosco
					</a>
				</div>
			</v-col>
			<v-col
				class="right-side d-flex flex-column justify-center align-center"
				cols="6"
			>
				<div>
					<h2 class="login-title">Acesse sua conta</h2>
				</div>
				<div class="login-fields d-flex flex-column mt-6">
					<v-form v-model="valid">
						<v-text-field
							v-model="email"
							class="text-test"
							placeholder="Digite..."
							label="E-mail"
							type="email"
							:rules="rules.email"
							variant="outlined"
							@keyup.enter="login()"
						/>
						<v-text-field
							v-model="password"
							class="text-test my-1"
							placeholder="Digite..."
							label="Senha"
							:append-inner-icon="
								showPassword ? 'mdi-eye' : 'mdi-eye-off'
							"
							:rules="rules.password"
							:type="showPassword ? 'text' : 'password'"
							variant="outlined"
							@click:append-inner="showPassword = !showPassword"
							@keyup.enter="login()"
						/>
					</v-form>
				</div>
				<div
					class="remember-container d-flex flex-row justify-space-between align-center"
				>
					<v-checkbox v-model="remember_me" class="remember-checkbox">
						<template #label>
							<span class="remember-text">Lembre de mim</span>
						</template>
					</v-checkbox>
				</div>
				<div class="d-flex flex-column mb-9">
					<v-btn
						class="btn-login text-none"
						size="large"
						rounded="lg"
						height="48"
						min-width="324"
						:disabled="loadingLogin"
						@click="login()"
					>
						Acessar a plataforma
					</v-btn>
				</div>
				<nuxt-link class="my-6 recover-link" to="/esqueceu-a-senha">
					Esqueceu sua senha? Clique aqui.
				</nuxt-link>
			</v-col>
		</v-row>
	</v-container>
	<!-- Conteudo da pagina -->
</template>
<script setup>
// Import das funções e gerenciamento de STORE
import { storeToRefs } from "pinia"
import { useAuthStore } from "~/store/auth"

// Link do NUXT,CONFIG.JS do contato
const config = useRuntimeConfig()
const contactLink = config.public.contactLink

// Campos do formulário
const email = ref("")
const password = ref("")
const showPassword = ref(false)
const remember_me = ref(false)
const loadingLogin = ref(false)

const loading = ref(true) // Determina o LOADING para o usuário
const { notify } = useNotification() // Função de Notificação (feedback)

// Regras e validade do formulário
const valid = ref(false)
const rules = {
	email: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
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
			return "O campo é obrigatório"
		},
	],
}

// Função de autenticação da STORE
const { authenticateUser } = useAuthStore()
const { authenticated } = storeToRefs(useAuthStore())
const router = useRouter() // Função de roteamento do Nuxt.js

// Método de login
async function login() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value) {
		// Feedback que está carregando a requisição
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})
		loadingLogin.value = true

		// Envia os dados para o backend
		await authenticateUser({
			email: email.value,
			password: password.value,
			remember_me: remember_me.value,
		})
		if (authenticated.value) {
			// Redireciona para a home page do sistema
			router.push("/sistema")
		} else {
			// Feedback de erro
			notify.close("loading")
			loadingLogin.value = false
			notify({
				title: "Erro de autenticação",
				text: "Não foi possível autenticar o usuário. Verifique os dados e tente novamente.",
				type: "error",
			})
		}
	} else {
		// feedback de erro
		notify({
			text: "Preencha os campos corretamente para continuar",
			type: "info",
		})
	}
}

onMounted(() => {
	loading.value = false // Termina o loading da página
})

// Layout da página e middlewares
definePageMeta({
	layout: "login",
	middleware: ["auth"],
})

// Cabeçalho da página
useSeoMeta({
	description: "Página para login para acesso ao sistema da Nostrosole",
	keywords: "login, dashboard, acesso, nostrosole",
	title: "Login - Nostrosole",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/png",
			href: "/favicon.png",
		},
	],
})
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&family=Hind+Siliguri:wght@400;700&display=swap");

.auth-link {
	color: #3a7700;
	font-size: 1.1rem;
	text-decoration: none;
	font-weight: 600;
}

.auth-link:hover {
	color: #244407;
}

.left-side {
	background-color: #eeeeee;
	height: 100vh;

	font-family: "Fredoka", sans-serif;
}

.right-side {
	background-color: white;
}

.welcome-title,
.loading-text {
	color: #007bed;
	font-size: 600;
	font-size: 30px;
}

.register-hint {
	color: #007bed;
	font-weight: 500;
	font-size: 20px;
}

.btn-register,
.btn-login {
	background-color: #007bed;
	color: white;

	font-family: "Hind Siliguri", sans-serif;
	font-weight: 600;
}

.fale-conosco-link {
	color: #007bed;
	text-decoration: none;
}

.login-title {
	font-family: "Fredoka", sans-serif;
	font-weight: 600;
	font-size: 30px;

	color: #007bed;
}

.login-fields {
	min-width: 400px !important;
}

.remember-text,
.recover-link {
	color: #007bed;
	text-decoration: none;

	font-family: "Hind Siliguri", sans-serif;
	font-weight: 700;
	font-size: 20px;
}

:deep(.remember-container .v-label) {
	opacity: 1 !important;
}

/* Sobrepoe uma classe adicionando drop shadow nos inputs*/
.text-test :deep(.v-field__outline) {
	box-shadow: rgba(0, 0, 0, 0.25) 4px 4px 10px;
}
</style>
