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
    .catch( error => {
        console.log('Erro: ', error);
    })
}
