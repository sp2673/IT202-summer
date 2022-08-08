<?php require_once(__DIR__ . "/../../partials/nav.php"); 
require_once(__DIR__ . "/logTransaction.php")?>


<form method="POST">
  <label> Account Number (Auto-Generated) </label>
  <label>Account Type</label>
  <select name="account_type">
    <option value = "Checking">Checking</option>
    <option value = "Savings">Savings</option>
  </select>
  <label>Balance</label>
  <input type="number" min="5.00" name="balance" ;?>
  <input type="submit" name="save" value="Create" ;?>
</form>

<?php 
//value="<?php echo $result["balance"]
if(isset($_POST["save"])){ 
  $account_type = $_POST["account_type"];

  if ($account_type == "Checking"){
        //DB checks for duplicate accounts when entry is inserted and throws duplicate record exception which sould be 
        //easily remedied by the user trying again as the chances of having two matching random numbers twice in a row is incredibly low
          $account_number = random_int(100000000000,999999999999);
          
          $user= get_user_id();
          $balance = $_POST["balance"];
          $memo = "New Account Creation" ;
          $db = getDB();

          $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = '000000000000'");
          $results = $stmt->execute();
          $r = $stmt->fetch(PDO::FETCH_ASSOC);
          $world_id = $r["id"];
          $act_src_id = intval($world_id);

          
          
          $action_type = "Deposit";

          $stmt = $db->prepare("INSERT INTO Accounts (`account_number`, `account_type`, `user_id`, `balance`) VALUES(:account_number, :account_type, :user, :balance)");
          $success = $stmt->execute([
              ":account_number" => $account_number,
              ":account_type"=> $account_type,
              ":user" => $user,
              ":balance" => $balance
          ])
          ;
          
          

          if($success){
            flash("Checking account created successfully with reference id: " . $db->lastInsertId());

            $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_number");
            $results = $stmt->execute();
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $src_act = $r["id"];
            $act_dest_id = intval($src_act);
            

          doBankAction( $act_src_id , $act_dest_id, $balance, $action_type, $memo);

          header("refresh:2;url=listAccount.php?user=$user");
          
          }
          else{
            $error = $stmt->errorInfo();
            flash("Error creating account. Please try again or contact your bank for further assistance.");
          }
          
  } else if ($account_type == "Savings"){  //sp2673 08/05/2022
            
        $account_number = random_int(100000000000,999999999999);
          
        $user= get_user_id();
        $balance = $_POST["balance"];
        $memo = "New Account Creation" ;
        $db = getDB();

        $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = '000000000000'");
        $results = $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        $world_id = $r["id"];
        $act_src_id = intval($world_id);

        $get_apy_stmt=$db->prepare("SELECT APY FROM `System Properties` WHERE id = '1'");
        $results = $get_apy_stmt->execute();
        $apy_results = $get_apy_stmt->fetch(PDO::FETCH_ASSOC);
        $apy = $apy_results["APY"];

        
        
        $action_type = "Deposit";

        $stmt = $db->prepare("INSERT INTO Accounts (`account_number`, `account_type`, `user_id`, `balance`, `APY`) VALUES(:account_number, :account_type, :user, :balance, :APY)");
        $success = $stmt->execute([
            ":account_number" => $account_number,
            ":account_type"=> $account_type,
            ":user" => $user,
            ":balance" => $balance,
            ":APY" => $apy
        ])
        ;
        
        

        if($success){
          flash("Savings account created successfully with reference id: " . $db->lastInsertId());

          $stmt=$db->prepare("SELECT id FROM Accounts WHERE account_number = $account_number");
          $results = $stmt->execute();
          $r = $stmt->fetch(PDO::FETCH_ASSOC);
          $src_act = $r["id"];
          $act_dest_id = intval($src_act);
          

      
          doBankAction( $act_src_id , $act_dest_id, $balance, $action_type, $memo);
          header("refresh:2;url=ListAccount.php?user=$user");
         
        }
        else{
          $error = $stmt->errorInfo();
          flash("Error creating account. Please try again or contact your bank for further assistance.");
        }



        }
}

   

?> 
<?php require(__DIR__ . "/../../partials/flash.php");