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
        })
        .catch(error => {
            console.log('Erro: ', error);
        })
}

