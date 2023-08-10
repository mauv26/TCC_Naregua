<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página de Login - NaRegra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-page">
    <div class="form">
        <form class="register-form" method="POST" action="">
            <input type="text" name="nome" placeholder="Nome"/>
            <input type="text" name="cpf" placeholder="CPF"/>
            <input type="text" name="cidade" placeholder="Cidade"/>
            <input type="text" name="cep" placeholder="CEP"/>
            <input type="text" name="email" placeholder="E-mail"/>
            <input type="password" name="senha" placeholder="Senha"/>
            <select name="tipo" class="form-select" id="">
                   <option value="#" disabled selected>Selecione</option>
                   <option value="0">Cliente</option>
                   <option value="1">Barbeiro</option>
                </select>
            <button name="register">Criar</button>
            <p class="message">Já está cadastrado? <a href="#">Efetue o login</a></p>
        </form>
        <form class="login-form" method="POST" action="">
            <input type="text" name="email" placeholder="E-mail"/>
            <input type="password" name="senha" placeholder="Senha"/>
            <button name="login">Login</button>
            <p class="message">Não possuí registro? <a href="#">Crie sua conta</a></p>
        </form>
    </div>
</div>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="./script.js"></script>
</body>
<?php
// Verificar se o formulário de cadastro foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $nome   = $_POST["nome"];
    $cpf    = $_POST["cpf"];
    $cidade = $_POST["cidade"];
    $cep    = $_POST["cep"];
    $email  = $_POST["email"];
    $senha  = $_POST["senha"];
    $tipo   = $_POST["tipo"];


    // Conexão de banco
    $conexao = new mysqli("10.67.22.216", "us_des_222_barbearia", "of2723", "bd_tcc_des_222_barbearia");
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verifica se todos os campos foram preenchidos
        if (empty($nome) || empty($cpf) || empty($cidade) || empty($cep) || empty($email) || empty($senha)) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Preencha todos os campos obrigatórios.'
                });
              </script>";
        } else {
            $sql = "INSERT INTO pessoas (pess_nome, pess_cpf, pess_cidade, pess_cep, pess_email, pess_senha, pess_cliente) 
            VALUES ('$nome', '$cpf','$cidade','$cep','$email', '$senhaHash','$tipo')";
        }

    if ($conexao->query($sql) === TRUE) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Cadastro realizado com sucesso!'
        });
      </script>";
    }
    // } else {
    //     echo "<script>
    //     Swal.fire({
    //         icon: 'warning',
    //         title: 'Erro!',
    //         text: 'Erro no cadastro: " . $conexao->error . "'
    //     });
    //   </script>";
    // }

    $conexao->close();
}

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Exemplo de verificação no MySQL usando mysqli
    $conexao = new mysqli("10.67.22.216", "us_des_222_barbearia", "of2723", "bd_tcc_des_222_barbearia");
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $sql = "SELECT id, nome, senha FROM pessoas WHERE email = '$email'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        if (password_verify($senha, $row["senha"])) {
            echo "Login realizado com sucesso!";
            // Aqui você pode iniciar uma sessão ou redirecionar para a página de perfil, por exemplo
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "E-mail não encontrado.";
    }

    $conexao->close();
}
?>
</html>
