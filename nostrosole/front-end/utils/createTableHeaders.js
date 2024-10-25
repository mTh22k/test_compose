/**
 * Função para criar múltiplos cabecalhos de uma tabela de uma só vez,
 * Evita muitas linhas de código
 *
 * @param {function} headerMap - uma função Map que retorna um array com os nomes e valores dos cabecalhos
 * @return {Object} headers - Array com os cabecalhos
 */

export default (headerMap) => {
	const headers = []
	// Itera sobre o Map, aqui os nomes das chaves de identificação dos cabecalhos
	// e os valores dos cabecalhos sao iguais
	headerMap.forEach((value, key) => {
		headers.push({
			title: key,
			key: value,
			value: value,
		})
	})
	return headers
}
