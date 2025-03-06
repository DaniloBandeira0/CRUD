<?php
    include "./usuario-header.php";
?>
<main>
<?php
    session_start();
    if (isset($_SESSION['nome'])) {
        $nome = $_SESSION['nome'];
        echo "<br>
        <div class='alert text-center' role='alert'>
            <h2 class='display-4 text-capitalize'>Olá, " . ($nome) . "!</h2>
            <p class='lead'>Bem-vindo(a) de volta ao nosso sistema.</p>
        </div>";
    } else {
        // Se a sessão não estiver iniciada ou não estiver logado, redireciona
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['status'])) {
        $status = $_GET['status'];

        if ($status == 'success') {
            // Mensagem de agendamento com sucesso
            echo "<div id='successMessage' class='alert alert-success text-center' role='alert'>
                    <h4 class='alert-heading'>Agendamento realizado com sucesso!</h4>
                    <p>Seu agendamento foi confirmado.</p>
                </div>";

            // Script para esconder a mensagem após 3 segundos
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 3000); // 3000 milissegundos = 3 segundos
                </script>";

            // Notificação no navegador
            echo "<script>
                    if (Notification.permission === 'granted') {
                        new Notification('Agendamento Confirmado', {
                            body: 'Olá, " . $nome . "! Seu agendamento foi confirmado.',
                            icon: 'icon.png' // Substitua com um ícone, se desejar
                        });
                    } else if (Notification.permission !== 'denied') {
                        Notification.requestPermission().then(function(permission) {
                            if (permission === 'granted') {
                                new Notification('Agendamento Confirmado', {
                                    body: 'Olá, " . $nome . "! Seu agendamento foi confirmado.',
                                    icon: 'icon.png' // Substitua com um ícone, se desejar
                                });
                            }
                        });
                    }
                </script>";
        } elseif ($status == 'error') {
            // Se o agendamento falhar (por exemplo, horário já agendado)
            $message = $_GET['message'];
            echo "<div class='alert alert-danger text-center' role='alert'>
                    <h4 class='alert-heading'>Erro ao agendar!</h4>
                    <p>{$message}</p>
                </div>";

            // Notificação de erro no navegador
            echo "<script>
                    if (Notification.permission === 'granted') {
                        new Notification('Erro no Agendamento', {
                            body: 'Olá, " . $nome . "! Ocorreu um erro ao realizar o agendamento: " . $message . ".',
                            icon: 'icon.png' // Substitua com um ícone, se desejar
                        });
                    } else if (Notification.permission !== 'denied') {
                        Notification.requestPermission().then(function(permission) {
                            if (permission === 'granted') {
                                new Notification('Erro no Agendamento', {
                                    body: 'Olá, " . $nome . "! Ocorreu um erro ao realizar o agendamento: " . $message . ".',
                                    icon: 'icon.png' // Substitua com um ícone, se desejar
                                });
                            }
                        });
                    }
                </script>";
        }
    }
?>

</main>
<?php
    include "./footer.php";
?>
