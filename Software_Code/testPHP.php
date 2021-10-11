<html>
<?php
session_start();
?>
<form action="dashboardPHP.php" method="post">
    <input type="submit" name="generateInvite" value="Generate Invite" />
</form>
<div>
    <?php
    if (isset($_SESSION['inviteLink'])) {
        echo $_SESSION['inviteLink'];
        unset($_SESSION['inviteLink']);
    }
    ?>
</div>

</html>