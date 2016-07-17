<? php

require("../includes/config.php")

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST["symbol"]) || empty($_POST["shares"]))
    {
        apologize("You must enter a symbol and quantity.");
    }
    
    if(lookup($_POST["symbol"]) == false)
    {
        apologize("You have entered an invalid symbol.")
    }
    if(preg_match("/^\d+$/", $_POST["shares"]) == false)
    {
        apologize("You must enter a positive, whole number.");
    }
    
    $transaction = "BUY";
    
    $cost = $stock["price"]*$_POST["shares"];
    
    $cash = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    
    if($cash < $cost)
    {
        apologize("You do not have enough money for this purchase.");
    }
    else
    {
        $_POST["symbol"] = strtoupper($_POST["symbol"]);
        CS50::query("INSERT INTO portfolio (id, symbol, shares) VALUES(?, ?, ?) 
                ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $_POST["symbol"], $_POST["shares"]);
                CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $cost, $_SESSION["id"]);
                CS50::query("INSERT INTO history (id, transaction, symbol, shares, price) VALUES (?, ?, ?, ?, ?)", $_SESSION["id"], $transaction, $_POST["symbol"], $_POST["shares"], $stock["price"]);
                
                redirect("/");
    }
}

else 
{
        render("buy_form.php", ["title" => "Buy Form"] );
}

?>