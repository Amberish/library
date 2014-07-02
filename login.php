<?php
	require 'core/init.php';

	if(Input::exists()){
		if(Token::check(Input::get('token'))){

			$validate = new Validate();
			$validate = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'label' => 'Username'
				),
				'password' => array(
					'required' => true,
					'label' => 'Password'
				)
			));

			if($validate->passed()){
				$user = new User();

				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				
				if($login){
					Redirect::to('index.php');
				} else {
					echo '<p>Sorry, logging in failed!!</p>';
				}

			} else {

				/*Function found in common-markup.php*/
				displayErrors($validate->errors(), 'validation');
			}
		}
	}
?>
<form acton="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off"/>
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="text" name="password" id="password" autocomplete="off" />
	</div>

	<div class="field">
		<input type="checkbox" name="remember" id="remember" /> Remember Me
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
	<input type="submit" value="Log in" />
</form>