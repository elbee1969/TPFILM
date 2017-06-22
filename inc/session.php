<?php
// systeme remember me
if(!empty($_COOKIE['usercook']) && !isset($_SESSION['user'])) {

	$auth = $_COOKIE['usercook'];
	$auth = explode('---',$auth);

	$sql = "SELECT * FROM users WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id',$auth[0]);
	$stmt->execute();
	$usercook = $stmt->fetch();

	if(!empty($usercook)) {
		$keys = sha1($usercook['pseudo'].$usercook['password'].$_SERVER['REMOTE_ADDR']);
		if($keys == $auth[1]) {
			$_SESSION['user'] = array(
    			'id'     => $usercook['id'],
    			'pseudo' => $usercook['pseudo'],
    			'role'   => $usercook['role'],
          'ip'     => $_SERVER['REMOTE_ADDR'],
    		);
    		setcookie('usercook', $usercook['id']. '---' . $keys , time() + 3600 * 24 * 5,'/');
    		echo 'Bienvenue de nouveau '.$usercook['pseudo'];
		} else {
			setcookie('usercook', '' , time() - 3600 ,'/');
		}
	}
}
