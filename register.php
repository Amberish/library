<?php
	require_once 'core/init.php';

	if(Input::exists()){
		if(Token::check(Input::get('token'))){

			$validate = new Validate();
			$validate = $validate->check($_POST, array(
				'fullname' => array(
					'label' => 'Fullname',
					'required' => true,
					'min' => 2,
					'max' => 50
				),
				'gender' => array(
					'label' => 'Gender',
					'required' => true
				),
				'marital_status' => array(
					'label' => 'Marital Status',
					
					'value_not' => 'select'
				),
				'age' => array(
					'label' => 'Age',
					
					'min' => 1,
					'type' => 'int'
				),
				'date' => array(
					'label' => 'Date',
					
					'value_not' => 'select'
				),
				'month' => array(
					'label' => 'Month',
					
					'value_not' => 'select'
				),
				'year' => array(
					'label' => 'Year',
					
					'value_not' => 'select'
				),
				'tob' => array(
					'label' => 'Time of Birth',
					
				),
				'height' => array(
					'label' => 'Height',
					
					'type' => 'float'
				),
				'weight' => array(
					'label' => 'Weight',
					'min' => 1,
					'type' => 'int'
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
				)
			));

			if($validate->passed()){
				$user = new User();

				$salt = Hash::salt(32);
				
				try{
					
					$user_id = $user->create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'name' => Input::get('name'),
						'joined' => date('Y-m-d H:i:s'),
						'group' => 1
					))->lastUserId();

					$user->create(array(
						'user_id' => $user_id,
						'fullname' => Input::get('fullname'),
						'gender' => Input::get('gender')
					), 'profile_detail');

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
		<label for="fullname">Fullname</label>
		<input type="text" name="fullname" id="fullname" value="<?php echo escape(INPUT::get('fullname')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(INPUT::get('username')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="gender">Gender</label>
		<input type="radio" name="gender" id="gender" value="male" <?php echo (Input::get('gender') == 'male') ? 'checked' : ''; ?>> Male &nbsp;&nbsp;
		<input type="radio" name="gender" id="gender" value="female" <?php echo (Input::get('gender') == 'female') ? 'checked' : ''; ?>> Female
	</div>	

	<?php
		$marital_status = array('unmarried' => 'Unmarried',
								'widow' => 'Widow',
								'widower' => 'Widower',
								'divorced' => 'Divorced');
	?>

	<div class="field">
		<label for="marital_status">Marital Status</label>
		<select name="marital_status" id="marital_status" > 
			<option value="select">Select</option>
			<?php
				foreach ($marital_status as $status_short => $status) {
					?>
					<option value="<?php echo $status_short; ?>" <?php echo (Input::get('marial_status') == $status_short) ? 'selected' : '' ;?> ><?php echo $status; ?></option>
					<?php
				}
			?>
		</select>
	</div>

	<div class="field">
		<label for="age">Age</label>
		<input type="text" name="age" id="age" value="<?php echo escape(INPUT::get('age')); ?>"  autocomplete="off"/> Yrs.
	</div>

	<?php
		$lastDate = 31;
		$months = array('jan' => 'January', 
					   'feb' => 'February',
					   'mar' => 'March',
					   'apr' => 'April',
					   'may' => 'May',
					   'jun' => 'June',
					   'jul' => 'July',
					   'aug' => 'August',
					   'sep' => 'September',
					   'oct' => 'October',
					   'nov' => 'November',
					   'dec' => 'December');
		$yearStart = '1980';
		$yearEnd = '2001';
	?>

	<div class="field">
		<label for="date">Date of Birth</label>
		<select name="date" id="date" > 
			<option value="select">Select</option>
			<?php
				for($i = 1; $i <= $lastDate; $i++) {
					?>
					<option value="<?php echo $i; ?>" <?php echo (Input::get('date') == $i) ? 'selected' : '' ;?> ><?php echo $i; ?></option>
					<?php
				}
			?>
		</select>

		<select name="month" id="month" > 
			<option value="select">Select</option>
			<?php
				foreach($months as $short => $month) {
					?>
					<option value="<?php echo $short; ?>" <?php echo (Input::get('month') == $short) ? 'selected' : '' ;?> ><?php echo $month; ?></option>
					<?php
				}
			?>
		</select>

		<select name="year" id="year" > 
			<option value="select">Select</option>
			<?php
				for($i = $yearStart; $i <= $yearEnd; $i++) {
					?>
					<option value="<?php echo $i; ?>" <?php echo (Input::get('year') == $i) ? 'selected' : '' ;?> ><?php echo $i; ?></option>
					<?php
				}
			?>
		</select>
	</div>

	<div class="field">
		<label for="tob">Time of Birth</label>
		<input type="text" name="tob" id="tob" value="<?php echo escape(INPUT::get('tob')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="height">Height</label>
		<input type="text" name="height" id="height" value="<?php echo escape(INPUT::get('height')); ?>"  autocomplete="off"/> feet
	</div>

	<div class="field">
		<label for="weight">Weight</label>
		<input type="text" name="weight" id="weight" value="<?php echo escape(INPUT::get('weight')); ?>"  autocomplete="off"/> kgs.
	</div>

	<div class="field">
		<label for="color">Color</label>
		<input type="text" name="color" id="color" value="<?php echo escape(INPUT::get('color')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="edu">Education</label>
		<input type="text" name="edu" id="edu" value="<?php echo escape(INPUT::get('edu')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="occupation">Occupation</label>
		<input type="text" name="occupation" id="occupaion" value="<?php echo escape(INPUT::get('occupation')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="employed">Employed In</label>
		<input type="text" name="employed" id="employed" value="<?php echo escape(INPUT::get('employed')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="annual_income">Personal Annual Income</label>
		<input type="text" name="annual_income" id="annual_income" value="<?php echo escape(INPUT::get('annual_income')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="blood_group">Blood Group</label>
		<input type="text" name="blood_group" id="blood_group" value="<?php echo escape(INPUT::get('blood_group')); ?>"  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="manglik">Manglik</label>
		<input type="radio" name="manglik" id="manglik" value="yes" <?php echo (Input::get('manglik') == 'yes')? 'checked': ''; ?> /> Yes
		<input type="radio" name="manglik" value="no" <?php echo (Input::get('manglik') == 'no')? 'checked': ''; ?> /> No
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="text" name="password" id="password" value=""  autocomplete="off"/>
	</div>

	<div class="field">
		<label for="password_again">Enter Passsword Again</label>
		<input type="text" name="password_again" id="password_again" value=""  autocomplete="off"/>
	</div>

	<input type="hidden" name="token" value="<?php echo  Token::generate(); ?>" />
	<input type="submit" value="Register" />
</form>