function logado() {
    fetch('/api/sessao', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        } 
    })
    .then((response => response.json()))
    .then(data => {
        let html = '';
        html += `${data.sessao.nome}`;
        document.getElementById('nome').innerHTML = html
    })
}

logado();