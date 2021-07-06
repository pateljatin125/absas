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
                            <h3 class="panel-title"><strong>Office Unit Management</strong></h3>
                            <?php if (isset($_SESSION['userAdd'])) { ?>
                                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
                            <?php }
                            if (isset($_SESSION['usernotAdd'])) { ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
                            <?php } ?>
                            <div class="btn-group pull-right">
                                <button class="btn btn-danger dropdown-toggle" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-bars"></i>Create Agency Unit</button>

                            </div>
                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Create Agency Unit
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h5>
                                        </div>
                                        <form id="" action="<?php echo base_url('CreateUnit'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Unit Name</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="UnitName" id="UnitName" required />
                                                                                    <input type="hidden" class="form-control" name="State" id="State" value="Abia" readonly required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Unit Address</label>

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Street</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="Street" id="Street" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">City</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="City" id="City" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">LGA</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <select class="form-control" name="LGA" id="statelga" required>
                                                                                        <option value="">Select LGA</option>
                                                                                        <?php foreach ($state_new as $itm) { ?>
                                                                                            <option value="<?php echo $itm['LGA']; ?>"><?php echo $itm['LGA']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Latitude</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="Latitude" id="Latitude" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Longitude</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="Longitude" id="Longitude" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Unit Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <!-- <select class="form-control" name="UnitType" id="UnitType" onchange="unittype(this.value)" required> -->
                                                                                    <select class="form-control" name="UnitType" id="UnitType" required>
                                                                                        <option value="">Select Unit Type</option>
                                                                                        <?php foreach ($unit_types as $itm) { ?>
                                                                                            <option value="<?php echo $itm['PoliceUnitType_name']; ?>"><?php echo $itm['PoliceUnitType_name']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style="display:none;" id="VehicleType">
                                                                            <label class="col-md-3 control-label">Vehicle Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="VehicleType" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style="display:none;" id="PlateNumber">
                                                                            <label class="col-md-3 control-label">Plate Number</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="PlateNumber" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style="display:none;" id="DepartmentAssigned">
                                                                            <label class="col-md-3 control-label">Unit/Department Assigned</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="DepartmentAssigned" id="" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style="display:none;" id="PatrolLocations">
                                                                            <label class="col-md-3 control-label">Patrol Locations</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="PatrolLocations[]" id="" />
                                                                                </div>
                                                                            </div>
                                                                            <a href="javascript:void(0)" onclick="addlocation()" style="margin-right: 80px;width: 10px;float: right;margin-top:10px;"><span class="input-group-addon">ADD More</span></a>
                                                                        </div>


                                                                        <div id="adt"></div>
                                                                        <br>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Contact Number</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="ContactNumber" id="ContactNumber" required />


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Special identifier</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="Specialidentifier" id="Specialidentifier" />


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Head of Unit</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="HeadUnit" id="HeadUnit" />


                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>




                                            </div>
                                            <div class="modal-footer">
                                                <input type="Submit" class="btn btn-primary pull-left" value="Submit" />
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="panel-body">
                            <div class="panel panel-default tabs">
                                <!--<ul class="nav nav-tabs nav-justified">
<li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">HTML</a></li>
<li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false">CSS</a></li>
<li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false">Javascript</a></li>
</ul>-->
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <table id="customers2" class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th>SrNo.</th>
                                                    <th>Agency ID</th>
                                                    <th>Unit Name</th>
                                                    <th>Unit Type</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <!--<th>Status</th>-->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $count = 1;

                                                foreach ($result as $itm) { ?>
                                                    <tr class='' id="PoliceUnit<?php echo $itm['PoliceUnit_id']; ?>">
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo $itm['PoliceUnit_id']; ?></td>
                                                        <td><?php echo $itm['UnitName']; ?></td>
                                                        <td><?php echo $itm['UnitType']; ?></td>
                                                        <td><?php echo $itm['Latitude']; ?></td>
                                                        <td><?php echo $itm['Longitude']; ?></td>
                                                        <!--<td id="status_<?php echo $itm["PoliceUnit_id"]; ?>"><?php if ($itm['PoliceUnit_status'] == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["PoliceUnit_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to deactive this SOS." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["PoliceUnit_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Aeactive this SOS." /> </a><?php } ?></td>-->


                                                        <td>
                                                            <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm['PoliceUnit_id']; ?>">Edit</a>/-->
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return PoliceUnitupdate(<?php echo $itm["PoliceUnit_id"]; ?>)">Edit/</a>

                                                            <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['PoliceUnit_id']; ?>);">Delete/</span></a>
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal" onclick="return PoliceUnitview(<?php echo $itm["PoliceUnit_id"]; ?>)">View</a>
                                                            <a target="_blank" href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo $itm['Latitude']; ?>,<?php echo $itm['Longitude']; ?>">Map</a>
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
                    <!-- END DATATABLE EXPORT -->

                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Agency Unit
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <form id="" action="<?php echo base_url('UpdatePoliceUnit'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                    <!-- END DEFAULT TABLE EXPORT -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agency Details
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
        <!-- END PAGE CONTENT WRAPPER -->
    </div>


    <!-- START PRELOADS -->
    <?php include('include/mange_script.php'); ?>
    <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    <script>
        // function unittype(name) {
        //     if (name == 'Patrol Unit') {
        //         $('#VehicleType').show();
        //         $('#PlateNumber').show();
        //         $('#DepartmentAssigned').show();
        //         $('#PatrolLocations').show();
        //     } else {
        //         $('#VehicleType').hide();
        //         $('#PlateNumber').hide();
        //         $('#DepartmentAssigned').hide();
        //         $('#PatrolLocations').hide();
        //     }
        // }

        // function unittype1(name) {

        //     if (name == 'Patrol Unit') {
        //         $('#VehicleType1').show();
        //         $('#PlateNumber1').show();
        //         $('#DepartmentAssigned1').show();
        //         $('#PatrolLocations1').show();


        //     } else {
        //         $('#VehicleType1').hide();
        //         $('#PlateNumber1').hide();
        //         $('#DepartmentAssigned1').hide();
        //         $('#PatrolLocations1').hide();

        //     }

        // }

        function PoliceUnitview(PoliceUnit_id) {

            //alert(PoliceUnit_id);

            var base_url = $('#base_url').val();
            var datastring = 'id=' + PoliceUnit_id;

            //alert(datastring);
            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/PoliceUnitview',
                method: 'POST',
                data: datastring,
                success: function(response) {
                    //alert(response)
                    $("#modal_body").html(response);
                }

            });




        }

        function PoliceUnitupdate(PoliceUnit_id) {

            //alert(PoliceUnit_id);

            var base_url = $('#base_url').val();
            var datastring = 'id=' + PoliceUnit_id;

            //alert(datastring);
            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/PoliceUnitEdit',
                method: 'POST',
                data: datastring,
                success: function(response) {
                    $("#modal_body1").html(response);
                }

            });




        }

        function lga(state) {

            var base_url = $('#base_url').val();
            var datastring = 'state=' + state;

            //alert(datastring);
            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/lgaall',
                method: 'POST',
                data: datastring,
                success: function(response) {
                    $("#statelga").html(response);
                }

            });




        }

        function doconfirm(id) {
            //alert(id);
            job = confirm("Are you sure to delete permanently?");
            if (job != true) {
                return false;
            }
            var base_url = $('#base_url').val();
            var datastring = 'id=' + id;
            //alert(datastring);
            $.ajax({
                url: base_url + 'Admin/PoliceUnitdel',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    $('#PoliceUnit' + id).remove();
                }
            });

        }

        function changeBannerStatus(status, event_id) {
            //alert(status);
            //alert(banner_id);

            var base_url = $('#base_url').val();
            var datastring = 'status=' + status + '&SOSid=' + event_id;

            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/SOSStatus',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    //alert(data);
                    //console.log(data);
                    if (data == 1) {
                        $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to deactive this banner." /></a>');
                        //location.href = data;
                    } else {
                        $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to Aeactive this banner." /></a>');

                    }
                }
            });




        }


        function addlocation() {

            $('#adt').append('<div class="form-group"  id="PatrolLocations"><label class="col-md-3 control-label">Patrol Locations</label><div class="col-md-9"><div class="input-group"><span class="input-group-addon"><span class="fa fa-pencil"></span></span><input type="text" class="form-control" name="PatrolLocations[]" id=""  /></div></div></div>');
        }
    </script>
    </body>

    </html>