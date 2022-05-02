
            <div class="row">
                <div class="col-lg-12">
                    <div class="margin-bottom-50">
                        <h4>Change Password</h4>
                        <br />
                        <!-- Horizontal Form -->
                        <form id="form-validation" name="form-validation" method="POST" action="home.php?art=change_password">
                            <div class="form-group">
                               <div class="alert alert-success" id="alert-s" role="alert" style="display: none;">
                            		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               			 <span aria-hidden="true">×</span>
                            		</button>
                            		<strong>Password Changed!</strong>
                        		</div>
                               <div class="alert alert-danger" id="alert-w" role="alert" style="display: none;">
                            		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               			 <span aria-hidden="true">×</span>
                            		</button>
                            		<strong>Current Password is invalid!</strong>
                        		</div>
                                <label class="form-label">Current Password</label>
                            	
                                <input id="current-password"
                                       class="form-control password"
                                       name="current_password"
                                       type="password" data-validation="[L>=6]"
                                       data-validation-message="Current password must be at least 6 characters"
                                       >
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input id="new-password"
                                       class="form-control password"
                                       name="new_pass"
                                       type="password" data-validation="[L>=6]"
                                       data-validation-message="New password must be at least 6 characters"
                                       >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Re-Password</label>
                                <input id="new-password-confirm"
                                       class="form-control password"
                                       name="pass"
                                       type="password" data-validation="[V==new_pass]"
                                       data-validation-message="Password does not match the new password"
                                       >
                            </div>
                           
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary width-150">Change Password</button>
                                
                            </div>
                          
                        </form>
                        <!-- End Column Sizing -->
                    </div>
                </div>
            </div>
        
<?php
$admin = new admin;
if(isset($_POST['current_password'])) {
	$admin->changePassword();

}

?>

<script>
    $(function() {

        // Add class to body for change layout settings
        $('body').addClass('single-page');

        // Form Validation
        $('#form-validation').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-control-error',
                    errorClass: 'has-danger'
                }
            }
        });

        // Show/Hide Password
        $('.password').password({
            eyeClass: '',
            eyeOpenClass: 'icmn-eye',
            eyeCloseClass: 'icmn-eye-blocked'
        });
		

    });
</script>