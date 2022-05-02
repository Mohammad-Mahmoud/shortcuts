<form action="calc.php" method="post">
    E precent<input type="text" name="precent">
    <br>
    Total attacks<input type="text" name="total">
    <br>
   S precent <input type="text" name="s_precent">
    <br>
   S attacks <input type="text" name="s_total">
    <br>
    <input type="submit" value="calc">
    <br>
</form>

<?php

$e_sum = $_POST['precent'] * $_POST['total'];

$s_sum = $_POST['s_precent'] * $_POST['total'];

$count = $_POST['total'] - $_POST['s_total'];

$req = ($e_sum - $s_sum)/$count;

echo 'Average: '.$req;
echo '<br>Total: ';
$total = $e_sum - $s_sum;
echo $total;