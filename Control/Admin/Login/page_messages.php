<?php
$query = new query();
$comments = $query->fetchAssoc("select * from messages order by date DESC");
$count = 1;
?>


<table class="table table-hover nowrap" id="example1" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th class="width-150">From</th>
			<th>Message</th>
			<th class="no-sort">Date</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		<?php
		while($row=$comments->fetch_assoc()) {
			if($row['readen'] == 0) {
				$style = 'style="background-color:lavender"';
			} else {
				$style = '';
			}
		?>
		<tr <?=$style?>>
			<td><?=$count++;?></td>
			<td><?=$row['name'];?></td>
			<td><a href="home.php?art=read&i=<?=$row['messages_id']?>"><?=substr($row['text'],0,50);?></a></td>
			<td><?=$row['date'];?></td>
			<td>
				<a href="home.php?art=delete_message&i=<?=$row['messages_id']?>" class="link-underlined"><i class="icmn-cross2"><!-- --></i> Delete</a>
			</td>
		</tr>
		<?php
		}
		?>

	</tbody>
</table>