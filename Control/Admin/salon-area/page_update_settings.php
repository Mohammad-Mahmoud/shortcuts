<?php
admin::updateWorkingDays();
admin::redirect("home.php?art=settings");
print_r($_POST);