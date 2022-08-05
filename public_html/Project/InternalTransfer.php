<?php require_once(__DIR__ . "/../../partials/nav.php"); 

require_once(__DIR__ . "/../../lib/flash_messages.php");?>

<?php
if(!is_logged_in()){
    flash("You need to be logged in to access this page");
    die(header("Location: login.php"));
}
?>
<?php
$accounts = getDropDown();
$accounts = getDropDownLoan();
?>


    <h3>Make An Internal Transfer</h3> 
    <form method="POST">      

        <label>Select Source Account</label placeholder="0">
            <select name="transfer_origin">
            <?php foreach($accounts as $row):?>
                <option value="<?php echo $row["account_number"];?>"> 
                <?php echo $row["account_number"];?>
                </option>
            <?php endforeach;?>
            </select>
         <label>Select Destination Account</label placeholder="0">
            <select name="transfer_destination">
            <?php foreach($accounts2 as $row2):?>
                <option value="<?php echo $row2["account_number"];?>"> 
                <?php echo $row2["account_number"];?>
                </option>
            <?php endforeach;?>
            </select>
        
        <label><br>Amount</label> 
        <input type="number" min="1.00" name="amount">
        

        <label>Memo</label> 
        <input type="text" name="memo">

        <input type ="submit" name="save" value="Perform Internal Transfer"/>
    </form> 


    <?php
    if(isset($_POST["save"])){

        //$account_type = $_POST["account_type"];
        $account_origin = intval($_POST["transfer_origin"]); //transfer origin
        $account_destination = intval($_POST["transfer_destination"]); //transfer destination
       
        $amount = $_POST["amount"];
        $action = "Transfer";
        $memo = $_POST["memo"];
        $user = get_user_id();
        $db = getDB();
        
        
        $get_origin_id=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_origin ");
        $id_from_origin_acct_numb = $get_origin_id->execute();
        $w = $get_origin_id->fetch(PDO::FETCH_ASSOC);
        $acct_origin_id = intval($w["id"]);

        $get_destination_id=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_destination ");
        $id_from_destination_acct_numb = $get_destination_id->execute();
        $h = $get_destination_id->fetch(PDO::FETCH_ASSOC);
        $acct_destination_id = intval($h["id"]);


        $check_origin_balance=$db->prepare("SELECT balance FROM Accounts WHERE account_number = $account_origin ");
        $result_balance= $check_origin_balance->execute();
        $q = $check_origin_balance->fetch(PDO::FETCH_ASSOC);
        $account_origin_balance = intval($q["balance"]);
        

        if($amount > $account_origin_balance){
            flash("You do not have enough balance in your source account to perform this transfer. Please choose a lower balance.");
        
        
        
        }else{
        
            doBankAction($acct_origin_id, $acct_destination_id, $amount , $action, $memo);
            
        }
    }
          
    
   


?>
<?php require(__DIR__ . "/../../partials/flash.php");