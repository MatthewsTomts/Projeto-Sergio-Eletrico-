<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  session_start();
  include_once("../../rotas.php"); // Inclui o arquivo de rotas
  include_once($connRoute); // Inclui o arquivo de conexao
  
  // Verifica se o usuário está logado
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    // Caso o tipo do usuário fo Adm, mostrará o botão que leva a página de cadastro
    if ($_SESSION['tipo'] == 'Adm') {
      echo "<a href='$cadFunRoute'>CADASTRAR FUNCIONÁRIO <br></a>";
    }
    echo "<a href='$registroRoute'>NOVA ENTRADA</a><br>";
    echo "<a href='$listaRoute'>ENTRADAS</a><br><br>";

    echo "
    <form action='$historicoRoute' method='get'>
      <input type='text' placeholder='pesquise por placas' name='pesq'>
      <input type='submit' value='pesquisar'>
    </form>
    ";

    if (isset($_GET['pesq'])) {
      $pesq = $_GET['pesq'];
    } else {
      $pesq = "";
    }

    // Receber o número da página
    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    // Setar a quantidade de items por pagina
    $qnt_result_pg = 10;

    // Calcular o inicio visualização
    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

    // Faz uma query para retornar todos os registros que não foram fechados
    $resultado = mysqli_query($conn, "SELECT * FROM registros
    WHERE Horario_saida IS NOT NULL AND Placa like '%$pesq%'
    LIMIT $inicio, $qnt_result_pg");

    // Retorna todos os registros coletados na query, e adicionar no array rows
    $rows = $resultado->fetch_all();

    // Para cada index no array rows, cria um "card"
    foreach ($rows as $row) {
      echo "
          <div>
            <p>Nome: $row[2]</p>
            <p>Horário de entrada: $row[7]</p>
            <p>Placa: $row[4]</p>
            <p>Valor Pago: $row[8]</p>
            <!-- row[0] puxa o id -->
            <a href='$detalhesRoute?id=$row[0]'>Detalhes</a><br>
            <hr>
          </div>
          ";
    }
    echo "<br>";

    // Paginação - Somar a quantidade de usuários
    $resultado_pg = mysqli_query($conn, "SELECT COUNT(PK_Registro)
    AS num_result FROM registros WHERE Horario_saida IS NOT NULL");
    $row_pg = mysqli_fetch_assoc($resultado_pg);
    // echo $row_pg['num_result'];

    // Quantidade de pagina
    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

    // Limitar os link antes depois
    $max_links = 2;
    echo "<a href='$historicoRoute?pagina=1'>Primeira</a> ";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant >= 1) {
            echo "<a href='$historicoRoute?pagina=$pag_ant'>$pag_ant</a> ";
        }
    }

    echo $pagina;

    for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
        if ($pag_dep <= $quantidade_pg) {
            echo "<a href='$historicoRoute?pagina=$pag_dep'>$pag_dep</a> ";
        }
    }

    echo " <a href='$historicoRoute?pagina=$quantidade_pg'>Ultima</a>";

  } else {
    echo "Por favor, faça o login primeiro.";
    header("Location: " . $loginRoute);

  }?>

</body>

</html>
