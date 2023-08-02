<?php
require 'vendor/autoload.php';
$conexao_dominio = '';
$conexao_usuario = '';
$conexao_senha = '';
$conexao_database = '';

$conn = mysqli_connect($conexao_dominio, $conexao_usuario, $conexao_senha);
mysqli_select_db($conn, $conexao_database);

$twilioAccountSid = '';
$twilioAuthToken = '';
$twilioPhoneNumber = '';

$twilio = new Twilio\Rest\Client($twilioAccountSid, $twilioAuthToken);

$phone = $_POST['phone'];
$product = $_POST['product'];

$soNumeros = preg_replace("/\D/", "", $phone);
$ddd = substr($soNumeros, 0, 2);

$platform = "Desconhecido";
if (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "iPad") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "Macintosh") !== false) {
   $platform = "IOS";
} elseif (strpos($_SERVER['HTTP_USER_AGENT'], "Android") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "webOS") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "Symbian") !== false) {
   $platform = "ANDROID";
} else {
   $platform = "PC";
}

$formattedPhone = '+55' . $soNumeros;


$smsMessage = 'Novo cliente: '.$product.' https://wa.me/' . $formattedPhone;


if ($product === 'pecas') {
   $query = "SELECT * FROM vendedores WHERE ddds LIKE '%$ddd%' AND setor = 2 ORDER BY quant_cliques ASC LIMIT 1";
} else {
   $query = "SELECT * FROM vendedores WHERE ddds LIKE '%$ddd%' AND setor = 1 ORDER BY quant_cliques ASC LIMIT 1";
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
   $vendedor = mysqli_fetch_assoc($result);

   $whatsappNumber = $vendedor['celular'];
   if ($product === 'pecas') {
      $message = urlencode('Olá ' . $vendedor['nome_vendedor'] . ', estou entrando em contato com você através do link disponibilizado na Central de Vendas.');
   } else if (!$product) {
      $message = urlencode('Olá ' . $vendedor['nome_vendedor'] . ', estou entrando em contato com você através do link disponibilizado na Central de Vendas.');
   } else {
      $message = urlencode('Olá ' . $vendedor['nome_vendedor'] . ', estou entrando em contato com você para saber mais sobre a ' . $product . '.');
   }

   $sms = $twilio->messages->create(
      $whatsappNumber,
      array(
         'from' => $twilioPhoneNumber,
         'body' => $smsMessage
      )
   );

   $smsAndre = $twilio->messages->create(
      '+5565999106432',
      array(
         'from' => $twilioPhoneNumber,
         'body' => 'Novo cliente para '.$vendedor['nome_vendedor'].' ' .$product.' ' . 'https://wa.me/' . $formattedPhone
      )
   );

   if ($platform === 'IOS') {
      $whatsappLink = 'whatsapp://send?phone=' . $whatsappNumber . '&text=' . $message;
   } else {
      $whatsappLink = 'https://wa.me/' . $whatsappNumber . '?text=' . $message;
   }

   header("Location: $whatsappLink");

   $vendedorId = $vendedor['id'];
   $updateQuery = "UPDATE vendedores SET quant_cliques = quant_cliques + 1 WHERE id = '$vendedorId'";
   mysqli_query($conn, $updateQuery);

   $nome_vendedor = $vendedor['nome_vendedor'];
   $estado = $vendedor['estado'];
   $setor = $vendedor['setor'];

   $ip_usuario = $_SERVER['REMOTE_ADDR'];

   date_default_timezone_set('America/Sao_Paulo');
   $data_criacao = date("d/m/Y H:i:s", time());

   $sql_relatorio = mysqli_query($conn, "INSERT INTO relatorios (plataforma, nome_vendedor, ip_usuario, data_criacao, estado, setor, celular_cliente, produto) VALUES ('$platform', '$nome_vendedor', '$ip_usuario',  '$data_criacao', '$estado', '$setor', '$phone', '$product');");

   exit();
} else if ($product === 'pecas') {
   $query = "SELECT * FROM vendedores WHERE setor = 2 AND celular = '+5511917051777'";
   $result = mysqli_query($conn, $query);

   if (mysqli_num_rows($result) > 0) {
      $vendedor = mysqli_fetch_assoc($result);

      $whatsappNumber = $vendedor['celular'];
      if ($product === 'pecas') {
         $message = urlencode('Olá ' . $vendedor['nome_vendedor'] . ', estou entrando em contato com você através do link disponibilizado na Central de Vendas.');
      }

      $sms = $twilio->messages->create(
         $whatsappNumber,
         array(
            'from' => $twilioPhoneNumber,
            'body' => $smsMessage
         )
      );

      $smsAndre = $twilio->messages->create(
         '+5565999106432',
         array(
            'from' => $twilioPhoneNumber,
            'body' => 'Novo cliente para '.$vendedor['nome_vendedor'].' ' .$product.' ' . 'https://wa.me/' . $formattedPhone
         )
      );

      if ($platform === 'IOS') {
         $whatsappLink = 'whatsapp://send?phone=' . $whatsappNumber . '&text=' . $message;
      } else {
         $whatsappLink = 'https://wa.me/' . $whatsappNumber . '?text=' . $message;
      }

      header("Location: $whatsappLink");

      $vendedorId = $vendedor['id'];
      $updateQuery = "UPDATE vendedores SET quant_cliques = quant_cliques + 1 WHERE id = '$vendedorId'";
      mysqli_query($conn, $updateQuery);

      $nome_vendedor = $vendedor['nome_vendedor'];
      $estado = $vendedor['estado'];
      $setor = $vendedor['setor'];

      $ip_usuario = $_SERVER['REMOTE_ADDR'];

      date_default_timezone_set('America/Sao_Paulo');
      $data_criacao = date("d/m/Y H:i:s", time());

      $sql_relatorio = mysqli_query($conn, "INSERT INTO relatorios (plataforma, nome_vendedor, ip_usuario, data_criacao, estado, setor, celular_cliente, produto) VALUES ('$platform', '$nome_vendedor', '$ip_usuario',  '$data_criacao', '$estado', '$setor', '$phone', '$product');");

      exit();
   }
} else if ($product !== 'pecas') {
   $query = "SELECT * FROM vendedores WHERE setor = 1 AND celular = '+5519983488042'";
   $result = mysqli_query($conn, $query);
   
   if (mysqli_num_rows($result) > 0) {
      $vendedor = mysqli_fetch_assoc($result);
   
      $whatsappNumber = $vendedor['celular'];
      if (!$product) {
         $message = urlencode('Olá ' . $vendedor['nome_vendedor'] . ', estou entrando em contato com você através do link disponibilizado na Central de Vendas.');
      } else {
         $message = urlencode('Olá ' . $vendedor['nome_vendedor'] . ', estou entrando em contato com você para saber mais sobre a ' . $product . '.');
      }
   
      $sms = $twilio->messages->create(
         $whatsappNumber,
         array(
            'from' => $twilioPhoneNumber,
            'body' => $smsMessage
         )
      );

      $smsAndre = $twilio->messages->create(
         '+5565999106432',
         array(
            'from' => $twilioPhoneNumber,
            'body' => 'Novo cliente para '.$vendedor['nome_vendedor'].' ' .$product.' ' . 'https://wa.me/' . $formattedPhone
         )
      );
   
      if ($platform === 'IOS') {
         $whatsappLink = 'whatsapp://send?phone=' . $whatsappNumber . '&text=' . $message;
      } else {
         $whatsappLink = 'https://wa.me/' . $whatsappNumber . '?text=' . $message;
      }
   
      header("Location: $whatsappLink");
   
      $vendedorId = $vendedor['id'];
      $updateQuery = "UPDATE vendedores SET quant_cliques = quant_cliques + 1 WHERE id = '$vendedorId'";
      mysqli_query($conn, $updateQuery);
   
      $nome_vendedor = $vendedor['nome_vendedor'];
      $estado = $vendedor['estado'];
      $setor = $vendedor['setor'];
   
      $ip_usuario = $_SERVER['REMOTE_ADDR'];
   
      date_default_timezone_set('America/Sao_Paulo');
      $data_criacao = date("d/m/Y H:i:s", time());
   
      $sql_relatorio = mysqli_query($conn, "INSERT INTO relatorios (plataforma, nome_vendedor, ip_usuario, data_criacao, estado, setor, celular_cliente, produto) VALUES ('$platform', '$nome_vendedor', '$ip_usuario',  '$data_criacao', '$estado', '$setor', '$phone', '$product');");
   
      exit();
   } 
}

mysqli_close($conn);
?>
