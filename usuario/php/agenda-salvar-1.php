<?php
    include "../../includes/conexao.php";
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }

    // Obtendo os dados do agendamento
    $clienteId = $_SESSION['id'];
    $profissionalId = $_POST["profissionalId"]; // ID do profissional escolhido
    $servicoId = $_POST["servico"];
    $data = $_POST["data"];
    $horarioId = $_POST["horario"];

    // Verifica se o horário já está reservado
    $sql_check = "SELECT * FROM agenda_1 WHERE data = '$data' AND horarioId = '$horarioId'";
    $res_check = mysqli_query($conexao, $sql_check);
    if (mysqli_num_rows($res_check) > 0) {
        // Caso o horário já esteja reservado
        header("Location: ./agendamento.php?status=error&message=Horário já reservado.");
        exit();
    }

    // Insere o agendamento no banco de dados
    $sql = "INSERT INTO agenda_1 (clienteId, profissionalId, servicoId, data, horarioId) 
            VALUES ($clienteId, '$profissionalId', $servicoId, '$data', '$horarioId')";
    if (mysqli_query($conexao, $sql)) {
        // Redireciona para a página de sucesso
        header("Location: ./usuario-home.php?status=success");
    } else {
        // Redireciona para a página de erro
        header("Location: ./agendamento.php?status=error&message=Erro ao agendar.");
    }

    mysqli_close($conexao);
    exit();
?>
