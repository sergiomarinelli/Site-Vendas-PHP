<?php
//including the database connection file
include("config.php");
$pdo = pdo_connect_mysql();

//getting id of the data from url
$id = $_GET['id'];
$arquivoId = $_GET['arquivoId'];
$arquivo = $_GET['arquivo'];

//deleting the row from table
$resultado = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$resultado->execute([$id]);
unlink("./upload/$arquivo");
$resultado = $pdo->prepare("DELETE FROM arquivos WHERE id = ?");
$resultado->execute([$arquivoId]);

//redirecting to the display page (index.php in our case)
header("Location:manipularProduto.php");
