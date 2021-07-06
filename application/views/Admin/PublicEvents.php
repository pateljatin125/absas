<?php include('include/header.php'); ?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/css/managedata.css'); ?>" />
<!-- START PAGE SIDEBAR -->
<div class="page-container">
    <?php include('include/left_side.php'); ?>

    <!-- PAGE CONTENT -->
    <div class="page-content">

        <!-- START X-NAVIGATION VERTICAL -->
        <?php include('include/top_nav.php'); ?>

        <div class="page-content-wrap">



            <div class="row">
                <div class="col-md-12">




                    <!-- START DATATABLE EXPORT -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Manage Public Events</strong></h3>
                            <?php if (isset($_SESSION['userAdd'])) { ?>
                                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
                            <?php }
                            if (isset($_SESSION['usernotAdd'])) { ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
                            <?php } ?>
                            <div class="btn-group pull-right">
                                <button class="btn btn-danger dropdown-toggle" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-bars"></i>Create Public Events</button>

                            </div>
                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Create Public Events
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button></h5>
                                        </div>
                                        <form id="" action="<?php echo base_url('PublicEventsAdd'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                    <div class="row">

                                                        <div class="col-md-12">


                                                            <div class="panel panel-default">


                                                                <div class="panel-body">

                                                                    <div class="row">





                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Event_Name</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="Event_Name" id="Event_Name" required />


                                                                                </div>

                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Event_Description</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <textarea class="form-control" name="Event_Description" id="Event_Description" required /></textarea>


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Event_address</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="text" class="form-control" name="Event_address" id="Event_address" required />


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Event_date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="Event_date" id="Event_date" required />


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Event_tym</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="time" class="form-control" name="Event_tym" id="Event_tym" required />
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
                                                    <th>PublicEvent_id</th>
                                                    <th>Event_Name</th>
                                                    <th>Event_Description</th>
                                                    <th>Event_address</th>
                                                    <th>Date/Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $count = 1;

                                                foreach ($result as $itm) { ?>
                                                    <tr class='' id="pub<?php echo $itm['PublicEvent_id']; ?>">
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo $itm['PublicEvent_id']; ?></td>
                                                        <td><?php echo $itm['Event_Name']; ?></td>
                                                        <td><?php echo $itm['Event_Description']; ?></td>
                                                        <td><?php echo $itm['Event_address']; ?></td>
                                                        <td><?php echo $itm['Event_date'] . '/' . $itm['Event_tym']; ?></td>
                                                        <td id="status_<?php echo $itm["PublicEvent_id"]; ?>"><?php if ($itm['Event_status'] == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["PublicEvent_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to deactive this SOS." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["PublicEvent_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Aeactive this SOS." /> </a><?php } ?></td>


                                                        <td>
                                                            <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm['PublicEvent_id']; ?>">Edit</a>/-->
                                                            <a href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return PublicEventsdupdate(<?php echo $itm["PublicEvent_id"]; ?>)">Edit/</a>

                                                            <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['PublicEvent_id']; ?>);">Delete</span></a>
                                                            <!--<a  href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return PublicEventsview(<?php echo $itm["PublicEvent_id"]; ?>)">View</a>-->
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
                                    <h5 class="modal-title" id="exampleModalLabel">Update Public Events
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <form id="" action="<?php echo base_url('PublicEventsUpdate'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                            <div class="row">

                                                <div class="col-md-12">


                                                    <div class="panel panel-default">


                                                        <div class="panel-body">

                                                            <div class="row" id="modal_body">







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
                                    <h5 class="modal-title" id="exampleModalLabel">Public Events Details
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

        function PublicEventsview(PublicEvent_id) {

            //alert(PublicEvent_id);

            var base_url = $('#base_url').val();
            var datastring = 'PublicEvent_id=' + PublicEvent_id;

            //alert(datastring);
            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/PublicEventsview',
                method: 'POST',
                data: datastring,
                success: function(response) {
                    $("#modal_body").html(response);
                }

            });




        }

        function PublicEventsdupdate(PublicEvent_id) {

            var base_url = $('#base_url').val();
            var datastring = 'PublicEvent_id=' + PublicEvent_id;

            //alert(datastring);
            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/PublicEventsdit',
                method: 'POST',
                data: datastring,
                success: function(response) {
                    $("#modal_body").html(response);
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
                url: base_url + 'Admin/PublicEventsdel',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    $('#pub' + id).remove();
                }
            });

        }

        function changeBannerStatus(status, event_id) {
            //alert(status);
            //alert(banner_id);

            var base_url = $('#base_url').val();
            var datastring = 'status=' + status + '&id=' + event_id;

            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/PublicEventsstatus',
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
    </script>
    </body>

    </html>