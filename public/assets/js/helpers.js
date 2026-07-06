function formatarMoeda(valor) {
    return valor.toLocaleString('pt-br', {style: 'currency', currency: 'BRL', minimumFractionDigits: 2});
}

async function carregarProdutos(valor) {
    if (valor.length >= 3) {
        const dados = await fetch('/api/equipe/' + valor);
        const resposta = await dados.json();
        console.log(resposta);

        var resultado = "<ul class='list-group position-fixed'>"

        if (resposta['success']) {
            for (let i = 0; i < resposta['data'].length; i++) {
                resultado += "<li class='list-group-item list-group-item-action'>" + resposta['data'][i].nome + "</li>";
            }
        } else {
            resultado += "<li class='list-group-item disabled'> Não Encontrou </li>"
        }

        resultado += "</ul>"

        document.getElementById("resultadoPesquisa").innerHTML = resultado;
    }
}