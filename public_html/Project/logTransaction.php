<?php 
require_once(__DIR__ . "/refreshBalance.php");


function logTransaction($balance, $transaction_type, $account_src = -1, $account_dest=-1, $memo = "")
{
    //I'm choosing to ignore the record of 0 point transactions
    $db = getDB();
        if ($balance > 0) {
          $query = "INSERT INTO Transactions (account_src, account_dest, amount, balance_change, memo) 
              VALUES (:acs1, :acd1, :pc, :r,:m), 
              (:acs2, :acd2, :pc2, :r, :m)";
         
          $params[":acs1"] = $account_src;
          $params[":acd1"] = $account_dest;
          $params[":r"] = $transaction_type;
          $params[":m"] = $memo;
          $params[":pc"] = ($balance * -1);
  
          $params[":acs2"] = $account_dest;
          $params[":acd2"] = $account_src;
          $params[":pc2"] = $balance;
          $db = getDB();
          $stmt = $db->prepare($query);
        try {
            $stmt->execute($params);
            
            if ($account_src == intval($_SESSION['user']['id']) || $account_dest == intval($_SESSION['user']['id'])) {
                refreshBalance();
            }
        } catch (PDOException $e) {
            error_log(var_export($e->errorInfo, true));
            flash("There was an recording the transfer! Please contact your bank!", "danger");
        }
    }
    }

?>