
<div class="margin-bottom-50">
	<h2>Edit Profile</h2>
	<form action="home.php?art=update_profile" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
	<div class="form-group row">
			<div class="col-md-9">
				Salon Name
				<input type="text" name="name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Name" id="l0" value="<?=admin::getSalonData('name')?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-9">
				Phone
				<input type="text" name="phone" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]"  id="l0" value="<?=admin::getSalonData('phone')?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-9">
				Address
				<input type="text" name="address" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]"  id="l0" value="<?=admin::getSalonData('address')?>">
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-9">
				Info
				<textarea  class="summernote" name="info" class="form-control" id="l0"><?=admin::getSalonData('info')?></textarea>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary width-150">Update</button>
		</div>
	</form>


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


<script>
	
    $(function() {
        $('.summernote').summernote({
            height: 350,
			
        });
    });
</script>



