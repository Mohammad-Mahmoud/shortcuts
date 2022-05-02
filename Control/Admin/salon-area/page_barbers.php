<?php
$query = new query();
$salon_id = admin::getSalonData('salon_id');
$salon_type = admin::getSalonData('type');

if($salon_type == 'self') {
	$address = admin::getSalonData('address');
}

$products = $query->fetchAssoc( "select * from barbers where salon_id = '$salon_id'" );
?>
<script>
	function confirmDelete(id) {
	
	if(confirm('You are about to delete this barbers, are you sure?')) {
		
		
		location.replace('home.php?art=delete_barber&i='+id)
	
	} 
	
	else {
		
		return false;
	}
}
	
</script>

<div class="panel-body">

	<div class="row">
			<?php
			if($salon_type !== 'self') {
			?>
		<div class="heading-buttons pull-left">
			
			<a href="home.php?art=add_new_user" class="btn btn-primary">
                    <i class="icmn-plus3"></i>
                    Add Barber
			</a>
		</div>
		<?php
			}
		?>

		<div class="col-lg-12">
			<hr>
			<h4>Barbers</h4>
			<hr>

			<div class="margin-bottom-50">
				<table class="table table-hover nowrap" id="example1" width="100%">
					<thead>
						<tr>
							<th>Name</th>
							<th>Radius</th>
							<th>Phone</th>
							<th>Edit</th>
							<?php
								if($salon_type !== 'self') {
							?>
							<th>Services</th>
							<th>Delete</th>
							<?php
								}
							?>

						</tr>
					</thead>

					<tbody>
						<?php
						while ( $row = $products->fetch_assoc() ) {
							?>
						<tr>
							<td>
								<?=$row['name']?>
							</td>

							<td>
								<?=$row['radius']?> KM
							</td>
							<td>
								<?=$row['phone']?>
							</td>
							
							
							
							<td>
								<button onClick="location.replace('home.php?art=edit_barber&i=<?=$row['barber_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline">
                                <i class="icmn-pencil5" aria-hidden="true"></i>
                                </button>
		
							</td>
							<?php
								if($salon_type !== 'self') {
							?>
							<td>
								<button onClick="location.replace('home.php?art=barber_services&i=<?=$row['barber_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline">
                                <i class="icmn-earth" aria-hidden="true"></i>
                                </button>
							</td>
							<td>
								<button onClick="return confirmDelete(<?=$row['barber_id']?>)" type="button" class="btn btn-icon btn-danger margin-inline">
                                <i class="icmn-bin" aria-hidden="true"></i>
                                </button>
							</td>
							<?php
								}
							?>

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


