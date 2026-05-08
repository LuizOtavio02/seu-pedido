document.getElementById('form-busca').addEventListener('submit', function (e) {
    e.preventDefault();

    const termo = document.querySelector('input[name="b"]').value;
    const messageDiv = document.getElementById('message');

    if (termo == "") {
        messageDiv.textContent = "Preencha o campo";
        return;
    }

    fetch(`/api/equipe?b=${termo}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            let html = '';

            if (data.success) {
                html += `<div class="card shadow-sm mb-3">

                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-8">

                                            <h5 class="mb-1">
                                                ${data.data.nome}
                                            </h5>

                                            <p class="mb-1 text-muted">
                                                Id: ${data.data.id}
                                            </p>

                                            <p class="mb-1 text-muted">
                                                Username: ${data.data.username}
                                            </p>

                                            <span class="badge bg-dark">
                                                ${data.data.tipo}
                                            </span>

                                        </div>

                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                            <button class="btn btn-outline-dark">
                                                Editar
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>`;
                document.getElementById('resultadoBusca').innerHTML = html;
                return;
            }

            html += `<div class="card shadow-sm mb-3">

                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-8">

                                            <h5 class="mb-1">
                                                Funcionário Não Encontrado
                                            </h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>`;
            document.getElementById('resultadoBusca').innerHTML = html;
        })
        .catch(error => [
            console.log('Erro: ', error)
        ])

})