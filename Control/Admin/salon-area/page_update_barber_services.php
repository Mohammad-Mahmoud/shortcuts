<?php
admin::updateBarberServices();
admin::redirect("home.php?art=barber_services&i=".$_GET['i']);
