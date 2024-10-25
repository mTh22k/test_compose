export default {
	// Verifica se o campo é obrigatório
	required: (value) => {
		return !!value || "Este campo é obrigatório"
	},
	// Verifica se a marca do modelo está no formato correto
	moduleBrand: (v) => /^[a-zA-Z\s]*$/.test(v) || "Digite apenas letras",
}
