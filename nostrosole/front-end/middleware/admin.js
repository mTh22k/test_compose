/* eslint-disable */
export default defineNuxtRouteMiddleware((to, from) => {
	const cookieAdmin = useCookie("admin", {
		sameSite: true,
	})

	// Verifica se o usuário é admin
	if (cookieAdmin.value !== true) {
		return navigateTo("/sistema", { redirectCode: 200 })
	}
})
