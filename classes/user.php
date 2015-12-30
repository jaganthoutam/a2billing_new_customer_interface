<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username){

		try {
			$qury = '';
			$stmt = $this->_db->prepare('SELECT *  FROM cc_card WHERE useralias = :username AND activated="f"');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function login($username,$password){

		$row = $this->get_user_hash($username);

		if($password == $row['uipass']){
			    $_SESSION['loggedin'] 		= true;
			    $_SESSION['useralias'] 		= $row['useralias'];
			    $_SESSION['username'] 		= $row['username'];
			    $_SESSION['id'] 			= $row['id'];
			    $_SESSION['creationdate'] 		= $row['creationdate'];
			    $_SESSION['credit'] 		= $row['credit'];
			    $_SESSION['lastname'] 		= $row['lastname'];
	                    $_SESSION['firstname'] 		= $row['firstname'];
			    $_SESSION['address'] 		= $row['address'];
			    $_SESSION['country'] 		= $row['country'];
			    $_SESSION['currency'] 		= $row['currency'];  
			    $_SESSION['lastuse'] 		= $row['lastuse'];
			    $_SESSION['email']			= $row['email'];
			    $_SESSION['phone']			= $row['phone'];
				$_SESSION['tariff']		=	$row['tariff'];
		    return true;
		}
	}


	public function logout(){
		session_destroy();
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

}


?>
