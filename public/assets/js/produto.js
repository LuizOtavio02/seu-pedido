fetch('/api/produtos', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json'
    }
})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let html = '';

            data.produtos.forEach(produto => {
                html += `<div class="col">
          <div class="card shadow-sm">

            <svg
              aria-label="Placeholder: Thumbnail"
              class="bd-placeholder-img card-img-top"
              height="225"
              preserveAspectRatio="xMidYMid slice"
              role="img"
              width="100%"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="#55595c"></rect>
              <text x="50%" y="50%" fill="#eceeef" dy=".3em">
                Thumbnail
              </text>
            </svg>

            <div class="card-body">
              <p class="card-text">${produto.nome}</p>
              <p class="card-text">${produto.preco}</p>

              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="/dev/loja-virtual/public/categoria/${produto.produto_slug}" class="btn btn-primary">
                    Ver produto
                  </a>
                  <a href="#" data-id="${produto.id}" class="btn btn-sm btn-outline-secondary btn-add-carrinho">
                    carrinho
                  </a>
                </div>
                <small class="text-body-secondary">9 mins</small>
              </div>
            </div>

          </div>
        </div>`;
            });

            document.getElementById('listar-produtos').innerHTML = html;
        }
    })
    .catch(error => {
        console.log('Erro: ', error);
    })