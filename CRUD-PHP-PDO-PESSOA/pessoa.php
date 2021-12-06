<?php

Class Pessoa{

	private $pdo;
    //Conexao com o BD
	public function __construct($dbname, $host, $user, $senha){
      
          try {
          		$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
          } catch (PDOException $e) {
          	    echo "Erro com o Banco de Dados".$e->getMessage();
          	    exit();
          }
          catch(Exception $e){
          		echo "Erro generico: ".$e->getMessage();
          		exit();
          }
	}
	//Método para buscar dados e apresentar no canto direito da tela
	public function buscarDados(){

		$resultado = array();
		$comando = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
		$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
    //Cadastrar Pessoas no Banco de Dados (BD)
	public function cadastrarPessoa($nome, $telefone, $email){
		//Verificar se já está cadastrado
		$comando = $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
		$comando->bindValue(":e",$email);
		$comando->execute();
		if($comando->rowCount() > 0){
			
			//O email já existe
			
			return false;
		}else{
			  //O email não foi encontrado

			  $comando = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES(:n, :t, :e)");
			  $comando->bindValue(":n",$nome);
			  $comando->bindValue(":t",$telefone);
			  $comando->bindValue(":e",$email);
			  $comando->execute();

			  return true;
		}

	}
	//Excluir uma Pessoa 
	public function excluirPessoa($id){

		$comando = $this->pdo->prepare("DELETE FROM pessoa WHERE id= :id");
		$comando->bindValue(":id",$id);
		$comando->execute();
	}

	//Buscar os dados de uma pessoa
	public function buscarDadosPessoa($id){

   		$resultado = array();
         $comando = $this->pdo->prepare("SELECT * FROM pessoa WHERE id= :id");
         $comando->bindValue(":id",$id);
         $comando->execute();
         $resultado = $comando->fetch(PDO::FETCH_ASSOC);

         return $resultado;  

	}


	//Atualizar os dados de uma pessoa no BD
	public function atualizarDadosPessoa($id, $nome, $telefone, $email){
		
	    $comando = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
		$comando->bindValue(":n", $nome);
		$comando->bindValue(":t", $telefone);
		$comando->bindValue(":e", $email);
		$comando->bindValue(":id", $id);
		$comando->execute();
	}
}

?>