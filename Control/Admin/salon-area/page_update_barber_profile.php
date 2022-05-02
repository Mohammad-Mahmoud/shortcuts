<?php
admin::updateBarberProfile();
admin::showMessage("Porfile updated successfully");
admin::timer("home.php?art=edit_barber&i=".$_GET['i']);