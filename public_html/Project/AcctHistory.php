<?php require_once(__DIR__ . "/../../partials/nav.php");  ?>

<?php 
//echo "TESTING";
//echo ($_GET['account']) ;

$db = getDB();
$account = $_GET['account'];

$account_basics = $db->query("SELECT * FROM Accounts where account_number = $account");

echo "<table border=2 width=50% height = 20%>";
    echo "<tr><th>Account Number</th><th>Account Type</th><th>Balance</th><th>Acct Opened</th></tr>";
    foreach ($account_basics as $row) {
        $act_numb = $row['account_number'];
        $act_type = $row['account_type'];
        $balance = $row['balance'];
        $created = $row['created'];
        
        echo"<tr>";
        
        echo "<td>$act_numb</td>"; echo "<td>$act_type </td>"; echo "<td>$balance</td>";echo "<td>$created</td>";
        echo "</tr>";
    }

    echo "</table>";

$account_id = $db->query("SELECT user_id FROM Accounts where account_number = $account ");
$temp = $account_id->fetch();
$account_number = intval($temp["user_id"]);

echo "  <br> <br> " ;

    $statement = $db ->query("SELECT * FROM Transactions where account_src = $account_number or account_dest = $account_number order by id DESC limit 10 ");
    echo "<table border=2 width=50% height = 50%>";
    echo "<tr><th>Source Acct</th><th>Destination Acct</th><th>Transaction Type</th><th>Change in Balance</th><th>Occurrence</th><th>Expected Total</th><th>Memo</th></tr>";
    foreach ($statement as $row) {
        $account_src = $row['account_src'];
        $account_dest = $row['account_src'];
        $transaction_type = $row['transaction_type'];
        $balance = $row['amount'];
        $created = $row['created'];
        $expected_total = $row["expected_total"];
        $memo = $row["memo"];
        
        echo"<tr>";
        
        echo "<td>$account_src</td>"; echo "<td>$account_dest </td>"; echo "<td>$transaction_type</td>"; echo "<td>$balance</td>";echo "<td>$created</td>";echo "<td>$expected_total</td>";echo "<td>$memo</td>";
        echo "</tr>";
    }

    echo "</table>";

    ?>