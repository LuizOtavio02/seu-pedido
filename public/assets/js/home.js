document.addEventListener('DOMContentLoaded', function () {
    logado();
    pedidos();
});


function logado() {
    fetch('/api/sessao', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            let html = '';
            html += `${data.sessao.nome}`;
            document.getElementById('nome').innerHTML = html
        })
        .catch(error => {
            console.log('Erro: ', error);
        })
}

function pedidos() {
    fetch('/api/pedido', {
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
                data.pedidos.forEach(pedido => {
                    html += ` <div class="col">
                            <div class="card shadow-sm h-100">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">Pedido #${pedido.id}</h5>

                                    <span class="badge bg-warning text-dark">
                                        ${pedido.entrega.status}
                                    </span>
                                </div>

                                <p class="mb-2">
                                    <strong>Cliente:</strong> ${pedido.cliente.nome}
                                </p>

                                <p class="mb-2">
                                    <strong>Telefone:</strong> ${pedido.cliente.telefone}
                                </p>

                                <p class="mb-2">
                                    <strong>Data:</strong> ${pedido.data}
                                </p>

                                <p class="mb-0">
                                    <strong>Vendedor:</strong> ${pedido.funcionario.nome}
                                </p>

                            </div>

                            <div class="card-footer bg-white d-flex gap-2">
                                <button class="btn btn-success flex-fill">
                                    Pagar
                                </button>
                            </div>
                        </div>
                        </div>`;
                });

                document.getElementById('listar-pedidos').innerHTML = html;
            }
        })
        .catch(error => {
            console.log('Erro: ', error);
        })
}

