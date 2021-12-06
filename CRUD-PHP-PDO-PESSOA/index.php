<?php 
require_once 'pessoa.php';
$pessoa = new Pessoa("crud-pdo","localhost","root","");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cadastro Pessoa</title>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
	<?php
     if(isset($_POST['nome'])){
     	//Quando clica em cadastrar ou editar
     	if(isset($_GET['id_update']) && !empty($_GET['id_update'])){
     		//-----------------EDITAR----------------------------
     		$id_update = addslashes($_GET['id_update']);
     		$nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
        	if(!empty($nome) && !empty($telefone) && !empty($email)){
           
               //Editar
 		 	   $pessoa->atualizarDadosPessoa($id_update,$nome,$telefone,$email);
 		 	   header("location: index.php");
            }else{
            	  ?>
        	      	<div class="aviso">
        	      		<img src="aviso.png">
        	      		<h4>Preencha todos os campos</h4>
        	      	</div>
        	      <?php
            }	

        }
     		//-----------------CADASTRAR-------------------------
     	else{

     		$nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
        	if(!empty($nome) && !empty($telefone) && !empty($email)){
           
               //Cadastrar
 		 	   if(!$pessoa->cadastrarPessoa($nome,$telefone,$email)){
 		 	   		  ?>
        	      		<div class="aviso">
        	      			<img src="aviso.png">
        	      			<h4>Email já está cadastrado!</h4>
        	      		</div>

        	      	  <?php
 			    }

            }else{
        	      ?>
        	      	<div class="aviso">
        	      		<img src="aviso.png">
        	      		<h4>Preencha todos os campos</h4>
        	      	</div>

        	      <?php
            }
     	}
     }
	?>
	<?php
	     //Quando a pessoa clica em editar
         if(isset($_GET['id_update'])){
         	$id_update = addslashes($_GET['id_update']);
         	$resultado = $pessoa->buscarDadosPessoa($id_update);

         }
	?>
	<section id="esquerda">
		<form method = "POST">
			<h2>CADASTRAR PESSOA</h2>
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" value="<?php if(isset($resultado)){echo $resultado['nome'];}?>">
			<label for="telefone">Telefone</label>
			<input type="text" name="telefone" id="telefone" value="<?php if(isset($resultado)){echo $resultado['telefone'];}?>">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?php if(isset($resultado)){echo $resultado['email'];}?>">
		    <input type="submit" value="<?php if(isset($resultado)){echo "Atualizar";}else{echo "Cadastrar";}?>">
		</form>	
	</section>
	
	<section id="direita">
		<table>
		   <tr id="titulo">
				<td>NOME</td>
				<td>TELEFONE</td>
				<td colspan="2">EMAIL</td>
		   </tr>
		   <?php
			    $dados = $pessoa->buscarDados();
			    if(count($dados)>0){

				  for ($i=0; $i < count($dados); $i++) { 
					
					echo "<tr>";
					foreach ($dados[$i] as $key => $value) {
						
						if($key != "id"){
						 
						   echo "<td>".$value."</td>";
						}
					}

				    ?>
		    <td>
				<a href="index.php?id_update=<?php echo $dados[$i]['id'];?>">Editar</a>
				<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
			</td>
				    <?php
					echo "</tr>";
				}
			}else{
				 //O BD está vazio
			?>	
		</table>
				<div class="aviso">
					<h4>Ainda não há pessoas cadastradas!</h4>
				    </div>
				<?php 
			}
		?> 			
	</section>

</body>
</html>


<?php
  
     if(isset($_GET['id'])){

     	$id_pessoa = addslashes($_GET['id']);
     	$pessoa->excluirPessoa($id_pessoa);
     	header("location: index.php");
     }
?>