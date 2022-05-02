<?php
	$query = new query();
	$keywords = $query->fetchAssoc("select * from keyword order by keyword_name_dk ASC");
?>
           <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                   <h1><button onClick="location.replace('home.php?art=add_new_keyword')" type="button" class="btn btn-icon btn-primary margin-inline"><i class="icmn-plus2" aria-hidden="true"></i></button></h1>
                    <h4>Keywords</h4>
                    
                    
                    <div class="margin-bottom-50">
                        <table class="table table-hover nowrap" id="example1" width="100%">
                            <thead>
                            <tr>
								<th>Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                               
                            </tr>
                            </thead>
                            
                            <tbody>
                            <?php
								while($row=$keywords->fetch_assoc()) {
							?>
                            <tr>
                               
								<td><?=$row['keyword_name_dk']?></td>
                                <td><button onClick="location.replace('home.php?art=edit_keyword&i=<?=$row['keyword_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline"><i class="icmn-pencil5" aria-hidden="true"></i></button></td>
                                <td>
                                <button onClick="location.replace('home.php?art=delete_keyword&i=<?=$row['keyword_id']?>')" type="button" class="btn btn-icon btn-primary margin-inline">
                                <i class="icmn-bin" aria-hidden="true"></i>
                                </button>
                                </td>
                                
                            </tr>
                            <?php
								}
								?>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
			</div>
	 