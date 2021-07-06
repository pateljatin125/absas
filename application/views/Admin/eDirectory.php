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
                            <h3 class="panel-title"><strong>Manage eDirectory</strong></h3>
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
                                                    <th>Directory ID</th>
                                                    <th>Name</th>
                                                    <th>Place</th>
                                                    <th>Business Category</th>
                                                    <th>User Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Status</th>
                                                    <th><center> Action</center></th>
                                                    <th>Promote</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($result as $itm) { ?>
                                                    <tr class='' id="directory<?php echo $itm['directory_id']; ?>">
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo $itm['directory_id']; ?></td>
                                                        <td><?php echo $itm['name']; ?></td>
                                                        <td><?php echo $itm['place']; ?></td>
                                                        <td><?php echo $itm['business_name']; ?></td>
                                                        <td><?php echo $itm['user_name']; ?></td>
                                                        <td><?php echo $itm['phone_number']; ?></td>
                                                        <td id="status_<?php echo $itm["directory_id"]; ?>"><?php if ($itm['is_active'] == 0) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["directory_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Deactivate this eDirectory." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["directory_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Activate this eDirectory." /> </a><?php } ?></td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal1" title="Edit" onclick="return eDirectoryupdate(<?php echo $itm["directory_id"]; ?>)"><span class="fa fa-pencil-square-o" style="font-size: 18px"></span></a>
                                                            <a href="javascript:void(0)" title="Delete"><span onClick="return doconfirm(<?php echo $itm['directory_id']; ?>);"><span class="fa fa-trash-o" style="font-size: 18px"></span></span></a>
                                                            <a href="#" data-toggle="modal" title="View" data-target="#exampleModal" onclick="return eDirectoryview(<?php echo $itm["directory_id"]; ?>)"><span class="fa fa-eye" style="font-size: 18px"></span></a>
                                                        </td>
                                                        <td class="prm_<?php echo $itm["directory_id"]; ?>"><a href="javascript:void(0);" title="<?php echo ($itm["is_promoted"] == 1 ? "Unpromote this business." : "Promote this business.") ?>" onclick="return eDirectoryPromote(<?php echo ($itm["is_promoted"] == 1 ? 0 : 1); ?>,<?php echo $itm["directory_id"]; ?>)"><span class="fa fa-bullhorn" style="font-size: 18px;<?php echo ($itm["is_promoted"] == 1?'color: green;':'') ?>"></span></a></td>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Update eDirectory
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </h5>
                                </div>
                                <form id="" action="<?php echo base_url('eDirectoryUpdate'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="row" id="modal_body1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <h5 class="modal-title" id="exampleModalLabel">eDirectory Details
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </h5>
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
</div>
<?php include('include/mange_script.php'); ?>
<script>
    function eDirectoryview(directory_id) {
        var base_url = $('#base_url').val();
        var datastring = 'id=' + directory_id;
        $.ajax({
            url: base_url + 'Admin/eDirectoryview',
            method: 'POST',
            data: datastring,
            success: function(response) {
                $("#modal_body").html(response);
            }
        });
    }

    function eDirectoryupdate(directory_id) {
        var base_url = $('#base_url').val();
        var datastring = 'directory_id=' + directory_id;
        $.ajax({
            url: base_url + 'Admin/eDirectoryedit',
            method: 'POST',
            data: datastring,
            success: function(response) {
                $("#modal_body1").html(response);
            }
        });
    }

    function doconfirm(id) {
        job = confirm("Are you sure to delete permanently?");
        if (job != true) {
            return false;
        }
        var base_url = $('#base_url').val();
        var datastring = 'id=' + id;
        $.ajax({
            url: base_url + 'Admin/eDirectorydel',
            method: 'POST',
            data: datastring,
            success: function(data) {
                $('#directory' + id).remove();
            }
        });
    }

    function eDirectoryPromote(status, event_id) {
        var base_url = $('#base_url').val();
        var datastring = 'status=' + status + '&id=' + event_id;
        $.ajax({
            url: base_url + 'Admin/eDirectoryPromote',
            method: 'POST',
            data: datastring,
            success: function(data) {

                $('.prm_' + event_id).html('<a href="javascript:void(0);" title="' + (data == 1 ? "Unpromote this business." : "Promote this business.") + '" onclick="return eDirectoryPromote(' + (data == 1 ? 0 : 1) + ',' + event_id + ')"><span class="fa fa-bullhorn" style="font-size: 18px;'+ (data == 1 ? "color: green;" : "") +'"></span></a>');

            }
        });
    }

    function changeBannerStatus(status, event_id) {
        var base_url = $('#base_url').val();
        var datastring = 'status=' + status + '&id=' + event_id;
        $.ajax({
            url: base_url + 'Admin/eDirectorystatus',
            method: 'POST',
            data: datastring,
            success: function(data) {
                if (data == 0) {
                    $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to Deactive this eDirectory." /></a>');
                } else {
                    $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to Aeactive this eDirectory." /></a>');
                }
            }
        });
    }
</script>
</body>

</html>