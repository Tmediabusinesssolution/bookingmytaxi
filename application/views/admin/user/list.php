<!-- DataTables CSS -->
<link href="<?= base_url()?>theme/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="<?= base_url()?>theme/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<style>
.table>thead>tr>th{vertical-align: baseline;}
.checktd{padding: 7px 18px !important;}
.multidelete{ padding: 7px; }
</style> 
 
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= $this->title ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                
                    <div class="col-sm-6">
                       	<label class="pull-left">
                            <select name="pagesize" class="form-control input-sm" id="pagesize">
                                <option value="10" <?php if($pagesize == '10'){ echo "selected"; }?>>10</option>
                                <option value="25" <?php if($pagesize == '25'){ echo "selected"; }?>>25</option>
                                <option value="50" <?php if($pagesize == '50'){ echo "selected"; }?>>50</option>
                                <option value="100" <?php if($pagesize == '100'){ echo "selected"; }?>>100</option>
                            </select>
                       	</label>
                        <?php echo form_open('admin/user/delete',array("class"=>"multidelete pull-left", "id"=>"multidelete")); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Delete </button>
                        <?php echo form_close(); ?>
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right">
                            <label><input type="search" name="searchKey" id="searchKey" class="form-control input-sm" placeholder="Search" value="<?= $searchKey ?>"></label>
                            <button class="btn btn-primary btn-sm searchBtn">Search</button>
                        </div>
                    </div>
                
            </div>
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th style="width: 1px;"><input id="select_all" type="checkbox" /></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="<?= $this->comman_class ?>">
                            <?php if(!empty($providers)): foreach($providers as $provider): ?>
                                
                                <tr class="odd gradeX">
                                    <td class="checktd">
                                   	<input type="checkbox" name="ids[]" value="<?= $provider['ID'] ?>" class="checkbox" form="multidelete" />
                                    </td>
                                    <td><?= substr($provider['FirstName'] ." ". $provider['LastName'],0,35); ?> </td>
                                    <td><?= $provider['Email'] ?> </td>
                                    <td><?= $provider['Contact'] ?> </td>
                                    <td><?= $provider['Status'] ?> </td>
                                    <td>
                                    	<a href="<?= base_url('admin/'.$this->comman_class.'/edit/').$provider['ID'] ?>" title="Update"><span class="glyphicon glyphicon-pencil"></span></a> 
                                        <a href="<?= base_url('admin/'.$this->comman_class.'/remove/').$provider['ID'] ?>" title="Reset" onclick="javascript:return confirm('Are you sure you want to delete this item?')"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                
								<?php endforeach; else: ?>
                                <p><?= $this->title ?> not available.</p>
                                <?php endif; ?>
                                <tr class="odd gradeX">
                                    <td colspan="10">
                                        <?php echo $this->ajax_pagination->create_links(); ?>
                                    </td>    
                                </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>



<script src="<?= base_url()?>theme/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>theme/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url()?>theme/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
			searching: false,
			bLengthChange: false,
			bPaginate: false,
			bInfo : false
        });
    });
	$(document).ready(function(){
		$("#pagesize").change(function(){
			//$('#pagesizeform').submit();
			getData(0);
			return false;
		});
		
		$(".searchBtn").click(function(){
			//$('#pagesizeform').submit();
			getData(0);
			return false;
		});
	});
	$(document).ready(function(){
		//select all checkboxes
		$("#select_all").change(function(){  //"select all" change 
			$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
		});
		
		//".checkbox" change 
		$('.checkbox').change(function(){ 
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(false == $(this).prop("checked")){ //if this item is unchecked
				$("#select_all").prop('checked', false); //change "select all" checked status to false
			}
			//check "select all" if all checkbox items are checked
			if ($('.checkbox:checked').length == $('.checkbox').length ){
				$("#select_all").prop('checked', true);
			}
		});
	});
</script>        