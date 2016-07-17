<?php

    // configuration
    require("../includes/config.php"); 
    $rows = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    $cash = $rows[0]["cash"];
    
     $rows = query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]);
     $positions = [];
     foreach($rows as $row)
     {
         $stock = lookup($row["symbol"]);
         if( $stock !== false)
         {
              $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"],
                "total" => ($stock["price"] * $row["shares"])
            ];
         }
     }
    // render portfolio
    render("portfolio.php", ["title" => "Portfolio"]);

?>
