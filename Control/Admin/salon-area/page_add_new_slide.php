

<div class="margin-bottom-50">
	<h2>Add new image</h2>
	<form action="home.php?art=add_slide" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
		
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" maxlength="50" name="name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Slide title" id="l0">
			</div>
		</div>
		
		<div class="form-group">
			<label for="l30">Slide Image</label>
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




