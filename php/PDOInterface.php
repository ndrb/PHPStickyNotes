<?php

//Interface for database manipulation methods.
interface iPDO
{
	/*
	* Checks the database to see if a username has been taken or not,
	* usernames are unique and act the primary keys.
	* @return Boolean as to wether the username already exists
	*/
	public function checkNameAvail($username);

	/*
	* Authenticates the user: the user can login with either
	* their username or email and their passwords.
	*/
	public function authentificate($username);

	/*
	* Brings back all the stiicky notes that are associated with the username provided.
	* @return A 2D array of sticky note information
	*/
	public function retreiveStickies($username);

	/*
	* Creates a new user object with a their specified username, email
	* and a hashed wih bcrypt version of their password.
	*/
	public function createUser($username, $email, $password);
   
	/*
	* Deletes the user with the given username that is sent in.
	*/
	public function deleteUser($username);
	
	/*
	* Creates a new sticky note object in the database with all
	* the params sent in, each sticky note is associated with 
	* the username of the user that created it.
	*/	
	public function createNewSticky($username, $title, $subject, $x, $y, $zi);
	
	/*
	* Deletes a sticky note by unique id.
	*/	
	public function deleteSticky($id);
	
	/*
	* When the text of a sticky note (either it's title or subjec fields)
	* is changed this method is used to update the database with the new values.
	*/	
	public function modifyStickyTxt($id, $title, $subject);
	
	/*
	* When the position of a sticky note (either it's x, y, or z fields)
	* is changed this method is used to update the database with the new values.
	*/	
	public function modifyStickyDragg($id, $x, $y, $zi);
	
	/*
	* If it is not the user's first unsuccessfully attempt at logging-in
	* this function will update the database with the new total
	* number of tries and the timestamp.
	*/	
	public function updateAuthentification($username, $try, $latest);
	
	/*
	* If the user tried to unsuccessfully log-in for the first time
	* this function will create a record of that unsuccessfully login
	* so that the user can be tracked further.
	*/	
	public function createAuthentification($username, $try, $latest);
	
	/*
	* Given whatever is in the 'username' login field
	* this method will use that to find if what is provided
	* is a username or email, and if it is a username
	* it will return the email associated with it and vice-versa.
	* This is to permit users to log-in with either their
	* usernames or their emails and they don't have to specify wich
	* they are entering. Once we have both fields we can have a more
	* general search in the database. 
	* (Used in conjunction with the 'userEmailCompromise($username)' function)
	* @return username and email associated 
	*/	
	public function userEmailCompromise($username);
	
	/*
	* Checks if the user has already tried to unsuccessfully
	* log-in; the info is then used to determine if another chance
	* is to be given or wether to lock the account.
	* @return username, number of tries, timestamp of last attempt
	*/
	public function peekAuthentification($username, $email);
	
	/*
	* Returns the number of times the user has tried to
	* unsuccessfully log-in.
	* @return int Number of tries
	*/	
	public function getTry($username);
	
	/*
	* If a user has been locked out, and the lockout 
	* time has elapsed this will delete the trace of the
	* lockout and allow the user to once again try to log in.
	*/	
	public function userBanLifted($username);
}

?>