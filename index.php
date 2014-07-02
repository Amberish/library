<?php
ini_set('display_errors', true);
require_once 'core/init.php';

if(Session::exists('home')){
	echo Session::flash('home');
}

$user = new User();
if($user->isLoggedIn()){
?>

	<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>" ><?php echo escape($user->data()->username); ?></a></p>

	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="update.php">Update</a></li>
		<li><a href="changepassword.php">Change Password</a></li>
	</ul>
<?php

	/*if($user->hasPermission('moderator')) {
		echo '<p>You are Admin</p>';
	}*/

}else{
	echo '<p>You need to <a href="login.php" >log in</a> or <a href="register.php">register</a></p>';
}

HTML::dropDown(array('h' => 'hello', 'ho' => 'how', 'a' => 'are', 'u' => 'you'), 3,
						  array('class' => 'user', 'id' => 'new'));