//General error label 
function errorLabeler()
{
	var label = document.getElementById('errorlabel');
	label.innerHTML = "Please fill all fields";
	label.style.color = "red";
}

//Error label for a locked out account
function errorLabelerLock()
{
	var label = document.getElementById('errorlabel');
	label.innerHTML = "This user has tried to log in too many times. Please try again in 30 minutes.";
	label.style.color = "red";
}

//Error label for a username that is already taken
function errorLabelerTaken()
{
	var label = document.getElementById('errorlabel');
	label.innerHTML = "Username is already taken, please try another";
	label.style.color = "red";
}

//Assures that the entire document has been loaded before calling any functions
function init(){}
window.onload = init;