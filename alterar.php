<!DOCTYPE html>
<html>
<head>
	<title>Form Atualizar</title>
</head>
<body>
<?php
	require_once("conexao.php");

	if(isset($_GET['id'])){

		$id = $_GET['id'];

		try{
			$consulta = $pdo->prepare("select * from produtos where id=?");
			$consulta->bindParam(1, $id, PDO::PARAM_STR );

			if($consulta->execute()){


				$resultado = $consulta->fetchAll(PDO::FETCH_OBJ);
				foreach($resultado as $linha){
				?>
					<form method="POST" action="alterar.php">
						<input type="hidden" name="id" value="<?php echo $linha->id ?>"><br>
						<label>Nome Produto</label>
						<input type="text" name="nomeproduto" value="<?php echo $linha->nome ?>"><br>
						<label>Valor Produto</label>
						<input type="text" name="valorproduto" value="<?php echo $linha->valor ?>"><br>
						<input type="submit" value="Atualizar">
					</form>
				<?php
				}
				
			}else{
				echo "Erro ao consultar o produto.";
			}	
?>
				

<?php
			
		}catch(PDOExceptio $e){
			echo "Erro ao consultar: ".$e->getMessage();
		}

	}else if(isset($_POST['nomeproduto']) && isset($_POST['valorproduto']) && isset($_POST['id'])){
		$id = $_POST['id'];
		$nomeproduto = $_POST['nomeproduto'];
		$valorproduto = $_POST['valorproduto'];

		// verifica se as variáveis estão vazias
		if(!empty($nomeproduto) || !empty($valorproduto)){

			try {
				$alterar = $pdo->prepare("update produtos set nome=?, valor=? where id=?");
				$alterar->bindParam(1, $nomeproduto, PDO::PARAM_STR);
				$alterar->bindParam(2, $valorproduto, PDO::PARAM_STR);
				$alterar->bindParam(3, $id, PDO::PARAM_INT);
				
				if($alterar->execute()){
					echo "<script>alert('Atualizado com sucesso!')</script>";
					echo "<script>window.location.href ='/loja/lista_prod.php';</script>";
				}
			} catch (PDOException $e) {
				echo "Erro ao inserir".$e->getMessage();
			}

		}else{
			echo "<script>alert('Preencha todos os campos!')</script>";
			echo "<script>window.location.href ='/loja/lista_prod.php';</script>";
		}
	}else{
		echo "<script>window.location.href ='/loja/lista_prod.php';</script>";
	}

	


?>

</body>
</html>