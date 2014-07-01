<?php
	require_once 'core/init.php';

	if(Input::exists()){
		if(Token::check(Input::get('token'))){

			$validate = new Validate();
			$validate = $validate->check($_POST, array(
				'username' => array(
					'label' => 'Username',
					'required' => true,
					'min' => 2,
					'max' => 20,
					'unique' => 'users'
				),
				'password' => array(
					'label' => 'Password',
					'required' => true,
					'min' => 6
				),
				'password_again' => array(
					'label' => 'Password Again', 
					'required' => true,
					'matches' => 'password'
				),
				'name' => array(
					'label' => 'Your Name',
					'required' => true,
					'min' => 2,
					'max' => 50
				)
			));

			if($validate->passed()){
				$user = new User();

				$salt = Hash::salt(32);
				
				try{

					$user->create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'name' => Input::get('name'),
						'joined' => date('Y-m-d H:i:s'),
						'group' => 1
					));

					Session::flash('home', 'You have been registered and now login!!');
					Redirect::to('index.php');

				} catch(Exception $e){
					die($e->getMessage());
				}
			}else{
				/*Function found in common-markup.php*/
				displayErrors($validate->errors(), 'validation');
			}
		}
	}
?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(INPUT::get('username')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="text" name="password" id="password" value=""  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="password_again">Enter Passsword Again</label>
		<input type="text" name="password_again" id="password_again" value=""  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="name">Your Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(INPUT::get('name')); ?>"  autocomplete="off"/>
	</div>
	<input type="hidden" name="token" value="<?php echo  Token::generate(); ?>" />
	<input type="submit" value="Register" />
</form>