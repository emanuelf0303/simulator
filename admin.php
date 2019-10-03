<?php
    include('session.php');
    if ($login_role == 1) {
        header("location:index.php");
        die();
    }

    $result = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($_POST as $key => $value) {
            //do something
            $sql = "UPDATE fields SET value='$value' WHERE type=0 AND field_id='$key'";
            if (mysqli_query($db, $sql) !== TRUE) {
                echo "An error occured";
            }
        }
        echo "Successfully updated";
    }
    $ses_sql = mysqli_query($db, "select * from fields order by field_id desc");


?>
<body>
    <section>
        <a href="./logout.php">Logout (<?php echo $login_user;?>)</a>
    </section>

    <section id="header">
        <div class="container">
            <h1>Admin Panel</h1>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="btn-group">
                        <a class="btn sbold green add_new"> Add New <i class="fa fa-plus"></i></a>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="field_list">
                        <thead>
                            <tr>
                                <th > Field Id </th>
                                <th style="text-align: center;"> Name </th>
                                <th style="text-align: center;"> Value </th>
                                <th style="text-align: center;"> Unit </th>
                                <th style="text-align: center;"> Type </th>
                                <th style="text-align: center;"> Description </th>
                                <th style="text-align: center;"> Edit </th>
                                <th style="text-align: center;">Formula</th>
                                <th style="text-align: center;"> Delete </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC)) {
                                    // if ($row['type'] == 0) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $row['field_id'];?> </td>
                                <td> <?php echo $row['field_label'];?> </td>
                                <td><?php echo $row['value'];?></td>
                                <td class="center"> <?php echo $row['unit'];?> </td>
                                <td class="center"> <?php echo $row['type']?'Dropdown':'Input';?> </td>
                                <td class="center"> <?php echo $row['description'];?> </td>
                                <td style="text-align: center;"><a class="btn btn-primary medit" class="edit_dialog" attr_id = "<?php echo $row['id'];?>"> Edit <i class="fa fa-plus"></i></a> </td>
                                <td style="text-align: center;"><a class="btn btn-success editformula"attr_id = "<?php echo $row['field_id'];?>"> Edit Formula <i class="fa fa-edit"></i></a> </td>
                                <td style="text-align: center;">
                                <?php if(!$row['defaultfield']){?>
                                    <a class="btn grey delete" attr_id = "<?php echo $row['id'];?>" data-toggle="modal" href="#mdelete"> Delete <i class="fa fa-trash"></i></a> 
                                <?php }?>
                                </td>
                            </tr>
                            <?php
                                    //}
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- Add New start -->
    <div class="modal fade" id="formula" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Edit Formula</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="formula_desc form-control"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn green save_formula">Save</button>
                </div>
            </div>
        </div>
    </div>
<!-- Add New end -->
<!-- Edit start -->
    <div class="modal fade" id="medit" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Edit Field</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2" style="margin-top: 7px"> Field Id</div>
                        <div class="col-md-5"> <input type="text" class="form-control field_id" name="" disabled> </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2" style="margin-top: 7px"> Name</div>
                        <div class="col-md-5"> <input type="text" class="form-control name_edit" name=""> </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2" style="margin-top: 7px"> Value</div>
                        <div class="col-md-5"> 
                            <div class="row" style="margin-bottom: 0px;padding: 0px;">
                                <div class="col-md-8">
                                    <input type="text" class="form-control value_edit" name="">         
                                </div>
                                <div class="col-md-4 add_value_box" style="display: none;">
                                    <button class="btn sbold blue add_value">Add Value <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 0px;padding: 0px;">
                                <div class="col-md-12 value_container" style="display:none;margin-top: 10px;">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2" style="margin-top: 7px"> Unit</div>
                        <div class="col-md-5"> <input type="text" class="form-control unit_edit" name=""> </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2" style="margin-top: 7px"> Type</div>
                        <div class="col-md-5"> <select class="form-control fieldtype"><option value="0">Input</option><option value="1">DropDown</option></select> </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2" style="margin-top: 7px"> Description</div>
                        <div class="col-md-5"> <input type="text" class="form-control description_edit" name=""> </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn green change">Save</button>
                </div>
            </div>
        </div>
    </div>
<!-- Edit end -->
<!-- Delete start -->
    <div class="modal fade" id="mdelete" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Delete</h4>
                </div>
                <div class="modal-body" style="text-align: center"> Are You Sure? </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn green delete_save" attr_id="">Delete</button>
                </div>
            </div>
        </div>
    </div>
<!-- Delete end -->
</body>
<style type="text/css">
    td{
        text-align: center;
    }
    .item
    {
      background-color: black;
      color: white;
      padding: 5px;
      border-radius: 25px !important;
    }

    .delete_value:hover
    {
      cursor: pointer;
      color:red;
    }
</style>
<link href="./data-table/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="./data-table/css/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="./data-table/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="./data-table/css/plugins.min.css" rel="stylesheet" type="text/css" />



<script src="./data-table/js/jquery.min.js" type="text/javascript"></script>
<script src="./data-table/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./data-table/js/datatables.min.js" type="text/javascript"></script>
<script src="./data-table/js/datatables.bootstrap.js" type="text/javascript"></script>
<script src="./data-table/js/app.min.js" type="text/javascript"></script>
<script src="./data-table/js/table-datatables-managed.min.js" type="text/javascript"></script>
<script src="./js/script.js" type="text/javascript"></script>

<script>
    $(function() {
        $('#field_list').DataTable({
            aaSorting: [[0, 'desc']]
        });
    })
</script>