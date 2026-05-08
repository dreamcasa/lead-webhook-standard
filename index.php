<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

/**
 * ------------------------------------------------------------
 * Dreamcasa Webhook Test Sender
 * ------------------------------------------------------------
 *
 * Instalação:
 *
 * composer require vlucas/phpdotenv
 *
 * Exemplo de .env:
 *
 * WEBHOOK_URL=https://cliente.com.br/webhook
 *
 * Execução:
 *
 * php send-webhook.php
 *
 * ------------------------------------------------------------
 */

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$webhookUrl = $_ENV['WEBHOOK_URL'] ?? null;

if (!$webhookUrl) {
    die("WEBHOOK_URL não configurada no .env\n");
}

/**
 * Payload de exemplo
 */
$payload = [
    'leadOrigin' => 'Dreamcasa',
    'clientListingId' => '98765',
    'name' => 'Maria Oliveira',
    'email' => 'maria@email.com',
    'phoneNumber' => '+55 27 98888-7777',
    'message' => 'Gostaria de agendar uma visita.'
];

$jsonPayload = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

/**
 * Inicializa CURL
 */
$ch = curl_init($webhookUrl);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonPayload)
    ],
    CURLOPT_POSTFIELDS => $jsonPayload,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "Erro CURL: " . curl_error($ch) . PHP_EOL;
    curl_close($ch);
    exit(1);
}

curl_close($ch);

echo "----------------------------------------" . PHP_EOL;
echo "Webhook enviado com sucesso!" . PHP_EOL;
echo "URL: {$webhookUrl}" . PHP_EOL;
echo "HTTP CODE: {$httpCode}" . PHP_EOL;
echo "----------------------------------------" . PHP_EOL;
echo "Payload enviado:" . PHP_EOL;
echo $jsonPayload . PHP_EOL;
echo "----------------------------------------" . PHP_EOL;
echo "Resposta do servidor:" . PHP_EOL;
echo $response . PHP_EOL;
