<?php

namespace app\controllers\api;

use app\model\site\FuncionarioModel;

class ApiEquipeController
{
    private FuncionarioModel $funcionarioModel;

    public function __construct()
    {
        $this->funcionarioModel = new FuncionarioModel;
    }

    public function update(array $id): void
    {
        $funcionario = $id[0];

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não Atualizar o Funcionario'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $update = $this->funcionarioModel->update($funcionario,$input);

        if (!$update) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não Atualizar o Funcionario'
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Funcionario Atualizado com sucesso'
        ], JSON_PRETTY_PRINT);
    }

    public function busca(array $id): void
    {
        $busca = $id[0];

        $funcionario = $this->funcionarioModel->find('id', $busca);

        header('Content-Type: application/json');

        if ($funcionario) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $funcionario
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível achar o usuario',
            'a' => $busca
        ], JSON_PRETTY_PRINT);
    }

    public function autocomplete(array $nome): void
    {
        $busca = $nome[0];

        $resultado = $this->funcionarioModel->findLike('nome', $busca);

        header('Content-Type: application/json');

        if ($resultado) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $resultado
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível encontrar um resultado',
        ], JSON_PRETTY_PRINT);
    }
}
