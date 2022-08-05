<?php require_once(__DIR__ . "/../../partials/nav.php");  ?>

<form method="POST">
  <label> List All of Your Accounts </label>
  
  <input type="submit" name="save" value="List Accounts" ;?>
</form>
<?php
if(isset($_POST["save"])){
    
    $user= intval($_SESSION['user']['id']);;
    $db = getDB();

    $statement = $db ->query("SELECT * FROM Accounts where user_id = $user order by id DESC limit 5 ");
    echo "<table border=2 width=50% height = 50%>";
    echo "<tr><th>Account Name</th><th>Account Type</th><th>Last Updated</th><th>Balance</th><th>APY</th></tr>";
    foreach ($statement as $row) {
        $account_number = $row['account_number'];
        $account_type = $row['account_type'];
        $modified = $row['modified'];
        if ($account_type == "Loan"){
          $balance = -1* $row['balance']. ".00";
        }else{
          $balance = $row['balance'];
        }
        $apy = $row["APY"];

        if($apy == 0.00){
            $apy = "-";
        }       
        echo"<tr>";
        
        echo "<td><a href='account_history.php?account=$account_number'>$account_number</a></td>"; echo "<td>$account_type</td>"; echo "<td>$last_updated </td>"; echo "<td>$balance </td>"; echo "<td>$apy</td>";
        echo "</tr>";
    }

    echo "</table>";


}
?>