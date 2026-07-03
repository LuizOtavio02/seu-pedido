window.addEventListener('DOMContentLoaded', event => {
    document.getElementById('formAdicionarProduto').addEventListener('submit', function (e) {
        e.preventDefault();

        const produto = document.getElementById('produto').value.trim();
        const estoque = document.getElementById('estoque').value.trim();
        const preco = document.getElementById('preco').value.trim();
        const slug = document.getElementById('slug').value.trim();
        const categoriaId = document.getElementById('categoriaId').value.trim();
        

        fetch('/api/produto', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'produto': produto,
                'preco': preco,
                'slug': slug,
                'estoque': estoque,
                'categoriaId': categoriaId
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.log('Erro: ', error);
            })

    })
})


