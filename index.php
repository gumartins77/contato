<?php

$product = $_GET['produto'];

function getProductImage($product) {
   $productImages = array(
	  'empilhadeira' => 'empilhadeira',
      'escavadeira' => 'escavadeira',
	  'mini' => 'mini',
      'motoniveladora' => 'motoniveladora',
	  'pa-carregadeira' => 'pa-carregadeira',
	  'pecas' => 'pecas',
      'plataforma' => 'plataforma',
	  'retroescavadeira' => 'retroescavadeira',
	  'rolo' => 'rolo',
   );

   if (array_key_exists($product, $productImages)) {
      return $productImages[$product];
   } else {
      return 'extra_maquinas_padrao';
   }
}

$productImage = getProductImage($product);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
	<meta charset="utf-8">

	<meta name="theme-color" content="#red" />
	<title>Extra Máquinas XCMG, São Paulo</title>
	<meta name="keywords"
		content="extra maquinas, xcmg, escavadeira, carregadeira, guindaste, rolo compactador, mini escavadeira, maquinas pesadas" />
	<meta name="description" content="Extra Máquinas São Paulo, seu revendedor autorizado XCMG." />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel='stylesheet' href='https://fonts.gstatic.com'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Work+Sans:wght@500&amp;display=swap'>
	<link rel="stylesheet" href="style.css?43">
	<link rel="stylesheet" href="lineicons.css?43">

	<meta property="og:image" content="img/logo_extra_maquinas.png">
	<link rel="icon" href="img/favicon.ico" />
</head>

<body>
	<div class="topo-minisite" style="text-align: center;">
		<!-- <img class="lazy-loaded" src="img/logo_<?php echo $productImage; ?>.jpg" data-lazy-type="image" style="max-width: 350px;" title="Extra Máquinas XCMG"> -->
		<img class="lazy-loaded" src="img/logo_extra_maquinas.png" data-lazy-type="image" style="max-width: 200px;" title="Extra Máquinas XCMG">
		<span
			style="color: #004997;
			font-weight: 400;
			font-family: 'Work Sans', sans-serif;
			text-align: center;
			position: absolute;
			left: 0%;
    		top: 140px;
			font-size: 19px">
			DIGITE SEU NÚMERO PARA CONTATO
		</span>
	</div>
	<!-- partial:index.partial.html -->
	<main>
   <div class="container">
      <form action="acao.php" method="post" onsubmit="return validateForm();">
         <div class="form-group">
            <input class="form-input" type="text" name="phone" id="phone" placeholder="(00) 0 0000-0000" inputmode="numeric" maxlength="16" onkeyup="handlePhone(event)" required>
            <input hidden type="text" name="product" id="product" value="<?php echo $_GET['produto']; ?>">
         </div>
         <div class="form-group">
            <button class="form-button" type="submit" id="submitButton"><i class="lni lni-whatsapp"></i> Iniciar Atendimento</button>
         </div>
      </form>
   </div>
</main>
	<!-- partial -->

	<div class="notification" id="notification"></div>

	<script>
		const handlePhone = (event) => {
			let input = event.target;
			input.value = phoneMask(input.value);
		}

		const phoneMask = (value) => {
			if (!value) return "";
			value = value.replace(/\D/g, "");
			value = value.replace(/(\d{2})(\d)/, "($1) $2");
			value = value.replace(/(\d{1})(\d{4})(\d{4})$/, "$1 $2-$3");
			return value;
		}

		function showNotification(message) {
			const notification = document.getElementById("notification");
			notification.innerText = message;
			notification.classList.add("show");
			setTimeout(() => {
				notification.classList.remove("show");
			}, 5000);
		}

		function validateForm() {
			const phoneInput = document.getElementById("phone");
			const phoneNumber = phoneInput.value.replace(/\D/g, "");
			if (phoneNumber.length !== 11) {
				showNotification("Por favor, digite um número de telefone válido.\n(99) 9 9999-9999");
				return false;
			}

			const submitButton = document.getElementById("submitButton");
			submitButton.disabled = true;
			submitButton.innerText = "Enviando...";
			return true;
   		}	
	</script>

	<div class="link-vrum">
		<a class="go-vrum" href="https://www.instagram.com/extramaquinas/" target="_blank">@extramaquinas</a>
		<a class="go-vrum" href="https://extramaquinas.com/termo/" target="_blank">| Termo de Uso</a>
	</div>

	<!-- COMMON SCRIPTS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<? if ($_SERVER['REMOTE_ADDR'] == '201.23.104.254') {} else { ?>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-G1RD14Q13L"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());

		gtag('config', 'G-G1RD14Q13L');
	</script>
	<? } ?>

</body>

</html>
