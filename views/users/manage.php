<?php
	include "../../includes/include.php";
	pageHeader("Manage Users");
	
	if( $currentUser->getUserLevel() == 1 ){
	//list current Users
?>
	<h1>Manage Users</h1>

	<?php
		$query = "SELECT `id`, `username`, `email`, `userLevel`, `enabled`, `lastLogin` 
					FROM `admin`";
					
		$db = getConnection();
		
		$query = $db->prepare($query);
		if( $query->execute() ){
			$count = $query->rowCount();			
	?>
	
	<table>
		<thead>
			<tr>
				<th>Username</th><th>Email</th><th>Enabled</th><th>Last Login</th><th>Edit</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while( $result = $query->fetch() ){
				?>
				<tr>
					<td><?php echo ( $result["userLevel"] == "1" ? '<i class="fa fa-user-secret"></i>' : '<i class="fa fa-user"></i>'); ?> <?php echo $result["username"]; ?><?php echo ($result["username"] == $currentUser->getUserName() ? ' (You)' : ''); ?></td>
					<td><?php echo $result["email"]; ?></td>
					<td align="center"><?php echo ($result["enabled"] == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'); ?></td>
					<td><?php echo $result["lastLogin"]; ?></td>
					<td>Edit | Delete</td>
				</tr>
				<?php
			}
		?>
		</tbody>
	</table>	

	<?php 
		echo '<p><b>('.$count.')</b> users</p>';
	} ?>
	
	<p><a class='btn' href="/views/users/create.php"><i class="fa fa-user-plus"></i> Add User</a></p>

<?php
	//echo $currentUser->getUserLevel();

	}else{
		echo "<p>You do not have Access</p>";
	}
	pageFooter();
?>