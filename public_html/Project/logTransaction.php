<?php 



function logTransaction($balance, $transaction_type, $account_src, $account_dest, $memo = "")
{
    //I'm choosing to ignore the record of 0 point transactions
    $db = getDB();
        if ($balance > 0) {
          $query = "INSERT INTO Transactions (account_src, account_dest, amount, balance_change, memo, expected_total) 
              VALUES (:acs1, :acd1, :pc, :r,:m, :t), 
              (:acs2, :acd2, :pc2, :r, :m, :t)";
         
          $params[":acs1"] = $account_dest;
          $params[":acd1"] = $account_src;
          $params[":r"] = $transaction_type;
          $params[":m"] = $memo;
          $params[":pc"] = ($balance * -1);
          $params[":t"] = ($balance * -1);
  
          $params[":acs2"] = $account_src;
          $params[":acd2"] = $account_dest;
          $params[":pc2"] = $balance;
          $params[":t"] = $balance;
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