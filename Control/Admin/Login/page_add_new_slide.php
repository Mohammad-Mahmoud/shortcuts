<?php
$query = new query();
$languages = $query->fetchAssoc( "select * from lang" );
$languages1 = $query->fetchAssoc( "select * from lang" );
$languages2 = $query->fetchAssoc( "select * from lang" );
?>

<div class="margin-bottom-50">
	<h2>Add New Slide</h2>
	<form action="home.php?art=add_slide" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
		<?php
		while ( $row = $languages->fetch_assoc() ) {
			?>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="slides_name_<?=$row['code']?>" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Slide title <?=$row['lang_name']?>" id="l0">
			</div>
		</div>
		<?php
		}
		?>
		<?php
		while ( $row = $languages1->fetch_assoc() ) {
			?>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="slides_desc_<?=$row['code']?>" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Slide Sub-title <?=$row['lang_name']?>" id="l0">
			</div>
		</div>
		<?php
		}
		?>
		<?php
		while ( $row = $languages2->fetch_assoc() ) {
			?>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="slides_link_desc_<?=$row['code']?>" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Button text <?=$row['lang_name']?>" id="l0">
			</div>
		</div>
		<?php
		}
		?>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="link" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Button Link" id="l0">
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




