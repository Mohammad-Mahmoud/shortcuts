<?php
$query = new query();
$langs = $query->fetchAssoc( "select * from lang where lang_id" );
?>
<div class="panel-body">
	<div class="row">
		<div class="heading-buttons pull-left">
			<a href="home.php?art=add_new_lang" class="btn btn-primary">
                    <i class="icmn-plus3"></i>
                    Add Language
                </a>
		

		</div>
		<div class="col-lg-12">
			<hr>
			<h4>Languages</h4>
			<div class="margin-bottom-50">
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Code</th>
							<th>Delete</th>

						</tr>
					</thead>

					<tbody>
						<?php
						while ( $row = $langs->fetch_assoc() ) {
							?>
						<tr>

							<td>
								<?=$row['lang_name']?>
							</td>
							<td>
								<?=$row['code']?>
							</td>
							<?php
								if($row['code'] != 'dk') {
									
							?>
							
							<td>
								<button onClick="location.replace('home.php?art=delete_lang&i=<?=$row['lang_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline">
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