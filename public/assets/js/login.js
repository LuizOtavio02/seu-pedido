document.getElementById('form-login').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();
    const senha = document.getElementById('senha').value.trim();
    const message = document.getElementById('message')

    if (!username || !senha) {
        message.textContent = "Preencha todos os campos";
        message.className = "text-danger";
        return;
    }
    
    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'username': username,
            'senha': senha
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            window.location.href = "http://www.seupedido.test/";
        }
    })
    .catch(error => {
        console.log('Erro: ', error);
    })
})
