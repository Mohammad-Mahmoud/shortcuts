<?php
query::update("delete from closing_days where closing_days_id = '$_GET[i]'");
admin::redirect("home.php?art=settings");