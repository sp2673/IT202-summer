<?php require_once(__DIR__ . "/../../partials/nav.php"); 
require_once(__DIR__ . "/logTransaction.php") ?>

<h4>Take a Loan out</h4>

<?php 
$db = getDB();
 $get_apy_stmt=$db->prepare("SELECT `APY` FROM `System Properties` WHERE id = '1'");
 $results = $get_apy_stmt->execute();
 $apy_results = $get_apy_stmt->fetch(PDO::FETCH_ASSOC);
 $apy = $apy_results["APY"];

 echo "Current APY Rate for Loans: " . $apy."%";
 $accounts = getDropDown();
?>

<br><br><form method="POST">
  <label> Account Number (Auto Generated) </label>
  <br><label>Account Type</label>
  <select name="account_type">
    <option value = "Loan">Loan</option>
  </select>
  <br><label>Amount</label>
  <input type="number" min="500.00" name="amount" ;?>
  <label><br>Select Destination Account</label placeholder="0">
            <select name="transfer_destination">
            <?php foreach($accounts as $row):?>
                <option value="<?php echo $row["account_number"];?>"> 
                <?php echo $row["account_number"];?>
                </option>
            <?php endforeach;?>
            </select>
    <label><br>Memo</label> 
    <input type="text" name="memo"><br>
  <br><input type="submit" name="save" value="Get Loan" ;?>
</form>

<?php 
//value="<?php echo $result["balance"]
if(isset($_POST["save"])){ 
  $account_type = $_POST["account_type"];

  if ($account_type == "Loan"){
      
          $account_number = random_int(100000000000,999999999999);
          
          $user= get_user_id();
          $memo = "New Account Creation" ;
          $db = getDB();
    
          $get_apy_stmt=$db->prepare("SELECT APY FROM `System Properties` WHERE id = '1'");
          $results = $get_apy_stmt->execute();
          $apy_results = $get_apy_stmt->fetch(PDO::FETCH_ASSOC);
          $apy = $apy_results["APY"];
          //calculating a basic form of interest
          $amount = $_POST["amount"];
          $amount = $amount + ($amount * ($apy/100));
          
          $account_destination = $_POST["transfer_destination"];

          
          $action_type = "Deposit";

          $stmt = $db->prepare("INSERT INTO Accounts (`account_number`, `account_type`, `user_id`, `balance`, `apy`) VALUES(:account_number, :account_type, :user, :balance, :apy)");
          $success = $stmt->execute([
              ":account_number" => $account_number,
              ":account_type"=> $account_type,
              ":user" => $user,
              ":balance" => -1*$amount,
              ":apy" => $apy 
          ])
          ;

          $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_number");
          $results = $stmt->execute();
          $r = $stmt->fetch(PDO::FETCH_ASSOC);
          $world_id = $r["id"];
          $act_src_id = intval($world_id);

          $get_destination_id=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_destination ");
          $id_from_destination_acct_numb = $get_destination_id->execute();
          $h = $get_destination_id->fetch(PDO::FETCH_ASSOC);
          $act_dest_id = intval($h["id"]);
            
    
          
            

           
          }
          else{
            $error = $stmt->errorInfo();
            flash("There was an error taking out the loan. Please contact your bank.");
          }
  } 


        


   

?> 
<?php require(__DIR__ . "/../../partials/flash.php");