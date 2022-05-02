<?php
//print_r($_POST);

admin::addBarber();
admin::showMessage("Barber added succefully");
admin::timer("home.php?art=barbers");


