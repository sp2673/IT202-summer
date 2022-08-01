<?php require_once(__DIR__ . "/../../partials/nav.php");

require_once(__DIR__ . "/../../lib/flash_messages.php");?>

<?php
if (!is_logged_in()){
    flash("you need to be logged in to access this page");
    die(header("Location: login.php"));
}
?>
<?php
$accounts = getDropDown();
?>

<h3>Make An External Transfer</h3> 
    <form method="POST">      

        <label>Select Source Account</label placeholder="0">
            <select name="transfer_origin">
            <?php foreach($accounts as $row):?>
                <option value="<?php echo $row["account_number"];?>"> 
                <?php echo $row["account_number"];?>
                </option>
            <?php endforeach;?>
            </select>
         <label><br>Enter Destination Account's Last 4 digits </label placeholder="0">
         <input type="number" min="1000" max="9999" name="last4digits">

         <label><br>Enter Last Name of Destination Account Holder</label placeholder="0">
         <input type="text" name="dest_last_name">
        
        <label><br>Amount</label> 
        <input type="number" min="1.00" name="amount">
        
        <label><br>Memo</label>
        <input type="text" name="memo"><br>

        <input type ="submit" name="save" value="Perform External Transfer"/>
    </form> 


    <?php
    if(isset($_POST["save"])){

        //$account_type = $_POST["account_type"];
        $account_origin = intval($_POST["transfer_origin"]); //transfer origin

        $last4digits = $_POST["last4digits"];
        $dest_last_name = $_POST["dest_last_name"];

        $get_destination_acct=$db->prepare("SELECT account_number FROM Accounts b JOIN Users u on u.id = b.user_id WHERE u.last_name = :last_name AND b.account_number LIKE  :account_number LIMIT 1");
        $success = $get_destination_acct->execute([
            ":last_name"=>$dest_last_name,
            ":account_number"=>"%$last4digits", 
        ]);

        if ($success){
            $h = $get_destination_acct->fetch(PDO::FETCH_ASSOC);
            $account_destination_numb = intval($h["account_number"]);
        }
        echo var_dump($h);
        
         //Add a query for the transfer destination acct # 

        $amount = $_POST["amount"];
        $action = "Transfer";
        $memo = $_POST["memo"];
        $user = get_user_id();
        $db = getDB();
        
        
        $get_origin_id=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_origin ");
        $id_from_origin_acct_numb = $get_origin_id->execute();
        $w = $get_origin_id->fetch(PDO::FETCH_ASSOC);
        $acct_origin_id = intval($w["id"]);

        $get_destination_id=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_destination_numb ");
        $id_from_destination_acct_numb = $get_destination_id->execute();
        $y = $get_destination_id->fetch(PDO::FETCH_ASSOC);
        $acct_destination_id = intval($y["id"]);
        echo ("This is the dest acct id #: " . $acct_destination_id. "  <= id ends here");

        $check_origin_balance=$db->prepare("SELECT balance FROM Accounts WHERE account_number = $account_origin ");
        $result_balance= $check_origin_balance->execute();
        $q = $check_origin_balance->fetch(PDO::FETCH_ASSOC);
        $account_origin_balance = intval($q["balance"]);
        
        //insufficient balance check
        if($amount > $account_origin_balance){
            flash("You do not have enough balance in your source account to perform this transfer. Please choose a lower balance.");
        
        
        //if there is a issue with the query and it comes back empty or with the world acct somehow
        }else if ($acct_destination_id == 1 || !$h){
        
            flash("Please check the last name of the account holder and the last 4 digits of the account you entered and try again.");
            
        //if all is good then it executes the transaction. 
        }else{
        doBankAction($acct_origin_id, $acct_destination_id, $amount , $action, $memo);
        }
        
    }
          
    
   


?>
<?php require(__DIR__ . "/../../partials/flash.php");