<!DOCTYPE html>
<HTML>

	<HEADER>	
		<title>Registration</title>
		<link rel="stylesheet" href="css/loreg.css">
		<link rel="icon" type="image/ico" href="img/favicon.ico"/>
		<script type='text/javascript' src='js/errorlabel.js'></script>
		<!--Template for page courtesy of: http://codepen.io/Lewitje/full/BNNJjo/ -->
		<!--All effects and UI credited to the author-->
	</HEADER>
	
	
	<BODY>

	
		<div class="wrapper">
			<div class="container">
				<h1>Welcome</h1>
				
				<!-- This label will change depending on if the user processedes with illegal actions -->
				<h2 id="errorlabel">Please register</h2>
					<form action="" class="form" method="POST">
						<input type="text" name="username" placeholder="Username">
						<input type="text" name="email" placeholder="Email">
						<input type="password" name="password" placeholder="Password">
						<input type="submit" name="submit" value="Register"></input>
					</form>
			</div>
		
			<!--All the li elements are the floating square bubbles that float up in the background of the page; all credits to author of the template-->
			<ul class="bg-bubbles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		
		</div>
			
		<?php
		require_once('php/PDOInterface.php');
		require_once('php/PDOClass.php');
		
			//This is used to give the form some sticky functionality so that it resubmits to the same page
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{	
				//Checks if username field is set
				if((isset($_POST['username'])) && !empty($_POST['username']))
				{
					//Checks if email field is set
					if((isset($_POST['email'])) && !empty($_POST['email']))
					{
						//Checks if password field is set
						if((isset($_POST['password'])) && !empty($_POST['password']))
						{
							//Retreives the username and sets it into a local variable
							$user = htmlentities($_POST['username']);

							//Instantiate a new PDO object for DB manipulation
							$pd = new PDOClass;
							
							//Method that checks if the username is available, usernames are unique
							$result = $pd->checkNameAvail($user);
						
							//If username is unique
							if($result == true)
							{
								//Hashes the password entered and stores in the database
								$password = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);
								$pd->createUser($user, htmlentities($_POST['email']), $password);
								
								//Starts a session and redirects to the user-page aka 'Sticky area'
								session_start();
								session_regenerate_id();
								$_SESSION['username'] = $user;
								header("Location: main.php");
							}
							
							//If username is taken, sets an appropriate error message
							else
							{
								?>
									<script type="text/javascript">
										errorLabelerTaken();
									</script>
								<?php							
							}
						}
						
						//If user is did not fill all fields, they will be notified
						else
						{
							?>
								<script type="text/javascript">
									errorLabeler();
								</script>
							<?php	
						}
						
					}
					
					//If user is did not fill all fields, they will be notified
					else
					{
						?>
							<script type="text/javascript">
								errorLabeler();
							</script>
						<?php							
					}
					
				}
				
				//If user is did not fill all fields, they will be notified
				else
				{
					?>
						<script type="text/javascript">
							errorLabeler();
						</script>
					<?php						
				}
			}
			
		?>
		
	</BODY>
</HTML>


