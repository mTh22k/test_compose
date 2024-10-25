<template>
	<NuxtNotifications />
	<v-navigation-drawer class="menu-wrapper" width="300" permanent>
		<div class="menu-content d-flex align-center flex-column">
			<div>
				<nuxt-link to="/sistema">
					<v-img
						width="250px"
						height="250px"
						src="/images/logoBranca.png"
					/>
				</nuxt-link>
			</div>
			<div class="menu-line"></div>
			<!-- Seção dos botões -->
			<div
				v-for="(button, index) in buttons"
				:key="index"
				class="buttons-container"
			>
				<v-btn
					v-if="!button.onlyAdmin || checkAdmin()"
					:color="button.color"
					:to="button.to"
					class="personalized-buttons"
					variant="text"
					@click="button.action()"
				>
					<span class="button-text"> {{ button.text }}</span>
				</v-btn>
			</div>
			<div class="menu-line"></div>
			<!-- Seção Fale Conosco -->
			<a :href="contactLink" target="_BLANK">
				<div class="d-flex justify-content-between align-items-center">
					<v-img
						class="contact-img"
						src="/images/auth/faleConosco.png"
					/>
					<span class="contact">Fale conosco</span>
				</div>
			</a>
		</div>
	</v-navigation-drawer>
</template>
<script setup>
import { useAuthStore } from "~/store/auth"

//Utiliza o link definido no nuxt.config
const config = useRuntimeConfig()
const contactLink = config.public.contactLink

// Botões que aparecem no Menu Lateral
const buttons = [
	{
		text: "Cadastrar projeto",
		color: "#007bed",
		to: "/sistema/cadastrar-projeto",
		action: () => {},
	},
	{
		text: "Em andamento",
		color: "#007bed",
		to: "/sistema/andamento",
		action: () => {},
	},
	{
		text: "Finalizados",
		color: "#007bed",
		to: "/sistema/finalizados",
		action: () => {},
	},
	{
		text: "Minha conta",
		color: "#007bed",
		to: "/sistema/perfil",
		action: () => {},
	},
	{
		text: "Dashboard",
		color: "#007bed",
		to: "/sistema/admin",
		action: () => {},
		onlyAdmin: true,
	},
	{
		text: "Sair",
		color: "#007bed",
		to: "",
		action: () => {
			logout()
		},
	},
]

/**
 * Funcao que verifica se o usuario eh admin
 * Usa o composable useCookie ADMIN para verificar
 * Verifica se o usuário é ADMIN ou não, pelo useCookie
 * @noparams
 * @return {bool} - Se o usuario eh Admin ou nao
 */
function checkAdmin() {
	const adminFlag = useCookie("admin")
	return adminFlag.value
}

/**
 * Funcao que desconecta o usuario do sistema
 * Remove os cookies
 * Joga o usuario para o login
 * ! Utiliza-se da STORE de auth.js
 */
async function logout() {
	const router = useRouter()
	const { logUserOut } = useAuthStore()

	await logUserOut() // Redirecionar para o login
	return router.push("/")
}
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap");

.menu-wrapper {
	background: linear-gradient(
		180deg,
		rgba(0, 132, 255, 0.54) 0%,
		rgba(0, 123, 237, 0.1728) 100%
	);
	width: 350px;
	height: 100vh;
	display: flex;
	flex-direction: column;
	text-align: center;
}

.menu-content {
	position: relative;
	top: 19px;
}

.menu-line {
	width: 205px;
	background-color: #007bed;
	height: 1px;
	margin-bottom: 23px;
	margin-top: 29px;
}

.buttons-container {
	display: flex;
	flex-direction: column;
	color: #007bed;
	font-size: 20px;
	font-family: "Hind", sans-serif;
	align-items: center;
	justify-content: center;
	line-height: 32px;
}

.personalized-buttons {
	line-height: unset;
	text-transform: unset;
	letter-spacing: unset;
	padding: 0;
	margin-top: 12px;
}

.button-text {
	border-radius: 10px;
	box-shadow: 0px 4px 4px 0px #00000040;

	width: 203px;
	height: 37px;
	align-items: center;
	display: flex;
	justify-content: center;

	background-color: #007bed;
	color: #ffffff;
	font-size: 20px;
	line-height: 0px;
	font-weight: 400;
}

.contact-img {
	width: 34px;
	height: 34px;
	margin-right: 10px;
}

.contact {
	color: #007bed;
	font-family: "Fredoka", sans-serif;
	font-size: 25px;
	font-weight: 500;
}

a {
	text-decoration: none;
}
</style>
