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

			<a href="/trabalhoWEB">
				<h3><i class="fa fa-mobile" aria-hidden="true"></i>EletronicBuy</h3>
			</a>
			<div class="buttonsMenu">

				<a href="promocoes.php"><button class="buttonMP">Promoções</button></a>
				<a href="listarProduto.php"><button class="buttonMP">Todos os produtos</button></a>
				<a href="add.html"><button class="buttonMP">Cadastro de produtos</button></a>
				<a href="manipularProduto.php"><button class="buttonMP">Gerenciar produtos</button></a>

			</div>

		</div>
	</div>
	<div class="content">
		<img src="./images/background.jpg" />

		<div class="conteudo">
			<a href="add.html"><button class="addProduto"><i class="fas fa-plus"></i>

					Cadastrar Produto</button></a>

			<form method="POST">
				<input class="pesquisar" type="text" name="pesquisar">
				<select name="situacao1" id="">
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
						<td>foto</td>
						<td>Nome do produto</td>
						<td>Descricao</td>
						<td>Preço</td>
						<td>Porcentagem de desconto</td>
						<td>Estoque</td>
						<td>Situacao</td>

					</tr>
					<?php

					foreach ($resultado as $res) {
						$strm = $pdo->prepare("SELECT * FROM arquivos WHERE id = ?");
						$strm->execute([$res['arquivoId']]);
						$fotos = $strm->fetch(PDO::FETCH_ASSOC);
						echo "<tr>";
						echo "<td class=imagemToda>" . "<img class=imglist2 src=\"./upload/$fotos[arquivo]\" alt=foto style=\"width:50px; height:auto\">" . "</td>";
						echo "<td>" . $res['titulo'] . "</td>";
						echo "<td>" . $res['descricao'] . "</td>";
						echo "<td>RS:" . $res['preco'] * (1 - $res['porc_desconto'] / 100) . "</td>";
						echo "<td>" . $res['porc_desconto'] . "%</td>";
						echo "<td>" . $res['estoque'] . "</td>";
						echo "<td>" . $res['situacao'] . "</td>";
						echo "<td> <a class=noDecoration href=\"edit.php?id=$res[id]\"><button class=editDelete> Editar </button> </a><a class=noDecoration href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Você tem certeza que deseja excluir esse produto?')\"><button class=editDelete>Excluir</button> </a></td>";
					}
					?>
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