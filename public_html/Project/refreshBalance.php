<?php
require_once(__DIR__ . "/createAccount.php");
function refreshBalance()
{
    if (is_logged_in()) {
        //cache account balance via transactions table
        $query = "UPDATE Account set balance = (SELECT IFNULL(SUM(amount), 0) from Transactions WHERE account_src = :src) where id = :src";
        $db = getDB();
        $stmt = $db->prepare($query);
        try {
            $stmt->execute([":src" => intval($_SESSION['user']['id'])]);
            //get_or_create_account(); //refresh session data
        } catch (PDOException $e) {
            error_log(var_export($e->errorInfo, true));
            flash("Error refresh your account balance! Please contact your bank!", "danger");
        }
    }
}