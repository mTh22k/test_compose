import "@mdi/font/css/materialdesignicons.css"

import "vuetify/styles"
import { createVuetify } from "vuetify"
import { en, pt } from "vuetify/locale"

export default defineNuxtPlugin((app) => {
	const vuetify = createVuetify({
		locale: {
			locale: "pt",
			fallback: "en",
			messages: { pt, en },
		},
		ssr: true,
	})
	app.vueApp.use(vuetify)
})

