<?php
    // configuration
    require("../includes/config.php"); 
	
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	if(empty($_POST["password"]) || empty($_POST["confirmation"]) ||$_POST["password"] != $_POST["confirmation"])
    	{
		    // validate submission
		    if (empty($_POST["password"]))
		    {
		        apologize("You must provide a new password.");
		    }
		    else if (empty($_POST["confirmation"]))
		    {
		        apologize("You must confirm your password.");
		    }
		    else if($_POST["password"] != $_POST["confirmation"])
			{
				apologize("Password doesn't equal the confirmation");
			}
		}else
		{
			// create new encrypted password
			$hash = crypt($_POST["password"]);
			$id = $_SESSION["id"];
			
			// update the account to the new password
			CS50::query("UPDATE users SET hash='$hash' WHERE id=$id"); 
			render("password.php");
		}
	}else
	{
		render("change_password.php", ["title" => "Password"]);
	}
?>