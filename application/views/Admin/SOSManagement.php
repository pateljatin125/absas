<?php include('include/header.php'); ?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/css/managedata.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/colorbox/colorbox.css'); ?>" />
		<script src="<?php echo base_url('assets/colorbox/jquery1.10.2.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/colorbox/jquery.colorbox.js'); ?>"></script>
		<script>
			$(document).ready(function(){
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
		
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

              <!--  <a href="https://absas.com.ng/modal/video?vidlink=https://www.absas.com.ng/Admin/uploads/fdcc83b7561742fb77364e586449a6b4.mp4"  class="iframe"><h4><b><br>I am here<br></b></h4></a> -->
                


                    <!-- START DATATABLE EXPORT -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <strong>SOS Management </strong>
                            </h3>
                            <div class="notification panel-title">
                                <span>New SOS Recieved</span>
                                <span class="badge" id="sosTotal"><?php echo $newsos[0]['newsos']; ?></span>
                            </div>
                            <?php if (isset($_SESSION['userAdd'])) { ?>
                                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
                            <?php }
                            if (isset($_SESSION['usernotAdd'])) { ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
                            <?php } ?>

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
                                                    <th>SOS ID</th>
                                                    <th>SOS Type</th>
                                                    <th>SOS Category</th>
                                                    <th>Current Location</th>
                                                    <th>Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    <th>Media</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $count = 1;

                                                foreach ($result as $itm) { ?>
                                                    <tr class="<?php echo $itm['is_read'] == 1 ? 'readnew' : '' ?>" id="sosID_<?php echo $itm['SOS_id']; ?>">
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo $itm['SOS_id']; ?></td>
                                                        <td><?php if ($itm['usertype'] == 0) {
                                                                echo 'Citizen';
                                                            } else {
                                                                echo 'Officer';
                                                            } ?></td>
                                                        <td><?php echo $itm['sos_category_name']; ?></td>
                                                        <td><?php echo $itm['current_location']; ?></td>
                                                        <td><?php echo $itm['Name']; ?></td>
                                                        <td><?php echo $itm['Phone_Number']; ?></td>
                                                        <td id="status_<?php echo $itm["SOS_id"]; ?>"><?php if ($itm['SOS_staus'] == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["SOS_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="Click to Deactivate this SOS." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["SOS_id"]; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="Click to Activate this SOS." /> </a><?php } ?></td>


                                                        <td>
                                                            <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm['SOS_id']; ?>">Edit</a>/-->
                                                            <a href="#" class="readed" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["SOS_id"]; ?>)">FeedBack/</a>

                                                            <!--<a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['SOS_id']; ?>);">Delete</span></a>-->
                                                            <a href="#" class="readed" data-toggle="modal" data-target="#exampleModal" onclick="return SOSview(<?php echo $itm["SOS_id"]; ?>)">View</a>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            $audios = json_decode($itm['images']);
                                                            if (!empty($audios)) {

                                                                for ($i = 0; $i < count($audios); $i++) {
                                                            ?>
                                                                     <?php
                                                                        $ext = pathinfo($audios[$i], PATHINFO_EXTENSION);
                                                                        $ur = '';
                                                                        if ($ext == 'mp4' || $ext == '3gp') {
                                                                            $ur = 'images/video-player.png';
                                                                            $link = 'https://absas.com.ng/modal/video?vidlink=';
                                                                        }
                                                                        if ($ext == 'mp3') {
                                                                            $ur = 'images/icons8-itunes-100.png';
                                                                            $link = 'https://absas.com.ng/modal/audio?vidlink=';
                                                                        }
                                                                        if ($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                                                                            $ur = 'images/icons8-image-100.png';
                                                                            $link = 'https://absas.com.ng/modal/picture?vidlink=';
                                                                        }
                                                                        ?>
                                                                    <a class="iframe" href="<?php echo "$link$audios[$i]"; ?>">
                                                                       
                                                                        <img src="<?php echo base_url() . $ur; ?>" width="32" height="32" title="Click to open file." />
                                                                    </a>
                                                            <?php
                                                                }
                                                            }

                                                            ?>
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
                                    <h5 class="modal-title" id="exampleModalLabel">FeedBack SOS
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <form id="" action="<?php echo base_url('FeedbackSOS'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                            <div class="row">

                                                <div class="col-md-12">


                                                    <div class="panel panel-default">


                                                        <div class="panel-body">

                                                            <div class="row">


                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Feedback</label>
                                                                    <div class="col-md-9">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                            <textarea class="form-control" name="feedback" id="feedback" required /></textarea>

                                                                            <div id="aptid"></div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Media</label>
                                                                    <div class="col-md-9">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                            <input type="file" class="form-control" name="userfile[]" accept="image/gif,image/jpg,image/png,image/jpeg,vedio/mp4,vedio/3gp" multiple>

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
                    <!-- END DEFAULT TABLE EXPORT -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">SOS Details
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
        function SOSview(SOS_id) {

            //alert(SOS_id);

            var base_url = $('#base_url').val();
            var datastring = 'SOS_id=' + SOS_id;

            //alert(datastring);
            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/SOSview',
                method: 'POST',
                data: datastring,
                success: function(response) {
                    $("#modal_body").html(response);
                    chnagenewold(SOS_id);
                }

            });




        }

        function SOSFeedback(SOS_id) {

            $('#aptid').html('<input type="hidden" class="form-control" name="SOS_id" id="SOS_id" value="' + SOS_id + '" />');

            chnagenewold(SOS_id);


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
                url: base_url + 'Admin/Newsdel',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    location.href = data;
                }
            });

        }

        function chnagenewold(sosid) {
            var base_url = $('#base_url').val();
            $.ajax({
                url: base_url + 'Admin/SOSreaded',
                method: 'POST',
                data: {
                    'sos_id': sosid,
                },
                success: function(data) {
                    $("#sosID_" + sosid).removeClass('readnew');
                    $("span#sosTotal").text(data);
                    $("span#sosTotalM").text(data);
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
                        $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="Click to Deactivate this banner." /></a>');
                        //location.href = data;
                    } else {
                        $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to Aeactive this banner." /></a>');
                    }
                    chnagenewold(event_id);
                }
            });




        }
    </script>
    </body>

    </html>