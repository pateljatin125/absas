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
                            <h3 class="panel-title"><strong>Manage Traffic Reports</strong></h3>
                            <?php if (isset($_SESSION['userAdd'])) { ?>
                                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
                            <?php }
                            if (isset($_SESSION['usernotAdd'])) { ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
                            <?php } ?>
                            <div class="btn-group pull-right">
                                <button class="btn btn-danger dropdown-toggle" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-bars"></i>Create Traffic Report</button>
                            </div>
                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Create Traffic Report
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h5>
                                        </div>
                                        <form id="" action="<?php echo base_url('TrafficReportsAdd'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Area</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <textarea class="form-control" name="area" id="area" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Traffic Level</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <select class="form-control" name="traffic_level" id="traffic_level" required>
                                                                                        <option value="">Select Type</option>
                                                                                        <option value="High">High</option>
                                                                                        <option value="Intermediate">Intermediate</option>
                                                                                        <option value="Low">Low</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Recommendation</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <textarea class="form-control" name="recommendation" id="recommendation" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="date" id="date" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Time</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="time" class="form-control" name="time" id="time" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Picture Of Seen</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="file" class="form-control" name="userfile[]" id="userfile" accept="image/x-png,image/gif,image/jpeg,image/jpg" multiple required />
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Attach document/image</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="file" class="form-control" name="doc" id="image" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
                                                                                    <div id="aptid"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-3"></div>
                                                                            <label class="col-md-6 control-label">Notification Target</label>
                                                                            <div class="col-md-3"></div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">User Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <select class="form-control" name="user_type" id="user_type" onchange="usertype(this.value)">
                                                                                        <option value="">All Users Type</option>
                                                                                        <option value="citizens_only">Citizens only</option>
                                                                                        <option value="officers_only">Officers only</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">LGA</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <select class="form-control" name="t_lga" id="t_lga">
                                                                                        <option value="">All LGA</option>
                                                                                        <?php
                                                                                        foreach ($state_new as $st) : ?>
                                                                                            <option value="<?php echo $st['LGA']; ?>"><?php echo $st['LGA']; ?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group tagencies">
                                                                            <label class="col-md-3 control-label">Agencies</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <select class="form-control" name="agencies" id="agencies">
                                                                                        <option value="">All Agencies</option>
                                                                                        <?php $AGENCY = unserialize(AGENCY);
                                                                                        foreach ($AGENCY as $ag) : ?>
                                                                                            <option value="<?php echo $ag; ?>"><?php echo $ag; ?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="form-group">
                                                                            <label class="col-md-3 control-label">Phone Number</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="t_phone_number" id="t_phone_number" />
                                                                                </div>
                                                                            </div>
                                                                        </div> -->

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" id="click-submit" class="btn btn-primary pull-left" value="Submit" />
                                                <input type="submit" id="submit" class="btn btn-primary pull-left hidden" value="Submit" />
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="panel panel-default tabs">
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <table id="customers2" class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th>SrNo.</th>
                                                    <th>Traffic Reports ID</th>
                                                    <th>Area</th>
                                                    <th>Traffic Level</th>
                                                    <th>Recommendation</th>
                                                    <th>Date/Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($result as $itm) { ?>
                                                    <tr class='' id="traffic<?php echo $itm['TrafficReport_id']; ?>">
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo $itm['TrafficReport_id']; ?></td>
                                                        <td><?php echo $itm['area']; ?></td>
                                                        <td><?php echo $itm['traffic_level']; ?></td>
                                                        <td><?php echo $itm['recommendation']; ?></td>
                                                        <td><?php echo $itm['date'] . '/' . $itm['time']; ?></td>
                                                        <td id="status_<?php echo $itm["TrafficReport_id"]; ?>"><?php if ($itm['TrafficReport_status'] == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["TrafficReport_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to deactive this traffic report." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["TrafficReport_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Aeactive this trafic report." /> </a><?php } ?></td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return TrafficReportsupdate(<?php echo $itm["TrafficReport_id"]; ?>)">Edit/</a>
                                                            <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['TrafficReport_id']; ?>);">Delete/</span></a>
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal" onclick="return TrafficReportsview(<?php echo $itm["TrafficReport_id"]; ?>)">View</a>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Update Traffic Report
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </h5>
                                </div>
                                <form id="" action="<?php echo base_url('TrafficReportsUpdate'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                                    <h5 class="modal-title" id="exampleModalLabel">Traffic Report Details
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



$('#click-submit').on('click',function(){
            var confirm = window.confirm('Are you sure want to publish this enotice?');
            if(confirm)
            {
                // alert('yes');
                $('#submit').click();
            }
            else
            {
                return false;
            }
        });



    $('.tagencies').hide();

    function usertype(name) {
        if (name == "officers_only") {
            $('.tagencies').show();
        } else {
            $('.tagencies').hide();
        }
    }


    function TrafficReportsview(TrafficReport_id) {
        var base_url = $('#base_url').val();
        var datastring = 'id=' + TrafficReport_id;
        $.ajax({
            url: base_url + 'Admin/TrafficReportsview',
            method: 'POST',
            data: datastring,
            success: function(response) {
                $("#modal_body").html(response);
            }
        });
    }

    function TrafficReportsupdate(TrafficReport_id) {
        var base_url = $('#base_url').val();
        var datastring = 'TrafficReport_id=' + TrafficReport_id;
        $.ajax({
            url: base_url + 'Admin/TrafficReportsedit',
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
            url: base_url + 'Admin/TrafficReportsdel',
            method: 'POST',
            data: datastring,
            success: function(data) {
                $('#traffic' + id).remove();
            }
        });
    }

    function changeBannerStatus(status, event_id) {
        var base_url = $('#base_url').val();
        var datastring = 'status=' + status + '&id=' + event_id;
        $.ajax({
            url: base_url + 'Admin/Trafficreportsstatus',
            method: 'POST',
            data: datastring,
            success: function(data) {
                if (data == 1) {
                    $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to deactive this traffic report." /></a>');
                } else {
                    $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to Aeactive this traffic report." /></a>');
                }
            }
        });
    }
</script>
</body>

</html>