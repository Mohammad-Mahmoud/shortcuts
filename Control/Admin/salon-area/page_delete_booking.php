<?php
query::update("update actual_booking set hidden_salon = 1 where actual_booking_id = '$_GET[i]'");
admin::redirect("home.php?art=bookings");