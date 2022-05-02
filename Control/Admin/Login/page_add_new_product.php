<?php
$query = new query();
$languages = $query->fetchAssoc( "select * from lang" );
$lang = $query->fetchAssoc( "select * from lang" );


?>

<div class="margin-bottom-50">
	<h2>Add New Product</h2>
	<form action="home.php?art=add_product" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
		<?php
		while ( $row = $languages->fetch_assoc() ) {
			?>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="product_name_<?=$row['code']?>" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Product Name <?=$row['lang_name']?>" id="l0">
			</div>
		</div>
		<?php
		}
		?>
		<div class="form-group row">
			<div class="col-md-9">
				<input type="text" name="price" class="form-control" data-validation-message="This field must not be empty, accept only numbers" data-validation="[NOTEMPTY],NUMERIC" placeholder="Product Price">
			</div>
		</div>
		
		<div class="form-group">
			Select Category
			<select class="form-control" name="target">
				
				<option value="device">Device</option>
				<option value="product">Product</option>
				
			</select>
		</div>
		
		<div class="form-group">
			<label for="l30">Product picture</label>
			<input type="file" class="form-control" name="Filedata" id="l30" data-validation-message="You didn't choose any file" accept="image/*" data-validation="[NOTEMPTY]">
			<label id="status"></label>
		</div>

		<?php
		while ( $row = $lang->fetch_assoc() ) {
			?>
		<div class="form-group">
			Product Descreption
			<?=$row['lang_name']?>
			<textarea class="summernote" name="product_desc_<?=$row['code']?>">
                
            </textarea>

		
		</div>
		<?
		}
		?>
		

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



	$( function () {
		$( '.summernote' ).summernote( {
			height: 350
		} );
	} );
</script>