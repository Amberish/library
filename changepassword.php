<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		
		$validate = new Validate();

		$validation = $validate->check($_POST, array(
			'current_password' => array(
				'required' => true,
				'min' => 6
			),
			'new_password' => array(
				'required' => true,
				'min' =>6
			),
			'new_password_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'new_password'
			)
		));

		if($validate->passed()) {

			if(Hash::make(Input::get('current_password'), $user->data()->salt) !== $user->data()->password) {
				echo 'Your current password is wrong!!';
			} else {
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('new_password'), $salt),
					'salt' => $salt
				));

				Session::flash('home', 'Your password has been changed!!');

				Redirect::to('index.php');
			}

		} else {
			foreach($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

?>

<form method="post" action="">
	<div class="fields">
		<label for="current_password">Current Password</label>
		<input type="text" name="current_password" id="current_password" >
	</div>

	<div class="fields">
		<label for="new_password">New Password</label>
		<input type="text" name="new_password" id="new_password" >
	</div>

	<div class="fields">
		<label for="new_password_again">New Password Again</label>
		<input type="text" name="new_password_again" id="new_password_again">
	</div>

	<input type="Submit" value="Change" >
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
</form>