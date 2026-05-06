document.addEventListener('DOMContentLoaded', function () {
    carrinho();
});

function carrinho() {
    fetch('/api/carrinho', {
        method: 'GET'
    })
        .then((response => response.json()))
        .then(data => {
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

})

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

})
