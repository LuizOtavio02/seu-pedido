async function carregarProdutos(valor) {
    if (valor.length >= 3) {
        const dados = await fetch('/api/produtos/autocomplete/' + valor);
        const resposta = await dados.json();
        console.log(resposta);

        var resultado = "<ul class='list-group position-fixed'>"

        if (resposta['success']) {
            for (let i = 0; i < resposta['data'].length; i++) {
                resultado += "<li class='list-group-item list-group-item-action' onclick='listarProduto(" + JSON.stringify(resposta['data'][i].nome) + "," + JSON.stringify(resposta['data'][i].id) + ")'>" + resposta['data'][i].nome + "</li>";
            }
        } else {
            resultado += "<li class='list-group-item disabled'> Não Encontrou </li>"
        }

        resultado += "</ul>"

        document.getElementById("resultadoPesquisa").innerHTML = resultado;
    }
}

const fechar = document.getElementById('produto');

document.addEventListener('click', function (e) {
    const validarClick = fechar.contains(e.target);
    if (!validarClick) {
        document.getElementById('resultadoPesquisa').innerHTML = '';
    }
})

let produtoId = "";

function listarProduto(nome, id) {
    console.log(nome, id);
    produtoId = id;
    document.getElementById("pesquisaProduto").value = nome;
}

document.getElementById('form-busca').addEventListener('submit', function (e) {
    e.preventDefault();

    const messageDiv = document.getElementById('message');

    if (produtoId == "") {
        messageDiv.textContent = "Preencha o campo";
        return;
    }

    fetch(`/api/produtos/${produtoId}`, {
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
                                        <h5>${data.data.nome}</h5>

                                        <p>Id: ${data.data.id}</p>

                                        <p>preço: ${data.data.preco}</p>

                                        <p>estoque: ${data.data.estoque}</p>

                                        <p>slug: ${data.data.produto_slug}</p>

                                        <span class="badge bg-dark">
                                            ${data.data.categoria_id}
                                        </span>
                                    </div>

                                    <div class="col-md-4 text-end">
                                        <button
                                            class="btn btn-outline-dark btn-editar"
                                            data-id="${data.data.id}"
                                            data-nome="${data.data.nome}"
                                            data-preco="${data.data.preco}"
                                            data-estoque="${data.data.estoque}"
                                            data-slug="${data.data.produto_slug}"
                                            data-categoria-id="${data.data.categoria_id}">
                                            Editar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>`;
                document.getElementById('resultadoBusca').innerHTML = html;

                const botao = document.querySelector('.btn-editar');

                botao.addEventListener('click', function () {

                    document.getElementById('editar-id').value =
                        this.dataset.id;

                    document.getElementById('editar-nome').value =
                        this.dataset.nome;

                    document.getElementById('editar-preco').value =
                        this.dataset.preco;

                    document.getElementById('editar-estoque').value =
                        this.dataset.estoque;

                    document.getElementById('editar-slug').value =
                        this.dataset.slug;

                    document.getElementById('editar-categoriaId').value =
                        this.dataset.categoriaId;

                    const modal = new bootstrap.Modal(
                        document.getElementById('modalEditar')
                    );

                    modal.show();
                });

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


document.getElementById('salvar-edicao')
    .addEventListener('click', async function () {

        const id = document.getElementById('editar-id').value;

        const dados = {
            nome: document.getElementById('editar-nome').value,
            username: document.getElementById('editar-username').value,
            tipo: document.getElementById('editar-tipo').value
        };

        const response = await fetch(`/api/funcionario/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        });

        const data = await response.json();

        console.log(data);
    });