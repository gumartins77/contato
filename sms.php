<?php
$conexao_dominio = 'localhost';
$conexao_usuario = 'extramaquinas';
$conexao_senha = '3XTR4@0001#MAQUINAS';
$conexao_database = 'extramaquinas_minisite';

$conn = mysqli_connect($conexao_dominio, $conexao_usuario, $conexao_senha);
mysqli_select_db($conn, $conexao_database);

if (isset($_GET['celular_cliente'])) {
    $celular_cliente_get = $_GET['celular_cliente'];

    // Remover qualquer caractere que não seja número
    $celular_cliente_apenas_numeros = preg_replace('/[^0-9]/', '', $celular_cliente_get);

    // Verificar se o número começa com o prefixo "55" e removê-lo, se necessário
    if (substr($celular_cliente_apenas_numeros, 0, 2) === '55') {
        $celular_cliente_apenas_numeros = substr($celular_cliente_apenas_numeros, 2);
    }

    // Formatar o número do cliente para (00) 9 9999-61147
    $celular_cliente_formatado = '(' . substr($celular_cliente_apenas_numeros, 0, 2) . ') 9 ' . substr($celular_cliente_apenas_numeros, 2, 4) . '-' . substr($celular_cliente_apenas_numeros, 6);

    $horarioAcesso = date("Y-m-d H:i:s");

    $query = "SELECT * FROM relatorios WHERE celular_cliente = '$celular_cliente_formatado' ORDER BY data_criacao ASC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $relatorio = mysqli_fetch_assoc($result);

    }

     $whatsappLink = "https://wa.me/$celular_cliente_get";
    
     header("Location: $whatsappLink");
     exit();
} else {
    echo "Número do cliente não fornecido.";
}
?>
