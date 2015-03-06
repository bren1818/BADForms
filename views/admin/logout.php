<?php
include "../../includes/include.php";
$sessionManager->destroy();	
pageHeader("User Logout", false);
?>

<h1>You have successfully logged out.</h1>

<p><br /></p>
<p><a class="btn" href="/"><i class="fa fa-home"></i> Home</a></p>

<?php
pageFooter();
?>