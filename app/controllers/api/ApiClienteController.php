<?php

namespace app\controllers\api;

use app\helpers\classes\Filter;
use app\model\site\ClienteModel;
use app\model\site\EnderecoModel;

class ApiClienteController
{
    private Filter $filter;
    private ClienteModel $cliente;
    private EnderecoModel $endereco;

    public function __construct()
    {
        $this->filter = new Filter;
        $this->cliente = new ClienteModel;
        $this->endereco = new EnderecoModel;
    }

    public function create() : void
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        if (!$input || empty($input['nome']) || empty($input['telefone']) || empty($input['estado']) || empty($input['cidade']) || empty($input['bairro']) || empty($input['rua']) || empty($input['numero'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível realizar o cadastro Algum campo esta vazio'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $cliente = [
            'nome' => $input['nome'],
            'telefone' => $input['telefone']
        ];

        $clienteId = $this->cliente->create($cliente);

        $endereco = [
            'estado' => $input['estado'],
            'cidade' => $input['cidade'],
            'bairro' => $input['bairro'],
            'rua' => $input['rua'],
            'numero' => $input['numero'],
            'cliente_id' => $clienteId
        ];

        $clienteEndereco = $this->endereco->create($endereco);

        if ($clienteId && $clienteEndereco) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Criado com sucesso'
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível realizar o cadastro'
        ], JSON_PRETTY_PRINT);
    }

    public function busca() : void
    {
        $busca = trim($_GET['b']) ?? '';

        header('Content-Type: application/json');

        $cliente = $this->cliente->findLike('nome', $busca);
        $clienteEndereco = $this->endereco->find('cliente_id', $cliente['id']);

        if ($cliente) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $cliente,
                'endereco' => $clienteEndereco
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível achar o usuario'
        ], JSON_PRETTY_PRINT);
    }
}
