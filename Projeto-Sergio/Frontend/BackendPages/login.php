<?php
session_start();
include_once("../../rotas.php"); // Inclui o arquivo de rotas
include_once($connRoute); // Inclui o arquivo de conexao

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Doc Hudson</title>

    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/5998/5998796.png">


    <link rel="stylesheet" href="./cssBack/login.css">
</head>



<body>
    <div class="container box-conteudo">

        <div class="imagem-logo">
            <a href=""><img src="img/logo.png" alt="./"></a>
        </div>

        <form action="<?php echo $procLoginRoute; ?>" method="post">

            <h1>Sing In</h1>

            <?php 

                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

            ?>

            <div class="login">
            
                <label for="login">Login </label>
                <br>
                <input type="text" name="login">
                
            </div>

            <div class="senha">

                <label for="senha">Senha </label>
                <br>
                <input type="password" name="senha" > 

            </div>


            <input type="submit" value="Entrar">
            <a class="voltar" href=<?php echo $homeRoute; ?>>Voltar</a>
            
            
        </form>

    </div>

</body>

</html>
