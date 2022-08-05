<?php

/**
 * Passing $redirect as true will auto redirect a logged out user to the $destination.
 * The destination defaults to login.php
 */
function is_logged_in($redirect = false, $destination = "login.php")
{
    $isLoggedIn = isset($_SESSION["user"]);
    if ($redirect && !$isLoggedIn) {
        //if this triggers, the calling script won't receive a reply since die()/exit() terminates it
        flash("You must be logged in to view this page", "warning");
        die(header("Location: $destination"));
    }
    return $isLoggedIn;
}
function has_role($role)
{
    if (is_logged_in() && isset($_SESSION["user"]["roles"])) {
        foreach ($_SESSION["user"]["roles"] as $r) {
            if ($r["name"] === $role) {
                return true;
            }
        }
    }
    return false;
}
function get_username()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "username", "", false);
    }
    return "";
}
function get_user_email()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "email", "", false);
    }
    return "";
}
function get_user_id()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "id", false, false);
    }
    return false;
}
function getDropDown(){
    $user = get_user_id();
    $db = getDB();
    
    $stmt = $db->prepare("SELECT id, account_number FROM Accounts WHERE user_id = :id  and not account_type = 'Loan' and not is_active = 'False'");
    $r = $stmt->execute([
        ":id"=>$user
    ]);  

    if($r){
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results; 
    }
    else{
     flash("There was a problem fetching the accounts. Please try again.");
    }

}

function getDropDownLoan(){
    $user = get_user_id();
    $db = getDB();
    $stmt = $db->prepare("SELECT id, account_number FROM `Bank Accounts` WHERE `user_id` = :id and not is_active = 'False'");

    $r = $stmt->execute([
        ":id"=>$user
    ]);  

    if($r){
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results; 
    }
    else{
     flash("There was a problem fetching the accounts. Please try again.");
    }

}

//acct1 = src acct and acct2 = dest acct
function doBankAction($acc1, $acc2, $balance_change, $transaction_total, $memo='')
{
    $db = getDB();
    $user = get_user_id();
    

    $stmt = $db ->prepare("SELECT IFNULL(SUM(balance_change),0) AS expected_total FROM Transactions WHERE account_dest = :id");
            $r = $stmt->execute([
                ":id" => $acc1
            ]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $source_total = intval($results["expected_total"]); // ERROR HERE 
            //echo var_dump("Source Total: " .$source_total);
        
            if ($source_total) {
                //flash("Source Total Calculated Successfully.");
            }
            else {
                $e = $stmt->errorInfo();
                //flash("Error getting source total: " . var_export($e, true));
            }


    $stmt2 = $db ->prepare("SELECT IFNULL(SUM(balance_change),0) AS expected_total FROM Transactions WHERE account_dest = :id");
            $r = $stmt2->execute([
                ":id" => $acc2
            ]);
            $results = $stmt2->fetch(PDO::FETCH_ASSOC);
            $destination_total = intval($results["expected_total"]); // ERROR HERE 
            //echo var_dump("Destination Total: " .$destination_total);

            if ($destination_total) {
                //flash("Destination Total Calculated Successfully.");
            }
            else {
                $e = $stmt->errorInfo();
                //flash("Error getting destination total (Normal if a new account was created): " . var_export($e, true));
            }

           

    $stmt = $db ->prepare("INSERT INTO Transactions (account_src, account_dest, balance_change, transaction_type, expected_total, memo)
        VALUES (:s_id, :d_id, :amount, :transaction_type, :expected_total, :memo), (:s_id2, :d_id2, :amount2, :transaction_type2, :expected_total2, :memo)" );
        //since this is called in create then it doesnt need to be called here
            
                $r = $stmt->execute([
                    //first half 
                    ":s_id" => $acc2,
                    ":d_id" => $acc1,
                    ":amount" => ($balance_change*-1),
                    ":transaction_type" => $transaction_total,
                    ":expected_total" => $source_total  - $balance_change,
                    ":memo"=> $memo ,
                    //second half
                    ":s_id2" => $acc1,
                    ":d_id2" => $acc2,
                    ":amount2" => ($balance_change),
                    ":transaction_type2" => $transaction_total,
                    ":expected_total2" => $destination_total + $balance_change,
                    ":memo"=> $memo ,
                ]);
                if ($r) {
                    flash("Transaction made successfully with reference id: " . $db->lastInsertId());
                }
                else {
                    $e = $stmt->errorInfo();
                    flash("Error performing transaction. Please contact you bank for further assistance.");
                }
                
                //$source_balance = $source_total-$amount ;
                //$destination_balance = $destination_total + $amount ;

                
            switch($transaction_total){

                case"Deposit":

                        $source_balance = $source_total-$balance_change ;
                        $destination_balance = $destination_total + $balance_change ;

                        //echo var_dump("Deposit : Source Balance: " . $source_balance);
                        //echo var_dump("Deposit: Destination Balance: " . $destination_balance);

                        $query = "UPDATE Accounts set balance = $source_balance where id = :src";
                        $db = getDB();
                        $stmt = $db->prepare($query);
                        try {
                            $stmt->execute([":src" => $acc1]);
                            //get_or_create_account(); //refresh session data
                        } catch (PDOException $e) {
                            error_log(var_export($e->errorInfo, true));
                            flash("Error refreshing account balance! Please contact your bank!", "danger");
                        }

                        $query = "UPDATE Accounts set balance = $destination_balance where id = :dest";
                        $db = getDB();
                        $stmt = $db->prepare($query);
                        try {
                            $stmt->execute([":dest" => $acc2]);
                            //get_or_create_account(); //refresh session data
                        } catch (PDOException $e) {
                            error_log(var_export($e->errorInfo, true));
                            flash("Error refreshing account balance! Please contact your bank!", "danger");
                        }

                 
                break;

                case"Transfer":
                    $source_balance = $source_total - $balance_change ;
                    $destination_balance = (($destination_total + $balance_change)) ;

                    //echo var_dump("Withdrawal : Source Balance: " . $source_balance);
                    //echo var_dump("Withdrawal: Destination Balance: " . $destination_balance);

                    $query = "UPDATE Accounts set balance = $source_balance where id = :src";
                    $db = getDB();
                    $stmt = $db->prepare($query);
                    try {
                        $stmt->execute([":src" => $acc1]);
                        //get_or_create_account(); //refresh session data
                    } catch (PDOException $e) {
                        error_log(var_export($e->errorInfo, true));
                        flash("Error refreshing account balance! Please contact your bank!", "danger");
                    }

                    $query = "UPDATE Accounts set balance = $destination_balance where id = :dest";
                    $db = getDB();
                    $stmt = $db->prepare($query);
                    try {
                        $stmt->execute([":dest" => $acc2]);
                        //get_or_create_account(); //refresh session data
                    } catch (PDOException $e) {
                        error_log(var_export($e->errorInfo, true));
                        flash("Error refreshing account balance! Please contact your bank!", "danger");
                    }
                  

                
                break;

            }

        
}