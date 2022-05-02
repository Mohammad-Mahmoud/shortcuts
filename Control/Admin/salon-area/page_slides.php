<?php
$salon_id = admin::getSalonData('salon_id');
$query = new query();
$slides = $query->fetchAssoc("SELECT * from slides WHERE salon_id = '$salon_id' order by slide_id DESC");
?>
<script>
	function confirmDelete(id) {

		if (confirm('You are about to delete this image , are you sure?')) {


			location.replace('home.php?art=delete_slide&i=' + id)

		} else {

			return false;
		}
	}
</script>

<div class="panel-body">

	<div class="row">
		<div class="heading-buttons pull-left">
			<a href="home.php?art=add_new_slide" class="btn btn-primary">
				<i class="icmn-plus3"></i>
				Add Image
			</a>






		</div>
		<div class="col-lg-12">
			<hr>
			<h4>Images</h4>
			<hr>

			<div class="margin-bottom-50">
				<table class="table table-hover nowrap" id="example1" width="100%">
					<thead>
						<tr>
							<th>Title</th>
							<th>Image</th>
							<th>Edit</th>
							<th>Delete</th>

						</tr>
					</thead>

					<tbody>
						<?php
						while ($row = $slides->fetch_assoc()) {
						?>
							<tr>

								<td>
									<?= $row['name'] ?>
								</td>

								<td>

									<button data-toggle="modal" data-target="#pic<?= $row['slide_id'] ?>" type="button" class="btn btn-icon btn-primary margin-inline">
										<i class="icmn-pencil5" aria-hidden="true"></i>
									</button>



									<div class="modal fade modal-size-large" id="pic<?= $row['slide_id'] ?>" role="dialog" aria-labelledby="" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>


												<h4 class="modal-title" id="myModalLabel">Change image</h4>
												</div>
												<div class="modal-body text-center">
													<div class="row">
														<img src="../../../img/<?= $row['url'] ?>" style="height: 400px; width: auto;">
													</div>
													<form action="home.php?art=change_slide_image&i=<?= $row['slide_id'] ?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
														<div class="form-actions">
															<label for="l30">Choose another Image</label>
															<input type="file" class="form-control" name="Filedata" id="l30" data-validation-message="You didn't choose any file" accept="image/*" data-validation="[NOTEMPTY]">
															<label id="status"></label>
															<button type="submit" class="btn btn-primary width-150">Change</button>
														</div>
													</form>
												</div>


												<div class="modal-footer">
													<button type="button" class="btn" data-dismiss="modal">Close</button>

												</div>
											</div>
										</div>
									</div>
									<script>
										$(function() {

											$('#form-validation').validate({
												submit: {
													settings: {
														inputContainer: '.form-group',
														errorListClass: 'form-control-error',
														errorClass: 'has-danger'
													}
												}

											});

											$('#form-validation-simple').validate({
												submit: {
													settings: {
														inputContainer: '.form-group',
														errorListClass: 'form-control-error-list',
														errorClass: 'has-danger'
													}
												}

											});

											$('.select2').select2();
											$('.select2-tags').select2({
												tags: true,
												tokenSeparators: [',', ' ']
											});

										});
									</script>







								</td>
								<td>
									<button onClick="location.replace('home.php?art=edit_slides&i=<?= $row['slide_id'] ?>')" type="button" class="btn btn-icon btn-primary margin-inline">
										<i class="icmn-pencil5" aria-hidden="true"></i>
									</button>







								</td>
								<td>
									<button onClick="return confirmDelete(<?= $row['slides_id'] ?>)" type="button" class="btn btn-icon btn-danger margin-inline">
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