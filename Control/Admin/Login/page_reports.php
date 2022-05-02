<?php
$query = new query();
$reports = $query->fetchAssoc("select * from reports re, reviews r where re.review_id = r.review_id
order by re.date DESC");
$count = 1;
?>


<table class="table table-hover nowrap" id="example1" width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Review Title</th>
        <th>Topic</th>
        <th class="no-sort">Date</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    <?php
    while($row=$reports->fetch_assoc()) {
        $title = $query::returnSingleValue('reviews','title','review_id = '.$row['review_id']);
        if($row['readen'] == 0) {
            $style = 'style="background-color:lavender"';
        } else {
            $style = '';
        }
        ?>
        <tr <?=$style?>>
            <td><?=$count++;?></td>
            <td><a href="home.php?art=read_report&i=<?=$row['review_id']?>&r=<?=$row['report_id']?>"><?=substr($row['title'],0,50);?></a></td>
            <td><?=$row['topic'];?></td>
            <td><?=$row['date'];?></td>
            <td>
                <a href="home.php?art=delete_report&i=<?=$row['report_id']?>" class="link-underlined"><i class="icmn-cross2"><!-- --></i> Delete</a>
            </td>
        </tr>
        <?php
    }
    ?>

    </tbody>
</table>