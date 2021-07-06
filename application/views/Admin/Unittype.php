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
                            <h3 class="panel-title"><strong>Office Unit Types Management</strong></h3>
                            <div class="btn-group pull-right">
                                <button class="btn btn-danger dropdown-toggle" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-bars"></i>Create New Unit Type</button>

                            </div>
                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Create New Unit Type
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h5>
                                        </div>
                                        <form id="" action="<?php echo base_url('create-unit-type'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-4 control-label">Unit Type Name</label>
                                                                            <div class="col-md-8">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="UnitTypeName" id="UnitName" required />
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
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <table id="customers2" class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th>SrNo.</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $count = 1;

                                                foreach ($Unittypes as $itm) { ?>
                                                    <tr class='' id="PoliceUnitType_<?php echo $itm['PoliceUnitType_id']; ?>">
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo $itm['PoliceUnitType_name']; ?></td>
                                                        <td id="status_<?php echo $itm["PoliceUnitType_id"]; ?>"><?php if ($itm['PoliceUnitType_status'] == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm['PoliceUnitType_id']; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to deactive this Unit Type" /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm['PoliceUnitType_id']; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to activate this Unit Type" /> </a><?php } ?></td>


                                                        <td>
                                                            <!-- <a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm['PoliceUnitType_id']; ?>">Edit</a>/ -->
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return PoliceUnitType_update(<?php echo $itm['PoliceUnitType_id']; ?>)">Edit/</a>
                                                            <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['PoliceUnitType_id']; ?>);">Delete/</span></a>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Update Unit Type
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <form id="" action="<?php echo base_url('update-unit-type'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
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

        function PoliceUnitType_update(PoliceUnitType_id) {

            //alert(PoliceUnit_id);

            var base_url = $('#base_url').val();
            var datastring = 'id=' + PoliceUnitType_id;

            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/PoliceUnitTypeEdit',
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
            // alert(datastring);
            $.ajax({
                url: base_url + 'Admin/PoliceUnitTypedel',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    $('#PoliceUnitType_' + id).remove();
                }
            });

        }

        function changeBannerStatus(status, event_id) {
            //alert(status);
            //alert(banner_id);

            var base_url = $('#base_url').val();
            var datastring = 'status='+ status +'&id='+event_id;

            $.ajax({
                url: base_url + 'Admin/UnitTypeStatus',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    // alert(data);
                    //console.log(data);
                    if (data == 1) {
                        $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to deactive this unit type" /></a>');
                        //location.href = data;
                    } else {
                        $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to activate this unit type" /></a>');

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