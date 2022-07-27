<?php require_once(__DIR__ . "/../../partials/nav.php"); 
require_once(__DIR__ . "/logTransaction.php")?>


<form method="POST">
  <label> Account Number (Auto-Generated) </label>
  <label>Account Type</label>
  <select name="account_type">
    <option value = "checking">Checking</option>
  </select>
  <label>Balance</label>
  <input type="number" min="5.00" name="balance" ;?>
  <input type="submit" name="save" value="Create" ;?>
</form>

<?php 
//value="<?php echo $result["balance"]
if(isset($_POST["save"])){
  //DB will check for duplicates and throw a duplicate record exception if it is found
    $account_number = random_int(100000000000,999999999999);
    $account_type = "Checking"; 
    $user= get_user_id();
    $balance = $_POST["balance"];
    $db = getDB();

    $act_dest_id = intval($_SESSION['user']['id']);
    
    $action_type = "Deposit";

    $stmt = $db->prepare("INSERT INTO Accounts (account_number, account_type, user_id, balance) VALUES(:account_number, :account_type, :user, :balance)");
    $success = $stmt->execute([
        ":account_number" => $account_number,
        ":account_type"=> $account_type,
        ":user" => $user,
        ":balance" => $balance
     ])
    ;
    
    

    

    if($success){
      flash("Created successfully with id: " . $db->lastInsertId());

      logTransaction($balance, $transaction_type, $account_src = -1, $account_dest, $memo="new Account created");


    }
    else{
      //$error = $stmt->errorInfo();
      flash("Error creating checking account. Please try again or contact your bank for further assistance.");
    }
}

   

?> 
<?php require(__DIR__ . "/../../partials/flash.php");