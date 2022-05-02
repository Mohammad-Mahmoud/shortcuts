<?php
$query = new query();
$products = $query->fetchAssoc( "select * from users order by date_r DESC" );
?>
<script>
	function confirmDelete(id) {
	
	if(confirm('You are about to delete this user, are you sure?')) {
		
		
		location.replace('home.php?art=delete_user&i='+id)
	
	} 
	
	else {
		
		return false;
	}
}
	
</script>

<div class="panel-body">

	<div class="row">
		<div class="heading-buttons pull-left">
			<a href="home.php?art=add_new_user" class="btn btn-primary">
                    <i class="icmn-plus3"></i>
                    Add User
                </a>
		





		</div>
		<div class="col-lg-12">
			<hr>
			<h4>Users</h4>
			<hr>

			<div class="margin-bottom-50">
				<table class="table table-hover nowrap" id="example1" width="100%">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Register Date</th>
							<th>Edit</th>
							<th>Delete</th>

						</tr>
					</thead>

					<tbody>
						<?php
						while ( $row = $products->fetch_assoc() ) {
							?>
						<tr>
							<td>
								<?=$row['first_name']?>
							</td>

							<td>
								<?=$row['last_name']?>
							</td>
							<td>
								<?=$row['email']?>
							</td>
							<td>
								<?=$row['phone']?>
							</td>
							<td>
								<?=$row['date_r']?>
							</td>
							
							<td>
								<button onClick="location.replace('home.php?art=edit_user&i=<?=$row['user_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline">
                                <i class="icmn-pencil5" aria-hidden="true"></i>
                                </button>
							






							</td>
							<td>
								<button onClick="return confirmDelete(<?=$row['user_id']?>)" type="button" class="btn btn-icon btn-primary margin-inline">
                                <i class="icmn-bin" aria-hidden="true"></i>
                                </button>
							






							</td>

						</tr>
						<?php
								}
								?>

					</tbody>
				</table>

			</div>
		</div>
	</div>

</div>


