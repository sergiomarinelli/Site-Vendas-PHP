<html>

<head>
</head>

<body>
	<?php
	//including the database connection file
	include_once("config.php");
	$pdo = pdo_connect_mysql();

	if (isset($_POST['Submit'])) {

		if (empty($_POST['titulo']) || empty($_POST['descricao']) || empty($_POST['porc_desconto']) || empty($_POST['preco']) || empty($_POST['estoque'] || empty($_POST['situacao']))) {

			if (empty($_POST['titulo'])) {
				echo "<font color='red'>O nome do produto está vazio</font><br/>";
			}

			if (empty($_POST['porc_desconto'])) {
				echo "<font color='red'>O desconto está vazio</font><br/>";
			}

			if (empty($_POST['descricao'])) {
				echo "<font color='red'>A descricao está vazia.</font><br/>";
			}

			if (empty($_POST['preco'])) {
				echo "<font color='red'>O preço está vazio.</font><br/>";
			}

			if (empty($_POST['estoque'])) {
				echo "<font color='red'>O estoque do produto está vazio.</font><br/>";
			}

			if (empty($_POST['situacao'])) {
				echo "<font color='red'>Você não selecionou uma situação.</font><br/>";
			}

			//link to the previous page
			echo "<br/><a href='javascript:self.history.back();'>clique aqui para voltar</a>";
		} else {
			// if all the fields are filled (not empty) 

			//insert data to database

			//upando arquivos
			$min = 0;
			$max = 50000;

			$fileName = rand($min, $max) . $_FILES['file']['name'];
			$stmt = $pdo->prepare('INSERT INTO arquivos (arquivo) VALUES (?)');
			$stmt->execute([$fileName]);
			move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $fileName);
			$arquivoId = $pdo->lastInsertId();

			$resultado = $pdo->prepare("INSERT INTO produtos (titulo, descricao, preco, porc_desconto, estoque, situacao, arquivoId) VALUES (?, ?, ?, ?, ?, ?, ?)");

			$resultado->execute([$_POST['titulo'], $_POST['descricao'], $_POST['preco'], $_POST['porc_desconto'], $_POST['estoque'], $_POST['situacao'], $arquivoId]);

			echo "<font color='green'>O produto foi adicionado com sucesso!.";
			echo "<br/><a href='manipularProduto.php'>Visualizar resultado</a>";
		}
	}
	?>
</body>

</html>