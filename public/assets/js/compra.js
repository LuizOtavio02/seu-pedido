document.addEventListener('DOMContentLoaded', function () {
    carrinhoCompra();
});

function carrinhoCompra() {
    fetch('/api/carrinho', {
        method: 'GET'
    })
        .then((response => response.json()))
        .then(data => {
            console.log(data);
            let html = '';
            let htmlDireita = '';

            if (data.success) {
                html += `<div class="col-lg-8">

                <!-- Dados do Cliente -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Dados do Cliente</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Nome:</strong> ${data.cliente.dados.nome}</p>
                        <p class="mb-0"><strong>Telefone:</strong> ${data.cliente.dados.telefone}</p>
                    </div>
                </div>

                <!-- Endereço de Entrega -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Endereço</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Estado:</strong> ${data.cliente.endereco.estado}</p>
                        <p class="mb-0"><strong>Cidade:</strong> ${data.cliente.endereco.cidade}</p>
                        <p class="mb-1"><strong>Bairro:</strong> ${data.cliente.endereco.bairro}</p>
                        <p class="mb-0"><strong>Rua:</strong> ${data.cliente.endereco.rua}</p>
                        <p class="mb-1"><strong>numero:</strong> ${data.cliente.endereco.numero}</p>
                    </div>
                </div>

                <!-- Forma de Pagamento -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Forma de Pagamento</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pagamento" id="pix" value="pix" checked>
                            <label class="form-check-label" for="pix">
                                Pix
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pagamento" id="cartao" value="cartao">
                            <label class="form-check-label" for="cartao">
                                Cartão de Crédito
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pagamento" id="dinheiro" value="dinheiro">
                            <label class="form-check-label" for="dinheiro">
                                Dinheiro
                            </label>
                        </div>
                    </div>
                </div>

            </div>`;
            }

            if (data.success) {
                let itens = '';

                data.produtos.forEach(produto => {
                    itens += `
                    <div class="d-flex justify-content-between mb-2">
                        <span>${produto.quantidade}x ${produto.produtos.nome}</span>
                        <span>${formatarMoeda(produto.valorTotal)}</span>
                    </div>
                    `;
                });

                htmlDireita = `
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header">
                            <h5 class="mb-0">Resumo do Pedido</h5>
                        </div>
                        <div class="card-body">
                        ${itens}

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            Confirmar Pedido
                        </button>
                        </div>
                    </div>
                `;
            }

            document.getElementById('cardEsquerda').innerHTML = html;
            document.getElementById('cardDireita').innerHTML = htmlDireita;


        })
        .catch(error => {
            console.log('Erro: ', error);
        })
}