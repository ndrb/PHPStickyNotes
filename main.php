<HTML>
    
		<?php			
			/* Makes sure page is only accessibleto logged-in users */
			session_start();
			
			if (!isset($_SESSION['username']))
			{
				header("Location: login.php");
			} 
	
			else
			{
				session_regenerate_id();
			}
		?>
	
    <HEAD>            
      <title>Keepr</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="css/main.css" type="text/css" rel="stylesheet" media="screen"></link>
			<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
			<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<link rel='stylesheet' type='text/css' href='css/main.css'/>
			<script type='text/javascript' src='mainFunc.js'></script>
			<link rel="icon" type="image/ico" href="img/favicon.ico"/>
    </HEAD>
    
	<BODY>	
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.html">Keepr</a>				
				</div>
				<div>
					<ul class="nav navbar-nav">
						<?php
							/* Hidden field containing username; this is to be used later on by our JS scripts */
							$u = $_SESSION['username'];
							echo "<article hidden>$u</article>";
						?>					
					
						<!-- Creates a new sticky -->
						<li><a href="#" onClick="functionCreate();" id="create">Create</a></li>
						
						<!-- Logs out the user -->
						<li><a href="php/logout.php" onClick="">Logout</a></li>
						
						<!-- Deletes the user account -->
						<li><a href="php/deleteUser.php" onClick="">Delete Account</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- Canvas that contains all the sticky notes -->
		<div id="stickcont">
			<script type="text/javascript">
				//Call to function that loads all the sticky notes of the logged-in user
				functionLoadAllStickys();
			</script>
		</div>
		
	</BODY>
    
</HTML>