<?php include('include/header.php'); ?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/css/managedata.css'); ?>" />
<div class="page-container">
    <?php include('include/left_side.php'); ?>
    <div class="page-content">
        <?php include('include/top_nav.php'); ?>
        <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>MANAGE All Officer Logs </strong></h3>
                            <?php if (isset($_SESSION['userAdd'])) { ?>
                                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
                            <?php }
                            if (isset($_SESSION['usernotAdd'])) { ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
                            <?php } ?>
                        </div>
                        <div class="panel-body">
                            <div class="panel panel-default tabs">
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <table id="customers2" class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th>SrNo.</th>
                                                    <th>Log ID</th>
                                                    <th><?php echo ucfirst('Officer name'); ?></th>
                                                    <th>Officer Phone</th>
                                                    <th>IMEI</th>
                                                    <th>Device Manufacturer</th>
                                                    <th>Device ModelNo</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $count = 1;

                                                foreach ($result_new as $itm) { ?>
                                                    <tr class="user_<?php echo $itm->Officer_id; ?>" id="log_<?php echo $itm->log_id; ?>">
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $itm->log_id; ?></td>
                                                        <td><?php echo $itm->Full_Name; ?></td>
                                                        <td><?php echo $itm->phone; ?></td>
                                                        <td><?php echo $itm->imei; ?></td>
                                                        <td><?php echo $itm->device_manufacturer; ?></td>
                                                        <td><?php echo $itm->device_modelNo; ?></td>
                                                        <td>
                                                            <?php if ($itm->is_login == 0) { ?>
                                                                <img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="Deactive User." />
                                                            <?php } else { ?>
                                                                <img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="Aeactive User." /><?php } ?>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="user_<?php echo $itm->Officer_id; ?>" data-toggle="modal" data-target="#exampleModal" onclick="return viewLog(<?php echo $itm->log_id; ?>)">View</a>
                                                            <?php if ($itm->is_login == 0) { ?>
                                                                / <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm->log_id; ?>);"> Delete</span></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php $count++;
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit User Details
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <form id="" action="<?php echo base_url('Updateuser'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="modal-footer">
                                        <input type="Submit" class="btn btn-primary pull-left" value="Update" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Officer Log Details
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                        <div class="row" id="modal_body">
                                            ...
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include('include/mange_script.php'); ?>
    <script>
        function viewLog(user_id) {
            var base_url = $('#base_url').val();
            var datastring = user_id;
            $.ajax({
                url: base_url + 'Admin/ViewUserLog',
                method: 'POST',
                data: {
                    'log_id': datastring,
                    'user_type': '2'
                },
                success: function(response) {
                    $("#modal_body").html(response);
                }
            });
        }

        function doconfirm(id) {
            job = confirm("Are you sure to delete permanently?");
            if (job != true) {
                return false;
            }
            var base_url = $('#base_url').val();
            var datastring = id;
            $.ajax({
                url: base_url + 'Admin/userlogdel',
                method: 'POST',
                data: {
                    'log_id': datastring,
                    'user_type': '2'
                },
                success: function(data) {
                    $('#log_' + id).remove();
                }
            });

        }
    </script>
    </body>

    </html>