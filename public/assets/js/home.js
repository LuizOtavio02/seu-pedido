window.addEventListener('DOMContentLoaded', event => {
    const menuToggle = document.body.querySelector('#menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.querySelector('#wrapper').classList.toggle('toggled');
        });
    }
});

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