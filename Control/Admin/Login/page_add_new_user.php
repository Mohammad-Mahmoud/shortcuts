

<div class="margin-bottom-50">
	<h2>Add New User</h2>
	<form action="home.php?art=add_user" method="post" id="form-validation-simple" name="form-validation-simple">
		<div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="first_name" placeholder="First Name" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="last_name" placeholder="Last Name" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="email" placeholder="Email" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="phone" placeholder="Phone" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
            	Birthdate<input type="date" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="birthday" placeholder="Birthdate" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
            	<input type="password" class="form-control" data-validation-message="Password must be at least 6 characters" data-validation="[L>=6]" name="password"  placeholder="Password" id="l0">
            </div>
        </div>
       
        <div class="form-actions">
        	<button type="submit" class="btn btn-primary width-150">Add</button>
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
