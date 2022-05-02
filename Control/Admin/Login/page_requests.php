<?php
$query = new query();
$comments = $query->fetchAssoc("select * from salon_req order by date DESC");
$count = 1;
?>


<table class="table table-hover nowrap" id="example1" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th class="width-150">From</th>
            <th>Email</th>
            <th>Type</th>
			<th class="no-sort">Date</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		<?php
		while($row=$comments->fetch_assoc()) {
            if($row['type'] == 0) {
                $type = 'Self employed';
            } else {
                $type = 'Hair salon';
            }
			if($row['approved'] == 0) {
				$style = 'style="background-color:lavender"';
			} else {
				$style = '';
			}
		?>
		<tr <?=$style?>>
			<td><?=$count++;?></td>
			<td><?=$row['name'];?></td>
            <td><?=substr($row['email'],0,50);?></td>
            <td><?=$type;?></td>
			<td><?=$row['date'];?></td>
			<td>
                <a href="home.php?art=show_req&i=<?=$row['req_id']?>" class="link-underlined"><i class="icmn-eye"><!-- --></i> Show</a> ||
                <a href="home.php?art=delete_req&i=<?=$row['req_id']?>" class="link-underlined"><i class="icmn-cross2"><!-- --></i> Delete</a>
			</td>
		</tr>
		<?php
		}
		?>

	</tbody>
</table>