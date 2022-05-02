<?php
$query = new query();

$slide = $query->fetchAssoc("select * from slides where slide_id = '$_GET[i]'");
$s_slide = $slide->fetch_assoc();
?>

<div class="margin-bottom-50">
	<h2>Edit Image</h2>
	<form action="home.php?art=update_slide&i=<?= $_GET['i'] ?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
		
			<div class="form-group row">
				<div class="col-md-9">
					<b>Image title</b>
					<input type="text" maxlength="50" name="name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Image title" value="<?= $s_slide['name'] ?>" id="l0">
				</div>
			</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary width-150">Update</button>
		</div>
	</form>


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