<?php
admin::approveSalonRequest();
admin::showMessage("Request has been approved, instruction has been sent to the user");
admin::timer("home.php?art=show_req&i=".$_GET['i']);
?>