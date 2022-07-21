<?php require_once(__DIR__ . "/../../partials/nav.php");  ?>

<form method="POST">
  <label> List All of Your Accounts </label>
  
  <input type="submit" name="save" value="List Accounts" ;?>
</form>
<?php
if(isset($_POST["save"])){
    
    $user= intval($_SESSION['user']['id']);;
    $db = getDB();

    $statement = $db ->query("SELECT * FROM Accounts order by id DESC limit 5 ");
    echo "<table border=2 width=50% height = 50%>";
    echo "<tr><th>Account Name</th><th>Account Type</th><th>Last Updated</th><th>Balance</th></tr>";
    foreach ($statement as $row) {
        $account_number = $row['account_number'];
        $account_type = $row['account_type'];
        $modified = $row['modified'];
        $balance = $row['balance'];
        
        echo"<tr>";
        
        echo "<td>$account_number</td>"; echo "<td>$account_type</td>"; echo "<td>$modified </td>"; echo "<td>$balance </td>";
        echo "</tr>";
    }

    echo "</table>";


}
?>