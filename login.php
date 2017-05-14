<HTML>

	<HEADER>	
		<title>Login</title>
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
					<h2 id="errorlabel">Please log in</h2>
					<form action="" class="form" method="POST">
						<input type="text" name="username" placeholder="Username">
						<input type="password" name="password" placeholder="Password">
						<input type="submit" name="submit" value="Login"></input>
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
					//Checks if password field is set
					if((isset($_POST['password'])) && !empty($_POST['password']))
					{
						//Retreives the username and password and sets them to local variables
						$username = htmlentities($_POST['username']);
						$password = htmlentities($_POST['password']);

						//Instantiate a new PDO object for DB manipulation
						$pd = new PDOClass;
						
						//Fetches the username or email associated with what the user entered
						//So that they may log in with either username or email
						$result = $pd->userEmailCompromise($username);
						
						//Checks if the user has previously tried to log in unsuccessfully
						$trying = $pd->peekAuthentification($result[0], $result[1]);
						
						//If user has been tracked for unsuccessfully log-ins
						if($trying)
						{
							$hold = strtotime($trying[2]);
							$timestamp = strtotime('+30 minutes', $hold);
							
							//Check if there where already 3 unsuccessfully logins
							if($trying[1] >= 3)
							{
								//The user has been locked-out
								//We check if 30 minutes have passed
								if($timestamp >  (strtotime(((date('m/d/Y h:i:s a', time()))))))
								{
									?>
										<script type="text/javascript">
											errorLabelerLock();
										</script>
									<?php	
								}
								
								//If yes we lift the lock-out and check again
								else
								{
									$pd->userBanLifted($username);
									
									
									if(password_verify($password, $pwd))
									{
										session_start();
										session_regenerate_id();
										$_SESSION['username'] = $username;
										header("Location: main.php");
									}

									else
									{
										$try = $pd->getTry($username);
										$try++;
										$pd->updateAuthentification($username, $try, (date('m/d/Y h:i:s a', time())));	
									}										
								}
							}
							
							//The user has tried to login unsuccessfully, but is getting another chance
							else
							{
								$pwd = $pd->authentificate($username);
								
								if(password_verify($password, $pwd))
								{
									session_start();
									session_regenerate_id();
									$_SESSION['username'] = $username;
									header("Location: main.php");
								}
								
								//Another unsuccessfully login is logged
								else
								{
									$try = $pd->getTry($username);
									$try++;
									$pd->updateAuthentification($username, $try, (date('m/d/Y h:i:s a', time())));									
								}
							}
						}

						//If user has not tried to log in yet, goes through here
						else
						{
							$pwd = $pd->authentificate($username);
							
							if(password_verify($password, $pwd))
							{
								session_start();
								session_regenerate_id();
								$_SESSION['username'] = $username;
								header("Location: main.php");
							}					

							//We begin a log to track the user log-ins
							else
							{
								$try = 1;
								$pd->createAuthentification($username, $try, (date('m/d/Y h:i:s a', time())));
							}
						}
					}
					
					else
					{
						//Sets and error label
						?>
							<script type="text/javascript">
								errorLabeler();
							</script>
						<?php							
					}
				}
				
				else
				{
					//Sets and error label
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