<?php

include __DIR__ . '/../config/database.php';

// TOTAL VEÍCULOS
$totalVeiculos = $conn->query("SELECT COUNT(*) as total FROM veiculos WHERE ativo = 1")
->fetch_assoc()['total'];

// EM CAMPO
$emCampo = $conn->query("SELECT COUNT(*) as total FROM veiculos WHERE status='campo'")
->fetch_assoc()['total'];

// MANUTENÇÃO VENCIDA
$manutencaoVencida = $conn->query("
    SELECT COUNT(*) as total FROM veiculos
    WHERE (horas_trabalhadas - ultima_manutencao) >= horas_manutencao
")->fetch_assoc()['total'];

// PRÓXIMA MANUTENÇÃO
$manutencaoProxima = $conn->query("
    SELECT COUNT(*) as total FROM veiculos
    WHERE (horas_manutencao - (horas_trabalhadas - ultima_manutencao)) <= 20
    AND (horas_trabalhadas - ultima_manutencao) < horas_manutencao
")->fetch_assoc()['total'];

// GRÁFICO
$dados = $conn->query("SELECT nome, horas_trabalhadas FROM veiculos LIMIT 10");

$nomes = [];
$horas = [];

while($row = $dados->fetch_assoc()){
    $nomes[] = $row['nome'];
    $horas[] = $row['horas_trabalhadas'];
}

// 📊 MANUTENÇÕES POR DIA
$dadosManutencao = $conn->query("
    SELECT DATE(data_manutencao) as data, COUNT(*) as total
    FROM manutencoes
    GROUP BY DATE(data_manutencao)
    ORDER BY data ASC
");

$datas = [];
$totais = [];

while($row = $dadosManutencao->fetch_assoc()){
    $datas[] = $row['data'];
    $totais[] = (int)$row['total'];
}

include 'views/dashboard.php';