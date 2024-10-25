<template>
	<v-app full-height theme="dark">
		<!-- Drawer que contém os links para as páginas -->
		<v-no-ssr>
			<v-navigation-drawer v-model="drawer">
				<!-- Logo e nome do Projeto -->
				<v-list lines="3" class="my-2">
					<v-list-item title="Nostrosole">
						<template #prepend>
							<v-img
								width="70"
								height="70"
								contain
								class="mr-4"
								src="/images/logo.png"
								alt="Logo da Nostrosole"
							/>
						</template>
					</v-list-item>
				</v-list>
				<!-- Logo e nome do Projeto -->
				<!-- Itens do drawer -->
				<v-list nav>
					<v-list-item
						v-for="(item, i) in drawerItems"
						:key="i"
						:to="item.link"
						:base-color="theme.drawerTextColor"
						:prepend-icon="item.icon"
						:title="item.title"
						:subtitle="item.subtitle"
						lines="3"
						class="my-1 py-1 drawer-text"
					/>
				</v-list>
				<!-- Itens do drawer -->
			</v-navigation-drawer>
		</v-no-ssr>
		<!-- Drawer que contém os links para as páginas -->
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<v-app-bar class="primary-color">
			<v-app-bar-nav-icon
				class="text-color"
				@click.stop="drawer = !drawer"
			/>
			<v-toolbar-title class="text-color">
				Painel do Administrador
			</v-toolbar-title>
		</v-app-bar>
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<!-- Conteúdo -->
		<v-main>
			<NuxtPage />
		</v-main>
		<!-- Conteúdo -->
		<!-- Footer -->
		<v-no-ssr>
			<v-footer app inset class="primary-color">
				<span class="text-color"> &copy; Ecomp 2024 </span>
			</v-footer>
		</v-no-ssr>
		<!-- Footer -->
	</v-app>
</template>
<script setup>
// Variáveis de ambiente
const drawer = ref(false)

// Array de paginas que serão exibidas no drawer
const drawerItems = [
	{
		icon: "mdi-account-group",
		title: "Usuários",
		subtitle: "Crie e edite usuários",
		link: "/sistema/admin/usuarios",
	},
	{
		icon: "mdi-projector-screen",
		title: "Projetos",
		subtitle: "Crie e edite projetos",
		link: "/sistema/admin/projetos",
	},
	{
		icon: "mdi-home",
		title: "Voltar",
		subtitle: "Retorne para a página inicial",
		link: "/sistema",
	},
]

// Tema que será utilizado na dashboard
const theme = {
	/* Fundo do Drawer da dashboard */
	drawerTextColor: "#ffffff",
	/* Cores de fundo da dashboard  */
	backgroundColor: "#1f1f1f",
	/* Cores de texto da dashboard  */
	textColor: "#ffffff",
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Painel do administrador",
	description: "Painel de controle do administrador do sistema",
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
@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

.drawer-text {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}
.primary-color {
	background-color: v-bind("theme.backgroundColor") !important;
}
.text-color {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	color: v-bind("theme.textColor") !important;
}

.drawer-logo :deep(.v-list-item-subtitle),
.drawer-text :deep(.v-list-item-subtitle) {
	word-break: normal !important;
}
</style>
