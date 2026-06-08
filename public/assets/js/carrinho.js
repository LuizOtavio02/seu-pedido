document.addEventListener('DOMContentLoaded', function () {
    carrinho();
});

function carrinho() {
    fetch('/api/carrinho', {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            let html = '';

            if (!data.produtos || data.produtos.length === 0) {
                html = `
                        <tr>
                            <td colspan="6" class="text-center">
                                🛒 Seu carrinho está vazio
                            </td>
                        </tr>
                    `;

                document.getElementById('tbody').innerHTML = html;
                document.getElementById('tfoot').innerHTML = '';

                return;
            }

            data.produtos.forEach(produto => {
                html += `<tr>
                <th>${produto.produtos.id}</th>
                <td>${produto.produtos.nome}</td>
                <td>${formatarMoeda(produto.produtos.preco)}</td>
                <td>
                    <strong class="qtd">${produto.quantidade}</strong>
                    <button type="button" class="btn-qtd btn btn-outline-primary btn-sm ms-3" data-id="${produto.produtos.id}" value="1">+</button>
                    <button type="button" class="btn-qtd btn btn-outline-primary btn-sm " data-id="${produto.produtos.id}" value="-1">-</button>
                </td>
                <td>${formatarMoeda(produto.valorTotal)}</td>
                <td>
                    <button type="button" class="btn-delete btn btn-outline-danger btn-sm ms-4" data-id="${produto.produtos.id}">Remover</button>
                </td>
            </tr>`
            });

            let htmlFoot = '';
            htmlFoot += `<tr>
                <td colspan="3">
                    <strong>Total da Compra: ${formatarMoeda(data.total.valorCarrinho)}</strong>
                </td>
            </tr>`;

            document.getElementById('tbody').innerHTML = html;
            document.getElementById('tfoot').innerHTML = htmlFoot;
        })
        .catch(error => {
            console.log('Erro: ', error);
        })
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-qtd')) {
        e.preventDefault();

        const produtoId = e.target.getAttribute('data-id');
        const value = e.target.getAttribute('value');

        fetch('/api/carrinho/' + produtoId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'id': produtoId,
                'qtd': value
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    carrinho();
                }
            })
            .catch(error => {
                console.log('Erro: ', error);
            })
    }

});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-delete')) {
        e.preventDefault();

        const produtoId = e.target.getAttribute('data-id');

        fetch('/api/carrinho/' + produtoId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'id': produtoId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    carrinho();
                }
            })
            .catch(error => {
                console.log('Erro: ', error);
            })

    }

});

document.getElementById('form-busca-cliente').addEventListener('submit', function (e) {
    e.preventDefault();

    const termo = document.querySelector('input[name="b"]').value;
    const messageDiv = document.getElementById('message');

    if (termo == "") {
        messageDiv.textContent = "Preencha o campo";
        return;
    }

    fetch(`/api/cliente?b=${termo}`, {
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

                                            <p id="cliente-id" class="mb-1 text-muted">
                                                Id: ${data.data.id}
                                            </p>

                                            <p class="mb-1 text-muted">
                                                rua: ${data.endereco.rua}
                                            </p>

                                            <p class="mb-1 text-muted">
                                                bairro: ${data.endereco.bairro}
                                            </p>

                                            <p class="mb-1 text-muted">
                                                numero: ${data.endereco.numero}
                                            </p>

                                            <p class="mb-1 text-muted">
                                                cidade: ${data.endereco.cidade}
                                            </p>
                                            

                                        </div>

                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                            <button class="btn btn-outline-dark">
                                                Editar
                                            </button>
                                            <button id="cliente-confirma" data-id="${data.data.id}" class="btn btn-outline-success">
                                                Confirma
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
                                                Cliente Não Encontrado
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

});

document.addEventListener('click', function (e) {
    if (e.target.id === 'cliente-confirma') {
        e.preventDefault();

        const id = e.target.dataset.id;

        fetch('/api/carrinho/cliente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                cliente_id: id
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    e.target.textContent = 'Confirmado';
                    e.target.classList.remove('btn-outline-success');
                    e.target.classList.add('btn-success');
                    e.target.disabled = true;
                }
            })
            .catch(error => console.log('Erro:', error));
    }
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('finalizar-compra')) {
        e.preventDefault();
        
        fetch('/api/preference', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.url) {
                window.location.href = data.url;
            }
        })
    }
    
});