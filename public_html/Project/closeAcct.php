<?php require_once(__DIR__ . "/../../partials/nav.php"); 
require_once(__DIR__ . "/../../lib/flash_messages.php");?>

<?php
//accounts incl. loans so that they can be closed
$accounts2 = getDropDownLoan();
?>

<h4>Close Out An Account</h4>
<form method="POST">
  <label>Please Select The Account You Would Like To Close</label>
  <select name="selected_acct">
            <?php foreach($accounts2 as $row):?>
                <option value="<?php echo $row["account_number"];?>"> 
                <?php echo $row["account_number"];?>
                </option>
            <?php endforeach;?>
         </select>
     <input type ="submit" name="save" value="Close Account"/>
</form>

<?php 
//value="<?php echo $result["balance"]
if(isset($_POST["save"])){ 




    $account = intval($_POST["selected_acct"]);
    $account_basics = $db->query("SELECT * FROM Accounts where `account_number` = $account");

    foreach ($account_basics as $row) {
        $acct_balance = $row['balance'];
        $acct_type = $row['account_type'];
    }

    ob_start();

    if ($acct_type == "Loan"){
        if ($acct_balance < 0){
            ob_clean();
            echo("The loan account you selected still has an outstanding balance.");
            echo("Please pay it off in full before trying to close the acccount.");
            
        }else{
            //set acct is_active to false 
            $false = "False";
            //set acct is_active to false 
            $query = "UPDATE Accounts set is_active = :false where account_number = :acct_selected";
            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":false" => $false ,
                ":acct_selected" => $account,
            ]);

            ob_clean();
            echo "Account closed successfully." ;
            
        }
    }else{

        if ($acct_balance > 0){
            ob_clean();
            echo("The account you selected still holds a balance.");
            echo("Please transfer all funds out of the account before trying to close it.");
            
        }else{
            $false = "False";
            //set acct is_active to false 
            $query = "UPDATE Accounts set is_active = :false where account_number = :acct_selected";
            $db = getDB();
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":false" => $false ,
                ":acct_selected" => $account,
            ]);

            ob_clean();
            echo "Account closed successfully." ;
            
            
        }

    }
}