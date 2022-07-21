<?php
require_once(__DIR__ . "/../../partials/nav.php");

?>
<link rel="stylesheet" href="<?php echo get_url('styles.css'); ?>">
<script src="<?php echo get_url('helpers.js'); ?>"></script>
<div class = "dashboard" >
    <ul>
        <?php if (is_logged_in()) : ?>
            <li><a href="<?php echo get_url('createAccount.php'); ?>">Create Account</a></li>
            <li><a href="<?php echo get_url('ListAccount.php'); ?>">My Accounts</a></li>
            <li><a href="#">Deposit Funds</a></li>
            <li><a href="#">Withdraw Funds</a></li>
            <li><a href="#">Transfer Funds</a></li>
            <li><a href="#">View Profile</a></li>
        <?php endif; ?>
    </ul>
</div>