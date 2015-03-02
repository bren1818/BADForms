<?php
include "../../includes/include.php";
pageHeader();
?>

<h1>Logged out</h1>

<?php
$sessionManager->destroy();	
?>

<p>Logout Complete.</p>

<p><a class="btn" href="/">Home</a></p>

<?php
pageFooter();
?>