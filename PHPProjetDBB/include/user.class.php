<?php 
interface iuser
{
    public function getAllUsers();
    public function getUserFromDatabase();
	public function insertUser();
	public function updateUser();
	public function deleteUser();
	public function getUserFromNewForm();
	public function getUserFromModForm();
	public function validUserNewForm();
	public function validUserModForm();
}

class user implements iuser
{
	public $idclef;
	public $objectConnexion;
	
	public $id;
	public $niveau;
	public $auth;
	public $login;
	public $prenom;
	public $email;
	public $menu;

	// Constructeur : idclef de l'user, et DBAcces class
	public function __construct($userIdclef, $databaseId)
	{
		$this->idclef=$userIdclef;
		$this->objectConnexion=$databaseId;
	}
	
	function getAllUsers()
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
		
		$result=$objectDatabase->query('SELECT * FROM user ORDER BY login');
		
		$userList = "";
		$userList.= "<table>";
		$userList.= "<tr>";
		$userList.= "<th colspan=2>Action</th>";
		$userList.= "<th>Login (<a href='index01.php'>New</a>)</th>";
		$userList.= "<th>Pr&eacute;nom</th>";
		$userList.= "<th>Adresse</th>";
		$userList.= "<th>Niveau</th>";
		$userList.= "<th>Autorisations</th>";
		$userList.= "<th>Menu</th>";
		$userList.= "<th>Email</th>";
		$userList.= "<th>Creation</th>";
		$userList.= "<th>Acc&egrave;s</th>";
		$userList.= "</tr>";
		
		while( $row=mysql_fetch_object($result) ) 
		{
			$ligne+=1;
			$class=$ligne%2?'even':'odd';
			$userList.= "<tr valign=top class=$class>";
			$userList.= "<td><a href=index02.php?clef=$row->idclef class=links><img src='/images/b_edit.png' width='16' height='16' alt='Modifier'></a></td>";
			$userList.= "<td><a href=index04.php?clef=$row->idclef class=links><img src='/images/b_drop.png' width='16' height='16' alt='Supprimer'></a></td>";
			$userList.= "<td>".$row->login."</td>";
			$userList.= "<td>".stripslashes($row->prenom)."</td>";
			$userList.= "<td>".$this->getClef_1($row->id_adresse)."</td>";
			$userList.= "<td>$row->niveau</td>";
			$userList.= "<td>$row->auth</td>";
			$userList.= "<td>$row->menu</td>";
			$userList.= "<td><a href=\"mailto:$row->email\">$row->email</a></td>";
			$userList.= "<td>".datefr($row->date_creation)."</td>";
			$userList.= "<td>".datefr($row->date_lastpass)."</td>";
			$userList.= "</tr>";
		}
		$objectDatabase->disconnect();
		$userList.= "</table>";
			
		return $userList;	
	}
	
	function getUserFromDatabase()
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
		
		$result=$objectDatabase->query("SELECT * FROM user WHERE idclef='".$this->idclef."'");
		$row=mysql_fetch_object($result);
		
		$this->idclef		= $row->idclef;
		$this->niveau		= $row->niveau;
		$this->auth			= $row->auth;
		$this->menu			= $row->menu;
		$this->login		= $row->login;
		$this->prenom		= stripslashes($row->prenom);
		$this->id_adresse	= $row->id_adresse;
		$this->clef_1		= $this->getClef_1($row->id_adresse);
		$this->email		= $row->email;
		
		$objectDatabase->disconnect();
	}
	
	function insertUser()
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
	
		$creat_compte=date("Y-m-j");
		$idclef=recup_clef();
		
		$sql = "
        INSERT INTO user (
                `idclef`
                , `niveau`
				, `auth`
                , `login`
                , `prenom`
                , `password`
                , `email`
                , `date_creation`	
                , `menu`	
        ) VALUES (
                '$idclef'
				,'$this->niveau'
				,'$this->auth'
                ,'".$this->login."'
				,'".mysql_real_escape_string($this->prenom)."'
                ,'".md5($this->password1)."'
                ,'".$this->email."'
				,'$creat_compte'
				,'$this->menu'
			)";
		
		$result=$objectDatabase->query($sql);
		if (!$result)  die ("Requête invalide :  " . mysql_error());
		
		$objectDatabase->disconnect();
	}
	
	function updateUser()
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
	
		$sql = "
			UPDATE user SET 
				niveau			='".$this->niveau."'
				, auth			='".$this->auth."'
				, menu			='".$this->menu."'
				, prenom		='".$this->prenom."'
				, id_adresse	='".$this->id_adresse."'
				, email			='".$this->email."'
			WHERE idclef		='".$this->idclef."'
			";
		
		$result=$objectDatabase->query($sql);
		if (!$result)  die ("Requête invalide :  " . mysql_error());
		
		$objectDatabase->disconnect();
	}
	
	function deleteUser()
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
	
		$sql = "
			DELETE FROM user 
			WHERE idclef='".$this->idclef."'
			";
		
		$result=$objectDatabase->query($sql);
		if (!$result)  die ("Requête invalide :  " . mysql_error());
		
		$objectDatabase->disconnect();
	}
	
	function getUserFromNewForm()
	{
		$this->login		= $_POST['login'];
		$this->password1	= $_POST['password1'];
		$this->password2	= $_POST['password2'];
		$this->prenom		= $_POST['prenom'];
		$this->email		= $_POST['email'];
		$this->niveau		= $_POST['niveau'];
		$this->menu			= $_POST['menu'];
	}
	
	function getUserFromModForm()
	{
		$this->idclef		= $_POST['idclef'];
		$this->niveau		= $_POST['niveau'];
		$this->auth			= $_POST['auth'];
		$this->menu			= $_POST['menu'];
		$this->login		= $_POST['login'];
		$this->prenom		= $_POST['prenom'];
		$this->id_adresse	= $_POST['id_adresse'];
		$this->clef_1		= $_POST['clef_1'];
		$this->email		= $_POST['email'];
	}

	function validUserNewForm() 
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();

		$msg = array();

		// Login non rempli
		$msg['login'] = checkInput("required", $this->login);
		if($msg['login'])
			$msg['erreur'] = true;
		
		// Login existant
		$sql="SELECT 1 FROM user WHERE login = '".$this->login."'";
		$result=$objectDatabase->query($sql);
		if (!$result)  die ("Requête invalide :  " . mysql_error());
		if  (mysql_num_rows($result) > 0)
		{
			$msg['login'] = " Cet identifiant existe déjà";
			$msg['erreur'] = true;
		} 

		// Password non rempli
		$msg['password1'] = checkInput("required", $this->password1);
		if($msg['password1'])
			$msg['erreur'] = true;
		$msg['password2'] = checkInput("required", $this->password2);
		if($msg['password2'])
			$msg['erreur'] = true;

		if ($this->password1<>$this->password2) 
		{
	    	$msg['password2'] = " Mots de passe différents";
			$msg['erreur'] = true;
		}

		// Prénom non rempli
		$msg['prenom'] = checkInput("required", $this->prenom);
		if($msg['prenom'])
			$msg['erreur'] = true;

		// Vérification Email
		$msg['email'] = checkInput("required", $this->email);
		if($msg['email'])
			$msg['erreur'] = true;
		if (!$msg['email']) 
		{
			$msg['email'] = checkInput("email", $this->email);
			if($msg['email'])
				$msg['erreur'] = true;
		}

    	return $msg;
	}

	function validUserModForm() 
	{
		$msg = array();

		// Prénom non rempli
		$msg['prenom'] = checkInput("required", $this->prenom);
		if($msg['prenom'])
			$msg['erreur'] = true;

		// Nom client
		if($this->clef_1 != "")
		{
			$this->id_adresse = $this->getAdresseId($this->clef_1);
			//echo "Adresse client id  : ".$this->id_adr_client;
			//echo "Adresse client nom : ".$this->adr_client;
			if(!$this->id_adresse)
			{
				$msg['clef_1'] = "Adresse inconnue";
				$msg['erreur'] = true;
			}
		}

		// Vérification Email
		$msg['email'] = checkInput("required", $this->email);
		if($msg['email'])
			$msg['erreur'] = true;
		if (!$msg['email']) 
		{
			$msg['email'] = checkInput("email", $this->email);
			if($msg['email'])
				$msg['erreur'] = true;
		}
	
   	 	return $msg;
	}

 	function getAdresseId($clef_1)
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
		
		$this->clef_1 = $clef_1;
		
		$sql	= "SELECT id_adresse FROM eole_adresse WHERE clef_1 ='".$this->clef_1."'";
		//echo $sql;
		$result=$objectDatabase->query($sql);
		$row=mysql_fetch_object($result);
		
		$id_adresse = false;
		if($row->id_adresse)
			$id_adresse = $row->id_adresse;
		return $id_adresse;
	}

	function getClef_1($id_adresse) 
	{
		$objectDatabase=$this->objectConnexion;
		$objectDatabase->connect();
		$this->id_adresse = $id_adresse;
		
		$sql	= "SELECT clef_1 FROM eole_adresse WHERE id_adresse ='".$this->id_adresse."'";
		$result=$objectDatabase->query($sql);
		$row=mysql_fetch_object($result);
		
		if(!$row->clef_1)
		{
			return "Inconnu";
		} else {
			return $row->clef_1;
		}
	}


}
?>