window.addEventListener('DOMContentLoaded', event => {
document.getElementById('cliente-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const nome = document.getElementById('nome-cliente').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    const estado = document.getElementById('estado').value.trim();
    const cidade = document.getElementById('cidade').value.trim();
    const bairro = document.getElementById('bairro').value.trim();
    const rua = document.getElementById('rua').value.trim();
    const numero = document.getElementById('numero').value.trim();
    const messageDiv = document.getElementById('message')

    if (!nome || !telefone || !estado || !cidade || !bairro || !rua || !numero) {
        messageDiv.textContent = "Preencha Todos os campos.";
        messageDiv.className = "error";
        return;
    }

    fetch('/api/cliente', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'nome': nome,
            'telefone': telefone,
            'estado': estado,
            'cidade': cidade,
            'bairro': bairro,
            'rua': rua,
            'numero': numero
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(data);
        }
    })
    .catch(error => {
        console.log('Erro: ', error);
    })



})
})