<?php
$query = new query();
$social = $query->fetchAssoc( "select * from social order by name ASC" );
?>
<script>
	function confirmDelete(id) {
	
	if(confirm('Are you sure you want to delete?')) {
		
		
		location.replace('home.php?art=delete_social&i='+id)
	
	} 
	
	else {
		
		return false;
	}
}
	
</script>

<div class="panel-body">

	<div class="row">
		
		<div class="col-lg-12">
			<hr>
			<h4>Social</h4>
			<hr>

			<div class="margin-bottom-50">
				<table class="table table-hover nowrap" id="example1" width="100%">
					<thead>
						<tr>
							<th>Name</th>
							<th>Active</th>
							
							<th>Edit</th>
							<th>Delete</th>

						</tr>
					</thead>

					<tbody>
						<?php
						while ( $row = $social->fetch_assoc() ) {
							?>
						<tr>

							<td>
								<?=$row['name']?>
							</td>

							<td>
								<?php 
								if($row['active'] == 0) {
									echo '<a href="home.php?art=social_active&i='.$row['social_id'].'&active=1">Not active</a>';
								} else {
									echo '<a href="home.php?art=social_active&i='.$row['social_id'].'&active=0">Active</a>';
								}
								?>
							</td>
							
														<td>
								<button onClick="location.replace('home.php?art=edit_social&i=<?=$row['social_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline">
                                <i class="icmn-pencil5" aria-hidden="true"></i>
                                </button>
							






							</td>
							<td>
								<button onClick="return confirmDelete(<?=$row['social_id']?>)" type="button" class="btn btn-icon btn-primary margin-inline">
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


<script>
	
	$( function () {

		$( '#form-validation' ).validate( {
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger'
				}
			}
			
		} );

		$( '#form-validation-simple' ).validate( {
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error-list',
					errorClass: 'has-danger'
				}
			}

		} );

		$( '.select2' ).select2();
		$( '.select2-tags' ).select2( {
			tags: true,
			tokenSeparators: [ ',', ' ' ]
		} );

	} );
	
	
	
</script>




