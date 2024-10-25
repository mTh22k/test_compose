/* eslint-disable */
/**
 * Middleware de verificação de projetos
 *
 * @param {Object} to - Pagina que o usuario esta tentando acessar
 * @param {Object} from - Pagina que o usuario esta vindo
 */
export default defineNuxtRouteMiddleware((to, from) => {
	// Retorna o usuário para home page, caso não exista um ID
	if (!to.query.id || isNaN(to.query.id)) {
		return abortNavigation("ID de projeto inválido")
	}
})
