<?php
require_once("../Config/MysqlSession.php");
require_once("../DBConector/SQLCLASS.php");
require_once("../interface/IUsuario.php");
require_once("../Class/usuario.php");
require_once("../Class/permisos.php");

class usuarioDAO implements IUsuario{

/*****************************************************************************************************/
	public function SelectUsuarios(){
		$mysql_session = new MysqlSession();
		$data_source = new Sql($mysql_session->getSession());
		$data_table = $data_source->SelectQuery("select * from usuarios");
		$usuario =NULL;
		$usuarios =array();
		
		while($row  = mysql_fetch_array($data_table)){
			$usuario = new Usuario();
			$usuario->setIdusuarios($row["idusuarios"]);
			$usuario->setUsername($row["username"]);
			$usuario->setPassword($row["password"]);
			$usuario->setPassword2($row["password2"]);
			$usuario->setPasswordEmail($row["password_email"]);
			$usuario->setTerminal($row["terminal"]);
			$usuario->setTipo($row["tipo"]);
			$usuario->setEmail($row["email"]);
			$usuario->setSucursal($row["sucursal"]);
			array_push($usuarios,$usuario);
		}
		return $usuarios;
	}
/*****************************************************************************************************/
	public function SelectUsuariobyID($id){
		$mysql_session = new MysqlSession();
		$data_source = new Sql($mysql_session->getSession());
		$query = "select * from usuarios where idusuarios = '$id' limit 1";
		$data_table = $data_source->SelectQuery($query);
		
		$usuario = new Usuario();
		
		while($row  = mysql_fetch_array($data_table)){
			$usuario->setIdusuarios($row["idusuarios"]);
			$usuario->setUsername($row["username"]);
			$usuario->setPassword($row["password"]);
			$usuario->setPassword2($row["password2"]);
			$usuario->setPasswordEmail($row["password_email"]);
			$usuario->setTerminal($row["terminal"]);
			$usuario->setTipo($row["tipo"]);
			$usuario->setEmail($row["email"]);
			$usuario->setSucursal($row["sucursal"]);
		}
		return $usuario;
	}
/*****************************************************************************************************/
	public function SelectUsuariobyUsername($username){
		$mysql_session = new MysqlSession();
		$data_source = new Sql($mysql_session->getSession());
		$query = "select * from usuarios where username = '$username' limit 1";
		$data_table = $data_source->SelectQuery($query);
		
		$usuario = new Usuario();
		
		while($row  = mysql_fetch_array($data_table)){
			$usuario->setIdusuarios($row["idusuarios"]);
			$usuario->setUsername($row["username"]);
			$usuario->setPassword($row["password"]);
			$usuario->setPassword2($row["password2"]);
			$usuario->setPasswordEmail($row["password_email"]);
			$usuario->setTerminal($row["terminal"]);
			$usuario->setTipo($row["tipo"]);
			$usuario->setEmail($row["email"]);
			$usuario->setSucursal($row["sucursal"]);
		}
		return $usuario;
	}
/*****************************************************************************************************/
	public function InsertUsuario(Usuario $usuario){
		 $mysql = new MysqlSession();
		 $data_source = new Sql($mysql->getSession());
		 
		 $fields = array('idusuarios','username','password','password2','tipo','terminal','email','password_email','sucursal');
		 $values = array($usuario->getIdusuarios(),
						 $usuario->getUsername(),
						 $usuario->getPassword(),
						 $usuario->getPassword2(),
						 $usuario->getTipo(),
						 $usuario->getTerminal(),
						 $usuario->getEmail(),
						 $usuario->getPasswordEmail(),
						 $usuario->getSucursal());
						 
						 
		 
		 if(!$data_source->Exist("usuarios","username",$usuario->getUsername())){
		 	 $Resultset = $data_source->Insert("usuarios",$fields,$values);
			 $Resultset = $data_source->AFFECTED_ROWS;
		 }else{
			 $Resultset = "el usuario ya existe";
		 }
		 return $Resultset;
	}
/*****************************************************************************************************/
	public function UpdateUsuario(Usuario $usuario){
		$mysql = new MysqlSession();
		$data_source = new Sql($mysql->getSession());
		$fields = array('idusuarios','username','password','password2','tipo','terminal','email','password_email','sucursal');
		
		$values = array($usuario->getIdusuarios(),
						$usuario->getUsername(),
						$usuario->getPassword(),
						$usuario->getPassword2(),
						$usuario->getTipo(),
						$usuario->getTerminal(),
						$usuario->getEmail(),
						$usuario->getPasswordEmail(),
						$usuario->getSucursal());
		$cond = $fields[0]."=".$values[0];
		
		if($data_source->Exist("usuarios","idusuarios",$usuario->getIdusuarios())){
			 $data_source->Update("usuarios",$fields,$values,$cond);
			 $Resultset = $data_source->AFFECTED_ROWS;
		}else{
			$Resultset = "el usuario No existe";
		}
		return $Resultset;
	}
/*****************************************************************************************************/
	public function DeleteUsuario($id){
		$mysql = new MysqlSession();
		$data_source = new Sql($mysql->getSession());
		$query = "delete from usuarios where idusuarios='$id'";
	    $data_source->SelectQuery($query);
		$ResultSet = $data_source->AFFECTED_ROWS;
		//return $query;
		return $ResultSet;
	}
/*****************************************************************************************************/
	public function LoginUsuario(Usuario $usuario){
		$mysql = new MysqlSession();
		$data_source = new Sql($mysql->getSession());
		$ResultSet="";
		if($data_source->Exist("usuarios","username",$usuario->getUsername())){
			
			$data_source->SelectQuery("select * from usuarios where username='".$usuario->getUsername()."' and password='".$usuario->getPassword()."' limit 1");
			$ResultSet = $data_source->AFFECTED_ROWS;
		}
		return $ResultSet;
	}
/*****************************************************************************************************/
	public function SetPermisionUsuario(Usuario $usuario){
		$mysql = new MysqlSession();
		$data_source = new Sql($mysql->getSession());
		if($data_source->Exist("usuarios","username",$usuario->getUsername())){
			$data_source->SelectQuery("select * from permisos where idusuarios='".$usuario->getIdusuarios()."'");
			$ResultSet = $data_source->AFFECTED_ROWS;
		}
		return $ResultSet;
	}
/*****************************************************************************************************/
}
?>