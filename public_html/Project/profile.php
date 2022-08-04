<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/flash_messages.php");
if (!is_logged_in()) {
    die(header("Location: login.php"));
}
?>
<form method="POST">   


<h4>Users Profile</h4>
<h5> Profile View to Public or Private</h5>
<input type ="submit" name="Public" value="Public"/>
<input type ="submit" name="Private" value="Private"/>
</form>

<?php
$db =getDB();

$id = get_user_id();
//display account_view settings
$display_account_view_stmt = $db->prepare("SELECT account_view from Users where id = :id");

$display_success = $display_account_view_stmt->execute([
    ":id" => $id,
]);
$settings = $display_account_view_stmt->fetch(PDO::FETCH_ASSOC);
$account_view = $settings["account_view"];
ob_start();
echo "Account view setting: " . $account_view."<br>" ;

if (isset($_POST["Public"])) {
    $account_view = $_POST["Public"];
    $insert_stmt = $db->prepare("UPDATE Users set account_view = :account_view where id = :id");
    $insert_success + $insert_stmt->execute([
        ":account_view" => $account_view,
        ":id" => $id,
    ]);

    if($insert_success){
        ob_end_clean();
        flash("Account view Settings Successfully Updated!");
        echo "Account View Setting: " . $account_view."<br>" ;
    }
} else if (isset($_POST["Private"])){
    $account_view = $_POST["Private"];

    $insert_stmt = $db->prepare("UPDATE Users set account_view = :account_view where id = :id");

    $insert_success = $insert_stmt->execute([
        ":account_view" => $account_view,
        ":id" => $id,
    ]);

    if($insert_success){
        ob_end_clean();
        flash("Account View Settings Successfully Updated!");
        echo "Account View Setting: " . $account_view."<br>";

    }
}

?>
<form method="POST">

<h4>User Profile</h4>   
<h5>Enter or Update First and Last Names</h5>
<label>Enter First Name</label> 
<input type="text"  name="first_name">

<label>Enter Last Name</label> 
<input type="text"  name="last_name">

<input type ="submit" name="save_names" value="Submit"/>
</form> 
<?php
$db = getDB();
$id = get_user_id();
//make query to pull first and last name from DB and display under name form
$display_stmt = $db->prepare("SELECT first_name, last_name from Users where id = :id");

$display_success = $display_stmt->execute([
   ":id" => $id,
]);

$results = $display_stmt->fetch(PDO::FETCH_ASSOC);
$first_name = $results["first_name"]; 
$last_name = $results["last_name"]; 
ob_start();
echo "First Name:  " . $first_name."<br>" ;
echo "Last Name:  " . $last_name."<br><br><br>" ;

if (isset($_POST["save_names"])) {
   $db = getDB();
   $first_name = $_POST["first_name"];
   $last_name = $_POST["last_name"];
   $id = get_user_id() ;

   $insert_stmt = $db->prepare("UPDATE Users set first_name = :first_name , last_name = :last_name where id = :id");

   $insert_success = $insert_stmt->execute([
       ":first_name" => $first_name,
       "last_name" => $last_name,
       ":id" => $id,
   ]);
   
   if($insert_success){
           ob_end_clean();
           flash("Records for first and last names updated!");
           echo "First Name:  " . $first_name."<br>" ;
           echo "Last Name:  " . $last_name."<br><br><br>" ;

       } 

}


if (isset($_POST["save"])) {
    $email = se($_POST, "email", null, false);
    $username = se($_POST, "username", null, false);
    $hasError = false;
    //sanitize
    $email = sanitize_email($email);
    //validate
    if (!is_valid_email($email)) {
        flash("Invalid email address", "danger");
        $hasError = true;
    }
    if (!is_valid_username($username)) {
        flash("Username must only contain 3-16 characters a-z, 0-9, _, or -", "danger");
        $hasError = true;
    }
    if (!$hasError) {
        $params = [":email" => $email, ":username" => $username, ":id" => get_user_id()];
        $db = getDB();
        $stmt = $db->prepare("UPDATE Users set email = :email, username = :username where id = :id");
        try {
            $stmt->execute($params);
            flash("Profile saved", "success");
        } catch (Exception $e) {
            users_check_duplicate($e->errorInfo);
        }
        //select fresh data from table
        $stmt = $db->prepare("SELECT id, email, username from Users where id = :id LIMIT 1");
        try {
            $stmt->execute([":id" => get_user_id()]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                //$_SESSION["user"] = $user;
                $_SESSION["user"]["email"] = $user["email"];
                $_SESSION["user"]["username"] = $user["username"];
            } else {
                flash("User doesn't exist", "danger");
            }
        } catch (Exception $e) {
            flash("An unexpected error occurred, please try again", "danger");
            //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }


    //check/update password
    $current_password = se($_POST, "currentPassword", null, false);
    $new_password = se($_POST, "newPassword", null, false);
    $confirm_password = se($_POST, "confirmPassword", null, false);
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        $hasError = false;
        if (!is_valid_password($new_password)) {
            flash("Password too short", "danger");
            $hasError = true;
        }
        if (!$hasError) {
            if ($new_password === $confirm_password) {
                //TODO validate current
                $stmt = $db->prepare("SELECT password from Users where id = :id");
                try {
                    $stmt->execute([":id" => get_user_id()]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (isset($result["password"])) {
                        if (password_verify($current_password, $result["password"])) {
                            $query = "UPDATE Users set password = :password where id = :id";
                            $stmt = $db->prepare($query);
                            $stmt->execute([
                                ":id" => get_user_id(),
                                ":password" => password_hash($new_password, PASSWORD_BCRYPT)
                            ]);

                            flash("Password reset", "success");
                        } else {
                            flash("Current password is invalid", "warning");
                        }
                    }
                } catch (Exception $e) {
                    echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
                }
            } else {
                flash("New passwords don't match", "warning");
            }
        }
    }
}
?>

<?php
$email = get_user_email();
$username = get_username();
?>
<form method="POST" onsubmit="return validate(this);">
    <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php se($email); ?>" />
    </div>
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php se($username); ?>" />
    </div>
    <!-- DO NOT PRELOAD PASSWORD -->
    <div>Password Reset</div>
    <div class="mb-3">
        <label for="cp">Current Password</label>
        <input type="password" name="currentPassword" id="cp" />
    </div>
    <div class="mb-3">
        <label for="np">New Password</label>
        <input type="password" name="newPassword" id="np" />
    </div>
    <div class="mb-3">
        <label for="conp">Confirm Password</label>
        <input type="password" name="confirmPassword" id="conp" />
    </div>
    <input type="submit" value="Update Profile" name="save" />
</form>

<script>
    function validate(form) {
        let pw = form.newPassword.value;
        let con = form.confirmPassword.value;
        let isValid = true;
        //TODO add other client side validation....

        //example of using flash via javascript
        //find the flash container, create a new element, appendChild
        if (pw !== con) {
            flash("Password and Confrim password must match", "warning");
            isValid = false;
        }
        return isValid;
    }
</script>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>
