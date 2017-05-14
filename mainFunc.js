var g = {};	

//Function that notifies the database when the text areas of a sticky note have been changed
function functionModifyStickyTxt()
{
	if(window.XMLHttpRequest)
	{
		g.ajaxObject = new XMLHttpRequest();
	}

	else if(window.ActiveXObject)
	{ 
		g.ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}

	g.ajaxObject.open("POST", "JSONmodifytxt.php", true);	
	g.ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	g.ajaxObject.send("ident=" + g.idToModify + "&title=" + g.title + "&subject=" + g.subject);		
}

//Function that notifies the database when the position of a sticky note has been changed
function functionModifyStickyDragg()
{
	if(window.XMLHttpRequest)
	{
		g.ajaxObject = new XMLHttpRequest();
	}

	else if(window.ActiveXObject)
	{ 
		g.ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}

	g.ajaxObject.open("POST", "JSONmodifydragg.php", true);	
	g.ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	g.ajaxObject.send("ident=" + g.idToDragg + "&x=" + g.x + "&y=" + g.y + "&z=" + g.z);		
}

//Function that notifies the database in order to delete a particular sticky note by id
function functionDeleteSticky()
{
	if(window.XMLHttpRequest)
	{
		g.ajaxObject = new XMLHttpRequest();
	}

	else if(window.ActiveXObject)
	{ 
		g.ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var ident = g.idToDelete;
	
	g.ajaxObject.open("POST", "JSONdelete.php", true);	
	g.ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	g.ajaxObject.send("ident=" + ident);			
}

//All newly created sticky notes and the stickys retreived from the database
//will pass throught this method to place the appropriate event handlers on the stickys
function functionDisplayNewlyCreated() 
{			
	var z = 100; 
	//Builds html for the individual sticky note
	var s = '<div id="' + g.id +'" class = "sticky"><textarea class="title" rows="1" cols="30">' + 
			g.title + '</textarea><br/><br/><textarea class="subject" rows="7" cols="30">' + g.subject + '</textarea></div>';
	
	//Appends it to the containing object
	$('#stickcont').append(s);

	//Makes the sticky note draggable and whenever dragging stops
	//the database is notified of the change of position
	$('#'+g.id).draggable
	(
		{
			stop:function()
			{
				g.idToDragg = $(this).attr('id');
				var pos = $("#"+g.idToDragg).position();
				g.x = pos.top;
				g.y = pos.left;
				g.z = $(this).css("z-index");
				functionModifyStickyDragg();
			}
		}
	);
	
	//Tracks changes to the text areas of the sticky note and notifies
	//the database when they are changed
	$('#'+g.id).change
	(
		function()
		{
			g.idToModify = $(this).attr('id');
			g.title = $(this).find(".title").val();
			g.subject = $(this).find(".subject").val();
			functionModifyStickyTxt();
		}
	);

	//Updates z-index
	$('#'+g.id).mousedown
	(
		function() 
		{
			$(this).css('z-index', z++);  			
		}
	);							

	//Makes the sticky notes selectable
	//$('#'+g.id).selectable();

	//Whenever a sticky note is clicked; this is ran in order
	//to update it's z-index to place it in the front
	$('#'+g.id).click
	(
		function()
		{
			$(this).css('z-index', g.z);
		}
	);

	//A double click event that fires off a jquerry affect to destroy
	//the div and updates the database to delete the sticky note
	$('#'+g.id).dblclick
	(
		function()
		{
			$(this).effect('explode');
			g.idToDelete = $(this).attr('id');
			functionDeleteSticky();
		}
	);
}

//Function that handles database response when a new sticky note is created
function functionCheckNewlyCreated()
{
	if(g.ajaxObject.readyState == 4 && g.ajaxObject.status == 200)
	{	
		var jsono = JSON.parse(g.ajaxObject.responseText);
		
		g.id = jsono.id;
		g.title = jsono.title;
		g.subject = jsono.subject;
		g.x = jsono.x;
		g.y = jsono.y;
		g.z = jsono.z;
		
		functionDisplayNewlyCreated();
	}
}

//Function that creates a sticky note and sends the info to a database
function functionCreate()
{
	if(window.XMLHttpRequest)
	{
		g.ajaxObject = new XMLHttpRequest();
	}

	else if(window.ActiveXObject)
	{ 
		g.ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var art = document.getElementsByTagName("article");
	var username = art[0].innerHTML;

	g.ajaxObject.open("POST", "JSONcreate.php", true);	
	g.ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	g.ajaxObject.onreadystatechange = functionCheckNewlyCreated;
	g.ajaxObject.send("username=" + username);									
}

//Function that handles database response when it responds with all the sticky notes for a user
function functionSetUpUserStickyes()
{
	if(g.ajaxObject.readyState == 4 && g.ajaxObject.status == 200)
	{	
		var jsono = JSON.parse(g.ajaxObject.responseText);
		
		for(var i = 0; i < jsono.length; i++)
		{		
			g.id = jsono[i]["ident"];
			
			if(jsono[i]["title"] == "undefined")
			{
				g.title = "";
			}
			
			else
			{
				g.title = jsono[i]["title"];
			}
			
			if(jsono[i]["subject"] == "undefined")
			{
				g.subject = "";
			}
			
			else
			{
				g.subject = jsono[i]["subject"];
			}
			
			g.x = jsono[i]["x"];
			g.y = jsono[i]["y"];
			g.z = jsono[i]["z"];
			
			functionDisplayNewlyCreated();
			$('#'+g.id).offset({top:g.x,left:g.y});
		}
	}	
}

//Function that calls the server to get all the sticky notes at login
function functionLoadAllStickys()
{
	if(window.XMLHttpRequest)
	{
		g.ajaxObject = new XMLHttpRequest();
	}

	else if(window.ActiveXObject)
	{ 
		g.ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var art = document.getElementsByTagName("article");
	var username = art[0].innerHTML;

	g.ajaxObject.open("POST", "JSONload.php", true);	
	g.ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	g.ajaxObject.onreadystatechange = functionSetUpUserStickyes;
	g.ajaxObject.send("username=" + username);	
}

//Assures that the entire document has been loaded before calling any functions
function init()
{}

window.onload = init;