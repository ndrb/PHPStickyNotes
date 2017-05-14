<?php

require_once('PDOInterface.php');

//Implements the iPDO interface for database manipulation classes.
class PDOClass implements iPDO
{
	private $pdo;

	function __construct() 
	{
		$this->pdo = new PDO('mysql:dbname=keepr;host=localhost','root','');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
	}
	
	/*
	* Checks the database to see if a username has been taken or not,
	* usernames are unique and act the primary keys.
	* @return Boolean as to wether the username already exists
	*/
	public function checkNameAvail($username)
	{		
		try
		{
			$query = 'SELECT username FROM users WHERE username LIKE ?;';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->execute();
			$result = $stmt->fetchAll();
		}
		
	catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
      unset($stmt);
			
			if($result)
			{
				return false;
			}

			else
			{
				return true;
			}
    }
		
	}
	
	/*
	* Authenticates the user: the user can login with either
	* their username or email and their passwords.
	*/
  public function authentificate($username)
	{
		try
		{
			$query = 'SELECT password FROM users WHERE ((username LIKE ?) OR (email LIKE ?));';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $username);
			$stmt->execute();
			$result = $stmt->fetch(); 			
		}
		
		catch(PDOException $e)
    {
    	echo "Error working with the database: ".$e;
    }
        
    finally
    {
      unset($stmt);
			return $result[0];
    }		
	}
	
	/*
	* Brings back all the stiicky notes that are associated with the username provided.
	* @return A 2D array of sticky note information
	*/
	public function retreiveStickies($username)
	{
		try
		{
			$query = 'SELECT ident, title, subject, x, y, z FROM sticky WHERE username LIKE ?;';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->execute();
			$result = $stmt->fetchAll(); 			
		}
		
		catch(PDOException $e)
    {
        echo "Error working with the database: ".$e;
    }
        
    finally
    {
        unset($stmt);
        return $result;
    }		
	}
   
	/*
	* Creates a new user object with a their specified username, email
	* and a hashed wih bcrypt version of their password.
	*/
	public function createUser($username, $email, $password)
	{
		try
		{
			$query = 'INSERT INTO users(username, email, password) VALUES(?,?,?);';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $email);
			$stmt->bindParam(3, $password);
			$stmt->execute();
		}
		
		catch(PDOException $e)
    {
        echo "Error working with the database: ".$e;
    }
        
    finally
    {
        unset($stmt);
    }	
	}

	/*
	* Deletes the user with the given username that is sent in.
	*/
	public function deleteUser($username)
	{
		try
		{
			$query = 'DELETE FROM users WHERE username = ?;';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->execute();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
    }			
	}
	
	/*
	* Creates a new sticky note object in the database with all
	* the params sent in, each sticky note is associated with 
	* the username of the user that created it.
	*/	
	public function createNewSticky($username, $title, $subject, $x, $y, $z)
	{
		try
		{
			$query = 'INSERT INTO sticky(username, title, subject, x, y, z) VALUES(?,?,?,?,?,?);';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $title);
			$stmt->bindParam(3, $subject);
			$stmt->bindParam(4, $x);
			$stmt->bindParam(5, $y);
			$stmt->bindParam(6, $z);
			$stmt->execute();
		}
		
	catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
		unset($stmt);
		return $this->pdo;
    }
	}
	
	/*
	* Deletes a sticky note by unique id.
	*/	
	public function deleteSticky($id)
	{
		try
		{
			$query = 'DELETE FROM sticky WHERE ident = ?;';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $id);
			$stmt->execute();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
    }				
	}

	/*
	* When the text of a sticky note (either it's title or subjec fields)
	* is changed this method is used to update the database with the new values.
	*/	
	public function modifyStickyTxt($ident, $title, $subject)
	{
		try
		{
			$query = 'UPDATE sticky SET title=?, subject=? WHERE ident = ?;';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $title);
			$stmt->bindParam(2, $subject);
			$stmt->bindParam(3, $ident);
			$stmt->execute();
		}
		
		catch(PDOException $e)
		{
			echo "Error working with the database: ".$e;
		}
        
		finally
		{
			unset($stmt);
		}		
	}

	/*
	* When the position of a sticky note (either it's x, y, or z fields)
	* is changed this method is used to update the database with the new values.
	*/	
	public function	modifyStickyDragg($ident, $x, $y, $z)
	{
		try
		{
			$query = 'INSERT INTO sticky(x, y, z) VALUES(?,?,?,) WHERE ident = ?;';
			$query = 'UPDATE sticky SET x=?, y=?, z=? WHERE ident = ?;';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $x);
			$stmt->bindParam(2, $y);
			$stmt->bindParam(3, $z);
			$stmt->bindParam(4, $ident);
			$stmt->execute();
		}
		
		catch(PDOException $e)
		{
			echo "Error working with the database: ".$e;
		}
        
		finally
		{
			unset($stmt);
		}		
	}
	
	/*
	* If it is not the user's first unsuccessfully attempt at logging-in
	* this function will update the database with the new total
	* number of tries and the timestamp.
	*/	
	public function updateAuthentification($username, $try, $latest)
	{
		try
		{
			$query = 'UPDATE authentification SET username=?, try=?, latest=? WHERE username=?';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $try);
			$stmt->bindParam(3, $latest);
			$stmt->bindParam(4, $username);
			$stmt->execute();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
    }				
	}
	
	/*
	* If the user tried to unsuccessfully log-in for the first time
	* this function will create a record of that unsuccessfully login
	* so that the user can be tracked further.
	*/
	public function createAuthentification($username, $try, $latest)
	{		
		try
		{
			$query = 'INSERT INTO authentification(username, try, latest) VALUES(?,?,?)';
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $try);
			$stmt->bindParam(3, $latest);
			$stmt->execute();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
    }				
	}
	
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
	public function userEmailCompromise($username)
	{
		try
		{
			$query = 'SELECT username, email FROM users WHERE ((username = ?) OR (email = ?));';
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $username);
			$stmt->execute();
			
			$result = $stmt->fetch();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {		
			unset($stmt);
			return $result;
    }			
	}
	
	/*
	* Checks if the user has already tried to unsuccessfully
	* log-in; the info is then used to determine if another chance
	* is to be given or wether to lock the account.
	* @return username, number of tries, timestamp of last attempt
	*/
	public function peekAuthentification($username, $email)
	{
		try
		{
			$query = 'SELECT username, try, latest FROM authentification WHERE ((username = ?) OR (username = ?));';
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $email);
			$stmt->execute();
			
			$result = $stmt->fetch();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
			return $result;
    }				
	}
	
	/*
	* Returns the number of times the user has tried to
	* unsuccessfully log-in.
	* @return int Number of tries
	*/	
	public function getTry($username)
	{
		try
		{
			$query = 'SELECT try FROM authentification WHERE username = ?';
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->execute();
			
			$result = $stmt->fetch();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
			return $result[0];
    }				
	}
	
	/*
	* If a user has been locked out, and the lockout 
	* time has elapsed this will delete the trace of the
	* lockout and allow the user to once again try to log in.
	*/	
	public function userBanLifted($username)
	{
		try
		{
			$query = 'DELETE FROM authentification WHERE username = ?';
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(1, $username);
			$stmt->execute();
		}
		
		catch(PDOException $e)
    {
      echo "Error working with the database: ".$e;
    }
        
    finally
    {
			unset($stmt);
    }		
	}

}

?>