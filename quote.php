<?php

require("../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST["symbol"]))
    {
        apologize("You must enter a symbol.");
    }
    
    else
    {
        $stock = lookup($_POST["symbol"]);
        if($stock === false)
        {
            apologize("You must enter a valid symbol.");
        }
        else
        {
            render("quotes_show.php",["title" => "Quotes"]);
        }
    }
    
}

else 
    render("quotes_in.php",["title" => "Quotes"]);
    
?>