<? php

require("../includes/config.php")

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $transaction = "SELL";
    
    $stock = lookup($_POST["symbol"]);
    
     $shares = CS50::query("SELECT shares FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
     $value = $stock["price"]*$shares[0]["shares"];
     
     CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $value, $_SESSION["id"]);
     CS50::query("INSERT INTO history (id, transaction, symbol, shares, price) VALUES (?, ?, ?, ?, ?)", $_SESSION["id"], $transaction, $_POST["symbol"], $shares[0]["shares"], $stock["price"]);
     
        redirect("/");
    }
    
    // if form hasn't been submitted
    else
    {
        // query user's portfolio
        $rows =	CS50::query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]);	
        // create new array to store stock symbols
        $stocks = [];
        // for each of user's stocks
        foreach ($rows as $row)	
        {   
            // save stock symbol
            $stock = $row["symbol"];
            
            // add stock symbol to the new array
            $stocks[] = $stock;       
        }    
        // render sell form
        render("sell_form.php", ["title" => "Sell Form", "stocks" => $stocks]);
    }
      
?>
