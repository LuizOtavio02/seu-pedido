document.addEventListener('DOMContentLoaded', function () {
  produtos();
  addCarrinho();
});

function produtos() {
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
              <div>
                  <h6 class="mb-1 fw-semibold">${produto.nome}</h6>
                  <span class="mb-0 fw-bold fs-5">
                      R$ ${formatarMoeda(produto.preco)}
                  </span>
              </div>
              <br>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="#" data-id="${produto.id}" class="btn btn btn-primary btn-add-carrinho">
                    carrinho
                  </a>
                </div>
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
}


function addCarrinho() {
  document.addEventListener('click', function (e) {

    if (e.target.classList.contains('btn-add-carrinho')) {
      e.preventDefault();

      const produtoId = e.target.getAttribute('data-id');

      fetch('/api/carrinho', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          'id': produtoId
        })
      })
        .then(response => response.json())
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          console.log('Erro: ', error);
        })
    }
  })


}