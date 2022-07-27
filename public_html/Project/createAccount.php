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
    $memo = "new account creation";
    $db = getDB();

    $act_dest_id = intval($_SESSION['user']['id']);
    $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = '000000000000'");
    $results = $stmt->execute();
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $world_id = $r["id"];
    $account_src = intval($world_id);

    
  
    
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
      
      flash("Checking account successfully with reference id: " . $db->lastInsertId());

      $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_number");
      $results = $stmt->execute();
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $src_act = $r["id"];
      $account_dest = intval($src_act);

      doBankAction( $act_src_id , $act_dest_id, $balance, $action_type, $memo);


    }
    else{
      //$error = $stmt->errorInfo();
      flash("Error creating checking account. Please try again or contact your bank for further assistance.");
    }
}

   

?> 
<?php require(__DIR__ . "/../../partials/flash.php");