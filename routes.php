<?php

require_once 'Carne.php';
require_once 'helpers.php';


function handleRoutes($method, $uriSegments) {

    if (count($uriSegments) < 3) {
        header("HTTP/1.1 404 Not Found");
        echo "Rota não encontrada! ";
        return;
    }

    $apiSegment = $uriSegments[0];
    $resourceSegment = $uriSegments[2];

    if ($apiSegment !== 'carnes-api') {
        header("HTTP/1.1 404 Not Found");
        echo "Rota não encontrada!";
        return;
    }

    if ($method == 'POST' && $resourceSegment == 'carne') {
        createCarne();
    } elseif ($method == 'GET' && isset($uriSegments[4]) && $uriSegments[4] == 'parcelas') {
        if (isset($uriSegments[3])) {
            getParcelas($uriSegments[3]);
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo "ID da carne não fornecido!";
        }
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "Rota não encontrada!";
    }
}

function createCarne() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!validateCreateCarneInput($data)) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(['error' => 'Parâmetros inválidos.']);
        return;
    }

    $carne = new Carne(
        $data['valor_total'],
        $data['qtd_parcelas'],
        $data['data_primeiro_vencimento'],
        $data['periodicidade'],
        isset($data['valor_entrada']) ? $data['valor_entrada'] : 0
    );

    $parcelas = $carne->gerarParcelas();

    $response = [
        'total' => $data['valor_total'],
        'valor_entrada' => isset($data['valor_entrada']) ? $data['valor_entrada'] : 0,
        'parcelas' => $parcelas
    ];

    $filePath = __DIR__ . '/tests/carne.postman_collection.json';

    if (file_exists($filePath)) {
        $jsonContent = file_get_contents($filePath);
        $carnes = json_decode($jsonContent, true);
    } else {
        $carnes = [];
    }

    if ($carnes !== null) {
      $id = count($carnes) + 1;
    } else {
        $id = 1;
    }

    $carnes[$id] = $response;

    file_put_contents($filePath, json_encode($carnes, JSON_PRETTY_PRINT));

    $responseWithId = array_merge(['id' => $id], $response);
    header("Content-Type: application/json");
    echo json_encode($responseWithId);
}

function getParcelas($id) {
    $filePath = __DIR__ . '/tests/carne.postman_collection.json';

    if (!file_exists($filePath)) {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'Nenhum carnê encontrado.']);
        return;
    }

    $jsonContent = file_get_contents($filePath);
    $carnes = json_decode($jsonContent, true);

    if (!isset($carnes[$id])) {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'Carnê não encontrado.']);
        return;
    }

    header("Content-Type: application/json");
    echo json_encode($carnes[$id]['parcelas']);
}