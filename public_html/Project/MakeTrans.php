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
?>


    <h3>Create Transaction</h3> 
    <form method="POST">      

        <label>Select Account</label placeholder="0">
            <select name="acct_id">
            <?php foreach($accounts as $row):?>
                <option value="<?php echo $row["account_number"];?>"> 
                <?php echo $row["account_number"];?>
                </option>
            <?php endforeach;?>
            </select>
        
        <label>Amount</label> 
        <input type="number" min="1.00" name="amount">
        <label>Action</label> 
        <select name="action" placeholder="withdraw">
            <option value ="Deposit">Deposit</option>
            <option value ="Withdrawal">Withdraw</option>
        </select>

        <label>Memo</label> 
        <input type="text" name="memo">

        <input type ="submit" name="save" value="Perform Transaction"/>
    </form> 


<?php
    if(isset($_POST["save"])){

        //$account_type = $_POST["account_type"];
        $account_selected = intval($_POST["acct_id"]); //acct that we need to do the trans with
       
        $amount = $_POST["amount"];
        $action  = $_POST["action"];// Withdrawal or Deposit
        $memo = $_POST["memo"];
        $user = get_user_id();
        $db = getDB();
        
        $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = '000000000000'");
        $results = $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        $world_id = $r["id"];

        $get_acct_id=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_selected ");
        $id_from_acct_numb = $get_acct_id->execute();
        $w = $get_acct_id->fetch(PDO::FETCH_ASSOC);
        $acct_selected_id = intval($w["id"]);


        $check_balance=$db->prepare("SELECT balance FROM Accounts WHERE account_number = $account_selected ");
        $result_balance= $check_balance->execute();
        $q = $check_balance->fetch(PDO::FETCH_ASSOC);
        $account_selected_balance = intval($q["balance"]);
        

        if($amount > $account_selected_balance && $action == "Withdrawal"){
            flash("You do not have enough balance to perform this withdrawal. Please choose a lower balance.");
        
        
        
        }else{
        switch($action){
            case "Deposit":
                doBankAction($world_id, $acct_selected_id, $amount , $action, $memo);
            break;
            case "Withdrawal":
                doBankAction($acct_selected_id, $world_id, $amount, $action, $memo);
            break;
            
        }
    }
          
    }
   


?>
<?php require(__DIR__ . "/../../partials/flash.php");