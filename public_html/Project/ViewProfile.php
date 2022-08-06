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
<input type ="submit" name="Public" value="public"/>
<input type ="submit" name="Private" value="public"/>
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

 /*//code to alter users table and add in columns for first and last names 
    try{
        $stmt = $db->prepare("ALTER TABLE Users ADD COLUMN first_name varchar(30) , ADD COLUMN last_name varchar(30) ; ");
        $alter_success = $stmt->execute();
    }catch(Exception $e){
         echo $e ;
       
    }*/
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

