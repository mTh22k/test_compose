/* eslint-disable */
/**
 * * Middleware de autenticação (acontece antes da pagina carregar)
 * ? Verifica se o usuario não esta autenticado
 *
 * Se o usuário não tiver token ou tiver com authenticated false, redireciona para /login
 * Utiliza o hook useCookie para pegar o token e authenticated
 *
 * @param {Object} to - Pagina que o usuario esta tentando acessar
 * @param {Object} from - Pagina que o usuario esta vindo
 */
export default defineNuxtRouteMiddleware((to, from) => {
	const cookieAuth = useCookie("authenticated", {
		sameSite: true,
	})
	const cookieToken = useCookie("token", {
		sameSite: true,
	})

	// Redireciona para a página de LOGIN, caso não esteja autenticado
	if (!cookieAuth.value || !cookieToken.value) {
		return navigateTo("/", { redirectCode: 401 })
	}
})
