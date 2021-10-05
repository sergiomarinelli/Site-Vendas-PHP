<?php
//including the database connection file
include_once("config.php");
$pdo = pdo_connect_mysql();

$resultado = $pdo->prepare("SELECT * FROM produtos ORDER BY id DESC");
$resultado->execute();


if (isset($_POST['situacao1'])) {
	$pesquisa = $_POST['situacao1'];
}

if (isset($_POST['pesquisar'])) {
	$pesquisar = $_POST['pesquisar'];
	$result_produtos = $pdo->prepare("SELECT * FROM produtos WHERE (situacao LIKE '%$pesquisa%') AND (titulo LIKE '%$pesquisar%')");
	$result_produtos->execute();
	$resultado = $result_produtos;
}

?>


<html>

<head>
	<meta charset="utf-8">
	<link href="./styles/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<title>EletronicBuy</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=MonteCarlo&display=swap" rel="stylesheet">
</head>

<body>
<div class="contentMenu">
		<div class="menu">

			<a href="/trabalhoWEB"><h3><i class="fa fa-mobile" aria-hidden="true"></i>EletronicBuy</h3></a>
			<div class="buttonsMenu">
				
				<a href="promocoes.php"><button class="buttonMP">Promoções</button></a>
				<a href="listarProduto.php"><button class="buttonMP">Todos os produtos</button></a>
				<a href="add.html"><button class="buttonMP">Cadastro de produtos</button></a>
				<a href="manipularProduto.php"><button class="buttonMP">Gerenciar produtos</button></a>

			</div>

		</div>
	</div>
	<div class="content">
		<img class="img3" src="./images/background.jpg" />

		<div class="conteudo3">
			<form class="post" method="POST">
				<input class="pesquisar" type="text" name="pesquisar">
				<select class="www" name="situacao1" id="">
					<option value="" name="">
						Todos
					</option>
					<option value="disponivel" name="disponivel">
						Disponível
					</option>
					<option value="indisponivel" name="indisponivel">
						Indisponivel
					</option>
					<option value="oferta" name="oferta">Oferta</option>
				</select>
				<input class="editDelete2" type="submit" value="Pesquisar"></input>

			</form>
			<div class="conteudoTabela">
				<table class="tabela">
					<tr bgcolor='#CCCCCC'>
						<div>
							<?php
							//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
							foreach ($resultado as $res) {
								$strm = $pdo->prepare("SELECT * FROM arquivos WHERE id = ?");
								$strm->execute([$res['arquivoId']]);
								$fotos = $strm->fetch(PDO::FETCH_ASSOC);

								echo "<tr>";
								echo "<td>";
								echo "<ul>";
								echo "<div class=Total>";
								echo "<div class=listImg>" . "<img class=imglist src=\"./upload/$fotos[arquivo]\" alt=foto>" . "</div>";
								echo "<div class=listTitulo><p>Nome:</p> " . $res['titulo'] . "</div>";
								echo "<div class=listdescricao><p>Descrição:</p> " . $res['descricao'] . "</div>";
								echo "<div class=listpreco><p>Preço:</p> RS:" . $res['preco'] . "</div>";
								echo "<div class=listdesconto><p>Desconto:</p> " . $res['porc_desconto'] . "%</div>";
								echo "<div class=listestoque><p>Estoque:</p> " . $res['estoque'] . "</div>";
								echo "<div class=listsituacao><p>Situação:</p> " . $res['situacao'] . "</div>";
								echo "</ul></div><td>";
							}
							?>
						</div>
					</tr>
				</table>
			</div>

		</div>

	</div>
	<footer class="footer"><i class="fab fa-instagram"><a href="instagram.com" class="redesSociais">Instagram</a></i>
		<i class="fab fa-twitter"><a href="instagram.com" class="redesSociais">Instagram</a></i>
		<i class="fab fa-facebook"><a href="instagram.com" class="redesSociais">Instagram</a></i>


	</footer>
</body>

</html>