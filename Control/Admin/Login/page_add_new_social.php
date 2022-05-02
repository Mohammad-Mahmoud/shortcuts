
<div class="margin-bottom-50">
	<h2>Add New social</h2>
	<form action="home.php?art=add_social" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
	<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Name" id="l0">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="link" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Link" id="l0">
			</div>
		</div>
		<div class="form-group">
			<label for="l30">Icon</label>
			<input type="file" class="form-control" name="Filedata" id="l30" data-validation-message="You didn't choose any file" accept="image/*" data-validation="[NOTEMPTY]">
			<label id="status"></label>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary width-150">Add</button>
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




