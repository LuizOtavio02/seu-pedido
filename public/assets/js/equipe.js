async function carregarProdutos(valor) {
    if (valor.length >= 3) {
        const dados = await fetch('/api/equipe/autocomplete/' + valor);
        const resposta = await dados.json();
        console.log(resposta);

        var resultado = "<ul class='list-group position-fixed'>"

        if (resposta['success']) {
            for (let i = 0; i < resposta['data'].length; i++) {
                resultado += "<li class='list-group-item list-group-item-action' onclick='listarProduto("+ JSON.stringify(resposta['data'][i].nome) + "," + JSON.stringify(resposta['data'][i].id)+")'>" + resposta['data'][i].nome + "</li>";
            }
        } else {
            resultado += "<li class='list-group-item disabled'> Não Encontrou </li>"
        }

        resultado += "</ul>"

        document.getElementById("resultadoPesquisa").innerHTML = resultado;
    }
}

const fechar = document.getElementById('funcionario');

document.addEventListener('click', function (e) {
    const validarClick = fechar.contains(e.target);
    if (!validarClick) {
        document.getElementById('resultadoPesquisa').innerHTML = '';
    }    
})

let funcionarioId = "";

function listarProduto(nome, id) {
    console.log(nome, id);
    funcionarioId = id;
    document.getElementById("funcionario").value = nome;
}

document.getElementById('form-busca').addEventListener('submit', function (e) {
    e.preventDefault();

    const messageDiv = document.getElementById('message');

    if (funcionarioId == "") {
        messageDiv.textContent = "Preencha o campo";
        return;
    }

    fetch(`/api/equipe/${funcionarioId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            let html = '';

            if (data.success) {
                html += `<div class="card shadow-sm mb-3">

                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-8">

                                            <h5 class="mb-1">
                                                ${data.data.nome}
                                            </h5>

                                            <p class="mb-1 text-muted">
                                                Id: ${data.data.id}
                                            </p>

                                            <p class="mb-1 text-muted">
                                                Username: ${data.data.username}
                                            </p>

                                            <span class="badge bg-dark">
                                                ${data.data.tipo}
                                            </span>

                                        </div>

                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                            <button class="btn btn-outline-dark">
                                                Editar
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>`;
                document.getElementById('resultadoBusca').innerHTML = html;
                return;
            }

            html += `<div class="card shadow-sm mb-3">

                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-8">

                                            <h5 class="mb-1">
                                                Funcionário Não Encontrado
                                            </h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>`;
            document.getElementById('resultadoBusca').innerHTML = html;
        })
        .catch(error => [
            console.log('Erro: ', error)
        ])

})