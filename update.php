<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'label' => 'Your Name', 
				'required' => true,
				'min' => 2,
				'max' => 20
			)
		));

		if($validate->passed()){
			try {
				$user->update(array(
					'name' => Input::get('name')
				));

				Session::flash('home', 'Your details have been updated!');
				Redirect::to('index.php');
			} catch(Exception $e) {
				die($e->getMessage());
			}
		} else {
			/*Function found in common-markup.php*/
			displayErrors($validate->errors(), 'validation');
		}
	}
}

?>

<form action="" method="post">
	<div class="fields">
		<label for="name">Name</label>
		<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>" >

		<input type="submit" value="Update" />
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
	</div>
</form>