<html lang="en">

<head>
    <!-- META SECTION -->
    <title>Mypolice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="baseUrl" id="base_url" content="<?php echo base_url(); ?>">
    <link rel="icon" href="<?php echo base_url('/assets/admin/'); ?>img/asas_logo.png" sizes="16x16 32x32" type="image/png">
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/admin/css/theme-default.css'); ?>" />
    <!-- EOF CSS INCLUDE -->
    <!-- START PRELOADS -->
    <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
    <!-- START PLUGINS -->

    <!-- END SCRIPTS -->

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/jquery/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap.min.js '); ?>"></script>
    <!-- END PLUGINS -->

    <!-- START THIS PAGE PLUGINS-->
    <script type='text/javascript' src="<?php echo base_url('assets/admin/js/plugins/icheck/icheck.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/scrolltotop/scrolltopcontrol.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/morris/raphael-min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/morris/morris.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/rickshaw/d3.v3.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/rickshaw/rickshaw.min.js'); ?>"></script>
    <script type='text/javascript' src="<?php echo base_url('assets/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
    <script type='text/javascript' src="<?php echo base_url('assets/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
    <script type='text/javascript' src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap-datepicker.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/owl/owl.carousel.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/moment.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- END THIS PAGE PLUGINS-->

    <!-- START TEMPLATE -->
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/settings.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/actions.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/demo_dashboard.js'); ?>"></script>
    <!-- END TEMPLATE -->
    <script>
        function reportfilter(id) {
            if (id == 1) {
                $("#ReportPopularity").trigger("click");
            } else if (id == 2) {
                $("#ReportLocation").trigger("click");
            } else if (id == 4) {
                //$("#ReportDuration").trigger("click");
                $("#ReportState").trigger("click");
            } else if (id == 5) {
                $("#ReportResponsetime").trigger("click");
            }



        }

        function typerop(id, type) {

            //alert(id)
            var base_url = $('#base_url').val();
            var datastring = 'id=' + id + '&type=' + type;

            //alert(datastring);
            $.ajax({
                url: base_url + 'Admin/Reporttype',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    //alert(data);
                    //console.log(data);
                    if (type == 2) {
                        $('#locationtype').html(data);
                    } else if (type == 4) {
                        $('#satetype').html(data);
                    } else if (type == 5) {
                        $('#restype').html(data);
                    }


                }
            });


        }
    </script>
</head>

<body>
    <audio id="audio-alert" src="<?php echo base_url('assets/admin/audio/alert.mp3'); ?>" preload="auto"></audio>
    <audio id="audio-fail" src="<?php echo base_url('assets/admin/audio/fail.mp3'); ?>" preload="auto"></audio>
    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to log out?</p>
                    <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <a href="<?php echo base_url('Admin/logout'); ?>" class="btn btn-success btn-lg">Yes</a>
                        <button class="btn btn-default btn-lg mb-control-close">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <div class="panel-heading col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="panel-title"><strong>Crime Map </strong></h3>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span style="font-size: 14px;margin-top:3px;display:inline-block">View By Report Category</span>
                                        <select class="form-control pull-right" style="width:200px;" onchange="reportfilter(this.value)">

                                            <option value="0">Search By</option>
                                            <option value="1">Popularity</option>
                                            <option value="2">Location</option>
                                            <option value="4">Local Government</option>
                                            <option value="5">Response time</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display:none;">
                                    <a href="#" data-toggle="modal" id="ReportPopularity" data-target="#exampleModal1">Edit/</a>
                                    <a href="#" data-toggle="modal" id="ReportLocation" data-target="#exampleModal2">Edit/</a>

                                    <a href="#" data-toggle="modal" id="ReportState" data-target="#exampleModal4">Edit/</a>
                                    <a href="#" data-toggle="modal" id="ReportResponsetime" data-target="#exampleModal5">Edit/</a>
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
                                            <style>
                                                /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
                                                #mapCanvas {
                                                    height: 50%;
                                                }

                                                /* Optional: Makes the sample page fill the window. */
                                            </style>


                                            <div id="mapCanvas"></div>
                                            <script>
                                                function initMap() {
                                                    var map;
                                                    var bounds = new google.maps.LatLngBounds();
                                                    var mapOptions = {
                                                        //mapTypeId: 'roadmap'
                                                        center: {
                                                            lat: 9.072264,
                                                            lng: 7.491302
                                                        }
                                                    };


                                                    // Display a map on the web page
                                                    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
                                                    map.setTilt(50);


                                                    //      var jArray = [{"current_location_id":"8","driver_id":"14","driver_Latitude":"17.4229795","driver_Longitude":"78.5186952","driver_fullname":"Sid","driver_fathername":"Sid","driver_email":"sid@gmail.com","email_verify_code":"0","driver_email_verify_status":"0","driver_phone_verify_status":"0","password":"12345","driver_phone":"7999940350","otp":"Expire","driver_adddress":"1234","driver_country":"101","driver_state":"36","driver_city":"29","driver_dob":"16-1-2019","drivinng_license_no":"1345","vehical_type":"2","vehical_no":"133566","vehical_registration_no":"","expire_date":"16-1-2019","pan_social_security_no":"1245","photo_social_securty":"https:\/\/vaaucouriers.com\/uploads\/f5c9b813d3cf9eb574ed307edfab27c7.jpeg","driver_status":"1","Device_type":"ANDROID","driver_photo":"https:\/\/vaaucouriers.com\/uploads\/ab79b7d66968a7f0e246480d889f8b54.jpeg","driver_rc":"https:\/\/vaaucouriers.com\/uploads\/166a086777963bef0f656666b90b3e48.jpeg","driver_fcm_tokenid":"eiPRvCM6HNE:APA91bFh-MBM_4ZJENSODLDYnBAxySqM4XZ81TyDLoN2Uz0KJ4pZa6syozD_vd2W_QA8o43q8y6a9pbXKYfznIgejTYPCIlwlFREGDVYvyDi1dp6Xb4evfhLLzaoia48BREeSatJ2mlP","driver_license_photo":"https:\/\/vaaucouriers.com\/uploads\/c2caa31f9dd971e9b3d63f0e73ac3083.jpeg","create_date":"16\/01\/2019 04:02:05 PM","onli_off_id":"8","online_status":"yes"},{"current_location_id":"15","driver_id":"35","driver_Latitude":"17.3549158","driver_Longitude":"78.5541052","driver_fullname":"Srinivas","driver_fathername":"A Pentaya","driver_email":"rosy@mailinator.com","email_verify_code":"0","driver_email_verify_status":"0","driver_phone_verify_status":"0","password":"srinivas123","driver_phone":"9849969277","otp":"Expire","driver_adddress":"Ramnagar X Road","driver_country":"101","driver_state":"36","driver_city":"29","driver_dob":"27091978","drivinng_license_no":"DLFAP0093974320","vehical_type":"2","vehical_no":"TS09ES7923","vehical_registration_no":"TS09ES7923","expire_date":"16-04-2019","pan_social_security_no":"635751562380","photo_social_securty":"https:\/\/www.vaaucouriers.com\/uploads\/c0007e3c90deb73cfb1ae162825a48d1.jpeg","driver_status":"1","Device_type":"iOS","driver_photo":"https:\/\/www.vaaucouriers.com\/uploads\/644bc9b90eb426678b820f5fc2253b52.jpeg","driver_rc":"https:\/\/vaaucouriers.com\/uploads\/906723fa39091ea93a29f177b1ff050e.jpg","driver_fcm_tokenid":"ch1mwpl0_es:APA91bE9-_8ZL11MnhgoCDTZ-aO3gzjZzbpflXw1FFCdwZnjH7x4TKixoUkmHonJUhi3QVh32xedw-LiNwszjH4740VTmXjfKLGBeJYQnGOM3ZE6qMi-iujm8dUa9IPeLytkQBDljRUf","driver_license_photo":"https:\/\/www.vaaucouriers.com\/uploads\/","create_date":"16\/04\/2019 12:39:18 PM","onli_off_id":"16","online_status":"yes"}];
                                                    //      console.log(jArray);

                                                    //      for(var i=0; i<jArray.length; i++){
                                                    //     //alert(jArray[i]['driver_id']);
                                                    // }
                                                    // Multiple markers location, latitude, and longitude
                                                    var markers = [];
                                                    var icon = [];

                                                    <?php if (isset($resultsos)) {
                                                        foreach ($resultsos as $itm) { ?>

                                                            <?php if ($itm['sos_category_id'] == 1) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/kidnap.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 2) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/robbery.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 3) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/rape.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 4) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/cartheft.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 5) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/burglary.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 6) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/terrorist.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 7) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/drug.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 8) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 9) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 10) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 11) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } elseif ($itm['sos_category_id'] == 12) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/sosicon/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                            <?php } ?>
                                                            markers.push([<?php echo "'" . $itm['sos_category_name'] . "'"; ?>, <?php echo $itm['lat']; ?>, <?php echo $itm['lang']; ?>, 4]);
                                                    <?php }
                                                    }  ?>

                                                    <?php if (isset($result)) {
                                                        if (!empty($result)) {
                                                            foreach ($result as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/iwitness.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['iWitness', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }

                                                    if (isset($result1)) {
                                                        if (!empty($result1)) {
                                                            foreach ($result1 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/officerconduct.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Officer Conduct', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result2)) {
                                                        if (!empty($result2)) {
                                                            foreach ($result2 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/commendofficer.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Commend Officer', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result3)) {
                                                        if (!empty($result3)) {
                                                            foreach ($result3 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/stolenvehicle.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Stolen vehicle', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result4)) {
                                                        if (!empty($result4)) {
                                                            foreach ($result4 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/missingpersons.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Missing Persons', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result5)) {
                                                        if (!empty($result5)) {
                                                            foreach ($result5 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/lodgecomplain.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Lodge a complaint', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result6)) {
                                                        if (!empty($result6)) {
                                                            foreach ($result6 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/others.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Gun Violence', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result7)) {
                                                        if (!empty($result7)) {
                                                            foreach ($result7 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/drugabuse.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Drug Abuse', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result8)) {
                                                        if (!empty($result8)) {
                                                            foreach ($result8 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/domesticviolence.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Domestic Violence', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result9)) {
                                                        if (!empty($result9)) {
                                                            foreach ($result9 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/terroristattack.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Terrorist Attack', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result10)) {
                                                        if (!empty($result10)) {
                                                            foreach ($result10 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/rape.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Rape', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result11)) {
                                                        if (!empty($result11)) {
                                                            foreach ($result11 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/kidnap.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Kidnap', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result12)) {
                                                        if (!empty($result12)) {
                                                            foreach ($result12 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/robbery.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Robbery', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result13)) {
                                                        if (!empty($result13)) {
                                                            foreach ($result13 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/burglary.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Burglary', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result14)) {
                                                        if (!empty($result14)) {
                                                            foreach ($result14 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/cybercrime.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Cybercrime', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result15)) {
                                                        if (!empty($result15)) {
                                                            foreach ($result15 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/submittip.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Submit a Tip', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result16)) {
                                                        if (!empty($result16)) {
                                                            foreach ($result16 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/others.svg", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Other Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result17)) {
                                                        if (!empty($result17)) {
                                                            foreach ($result17 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Vandalism Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result18)) {
                                                        if (!empty($result18)) {
                                                            foreach ($result18 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Fire Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result19)) {
                                                        if (!empty($result19)) {
                                                            foreach ($result19 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Accident Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result20)) {
                                                        if (!empty($result20)) {
                                                            foreach ($result20 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Medical Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result21)) {
                                                        if (!empty($result21)) {
                                                            foreach ($result21 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Riot Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result22)) {
                                                        if (!empty($result22)) {
                                                            foreach ($result22 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Environmental Hazard Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result23)) {
                                                        if (!empty($result23)) {
                                                            foreach ($result23 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Child Abuse Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result24)) {
                                                        if (!empty($result24)) {
                                                            foreach ($result24 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Human Trafficking Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php
                                                    if (isset($result25)) {
                                                        if (!empty($result25)) {
                                                            foreach ($result25 as $itm) { ?>
                                                                icon.push({
                                                                    url: "<?php echo base_url(); ?>/assets/img/filereport/all.png", // url
                                                                    scaledSize: new google.maps.Size(30, 30), // scaled size
                                                                    origin: new google.maps.Point(0, 0), // origin
                                                                    anchor: new google.maps.Point(0, 0) // anchor
                                                                });
                                                                markers.push(['Blow a Whistle Reports', <?php echo $itm['GeoLocation_lat']; ?>, <?php echo $itm['GeoLocation_lag']; ?>, 4]);
                                                    <?php }
                                                        }
                                                    } ?>

                                                    console.log(markers);

                                                    var infoWindowContent = [];

                                                    <?php
                                                    if (isset($resultsos)) {
                                                        if (!empty($resultsos)) {
                                                            foreach ($resultsos as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['SOS_id']; ?>\/<?php echo $itm['sos_category_name']; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return SOSview(<?php echo $itm["SOS_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result)) {
                                                        if (!empty($result)) {
                                                            foreach ($result as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['iWitness_id']; ?>\/<?php echo 'iWitness'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview(<?php echo $itm["iWitness_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result1)) {
                                                        if (!empty($result1)) {
                                                            foreach ($result1 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['OfficerAbuse_id']; ?>\/<?php echo 'OfficerAbuse'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview1(<?php echo $itm["OfficerAbuse_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result2)) {
                                                        if (!empty($result2)) {
                                                            foreach ($result2 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['CommendOffice_id']; ?>\/<?php echo 'CommendOffice'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview2(<?php echo $itm["CommendOffice_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result3)) {
                                                        if (!empty($result3)) {
                                                            foreach ($result3 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['StolenVehicle_report_id']; ?>\/<?php echo 'StolenVehicle'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview3(<?php echo $itm["StolenVehicle_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result4)) {
                                                        if (!empty($result4)) {
                                                            foreach ($result4 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Missing_Persons_report_id']; ?>\/<?php echo 'Missing Persons'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview4(<?php echo $itm["Missing_Persons_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result5)) {
                                                        if (!empty($result5)) {
                                                            foreach ($result5 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Lodgecomplaint_report_id']; ?>\/<?php echo 'Lodgecomplaint'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview5(<?php echo $itm["Lodgecomplaint_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result6)) {
                                                        if (!empty($result6)) {
                                                            foreach ($result6 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['GunViolence_id']; ?>\/<?php echo 'GunViolence'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview6(<?php echo $itm["GunViolence_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result7)) {
                                                        if (!empty($result7)) {
                                                            foreach ($result7 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['DrugAbuse_report_id']; ?>\/<?php echo 'DrugAbuse'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview7(<?php echo $itm["DrugAbuse_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result8)) {
                                                        if (!empty($result8)) {
                                                            foreach ($result8 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['DomesticViolence_report_id']; ?>\/<?php echo 'DomesticViolence'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview8(<?php echo $itm["DomesticViolence_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result9)) {
                                                        if (!empty($result9)) {
                                                            foreach ($result9 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['TerroristAttack_report_id']; ?>\/<?php echo 'TerroristAttack'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview9(<?php echo $itm["TerroristAttack_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result10)) {
                                                        if (!empty($result10)) {
                                                            foreach ($result10 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Rape_report_id']; ?>\/<?php echo 'Rape'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview10(<?php echo $itm["Rape_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result11)) {
                                                        if (!empty($result11)) {
                                                            foreach ($result11 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Kidnap_report_id']; ?>\/<?php echo 'Kidnap'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview11(<?php echo $itm["Kidnap_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result12)) {
                                                        if (!empty($result12)) {
                                                            foreach ($result12 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Robbery_report_id']; ?>\/<?php echo 'Robbery'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview12(<?php echo $itm["Robbery_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result13)) {
                                                        if (!empty($result13)) {
                                                            foreach ($result13 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Burglary_report_id']; ?>\/<?php echo 'Burglary'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview13(<?php echo $itm["Burglary_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result14)) {
                                                        if (!empty($result14)) {
                                                            foreach ($result14 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['CybercrimeFraud_report_id']; ?>\/<?php echo 'Cybercrime'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview14(<?php echo $itm["CybercrimeFraud_report_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result15)) {
                                                        if (!empty($result15)) {
                                                            foreach ($result15 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Submit_Tip_id']; ?>\/<?php echo 'Submit a Tip'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview15(<?php echo $itm["Submit_Tip_id"]; ?>)'>See details</a><\/div>"]);
                                                            <?php }
                                                        }
                                                    }
                                                    if (isset($result16)) {
                                                        if (!empty($result16)) {
                                                            foreach ($result16 as $itm) { ?>

                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Others_report_id']; ?>\/<?php echo 'Other Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview16(<?php echo $itm["Others_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result17)) {
                                                        if (!empty($result17)) {
                                                            foreach ($result17 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Vandalism_report_id']; ?>\/<?php echo 'Vandalism Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview17(<?php echo $itm["Vandalism_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result18)) {
                                                        if (!empty($result18)) {
                                                            foreach ($result18 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Fire_report_id']; ?>\/<?php echo 'Fire Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview18(<?php echo $itm["Fire_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result19)) {
                                                        if (!empty($result19)) {
                                                            foreach ($result19 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Accident_report_id']; ?>\/<?php echo 'Accident Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview19(<?php echo $itm["Accident_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result20)) {
                                                        if (!empty($result20)) {
                                                            foreach ($result20 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Medical_report_id']; ?>\/<?php echo 'Medical Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview20(<?php echo $itm["Medical_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result21)) {
                                                        if (!empty($result21)) {
                                                            foreach ($result21 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Riot_report_id']; ?>\/<?php echo 'Riot Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview21(<?php echo $itm["Riot_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result22)) {
                                                        if (!empty($result22)) {
                                                            foreach ($result22 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Environmental_Hazard_report_id']; ?>\/<?php echo 'Environmental Hazard Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview22(<?php echo $itm["Environmental_Hazard_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result23)) {
                                                        if (!empty($result23)) {
                                                            foreach ($result23 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Child_Abuse_report_id']; ?>\/<?php echo 'Child Abuse Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview23(<?php echo $itm["Child_Abuse_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result24)) {
                                                        if (!empty($result24)) {
                                                            foreach ($result24 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Human_Trafficking_report_id']; ?>\/<?php echo 'Human Trafficking Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview24(<?php echo $itm["Human_Trafficking_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>
                                                    <?php if (isset($result25)) {
                                                        if (!empty($result25)) {
                                                            foreach ($result25 as $itm) { ?>
                                                                infoWindowContent.push(["<div class='info_content'><h3><?php echo $itm['Blow_Whistle_report_id']; ?>\/<?php echo 'Blow Whistle Reports'; ?><\/h3><p><?php echo $itm['created_at']; ?><\/p><a  href='javascript:void(0)' data-toggle='modal' data-target='#exampleModal'  onclick='return FiledReportview25(<?php echo $itm["Blow_Whistle_report_id"]; ?>)'>See details</a><\/div>"]);
                                                    <?php }
                                                        }
                                                    } ?>


                                                    // Add multiple markers to map
                                                    var infoWindow = new google.maps.InfoWindow(),
                                                        marker, i;


                                                    // Place each marker on the map  
                                                    for (i = 0; i < markers.length; i++) {
                                                        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                                                        bounds.extend(position);
                                                        marker = new google.maps.Marker({
                                                            position: position,
                                                            map: map,
                                                            icon: icon[i],
                                                            title: markers[i][0]
                                                        });

                                                        // Add info window to marker    
                                                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                                            return function() {
                                                                infoWindow.setContent(infoWindowContent[i][0]);
                                                                infoWindow.open(map, marker);
                                                            }
                                                        })(marker, i));

                                                        // Center the map to fit all markers on the screen
                                                        map.fitBounds(bounds);
                                                    }

                                                    // Set zoom level
                                                    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                                                        this.setZoom(6);
                                                        google.maps.event.removeListener(boundsListener);
                                                    });

                                                }

                                                // Load initialize function
                                                google.maps.event.addDomListener(window, 'load', initMap);
                                            </script>
                                            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqrzGx-aj0nC_Jyir1FhbOz3QPLBLmBr0&callback=initMap">
                                            </script>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- END DATATABLE EXPORT -->
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

                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Search Crime Map by Popularity
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button></h5>
                                    </div>
                                    <form id="" action="<?php echo base_url('CrimemapPopularity'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                <div class="row" id="modal_body1">

                                                    <div class="col-md-12">


                                                        <div class="panel panel-default">


                                                            <div class="panel-body">

                                                                <div class="row">


                                                                    <div class="col-md-12">

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="typer" id="typer_map_popularity" required>
                                                                                        <option value="">Select Type</option>
                                                                                        <option value="0">SOS</option>
                                                                                        <option value="1">Filed Report</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Start date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="startdate" id="startdate" required="">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">End date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="enddate" id="enddate" required="">
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




                                        </div>
                                        <div class="modal-footer">
                                            <input type="Submit" class="btn btn-primary pull-left" value="Submit" />
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Search Crime Map by Local Government
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button></h5>
                                    </div>
                                    <form id="" action="<?php echo base_url('CrimemapState'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                <div class="row" id="modal_body1">

                                                    <div class="col-md-12">


                                                        <div class="panel panel-default">


                                                            <div class="panel-body">

                                                                <div class="row">


                                                                    <div class="col-md-12">

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="typer" id="typer_map_state" onchange="typerop(this.value,4)" required>
                                                                                        <option value="">Select Type</option>
                                                                                        <option value="0">SOS</option>
                                                                                        <option value="1">Filed Report</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="State" id="State" required>
                                                                                        <option value="">Select Local Government</option>
                                                                                        <?php
                                                                                        foreach ($state_new as $itm) {

                                                                                            echo '<option>' . $itm['LGA'] . '</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Report Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="reporttype" id="satetype" required>
                                                                                        <option>Select Type</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Start date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="startdate" id="startdate" required="">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">End date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="enddate" id="enddate" required="">
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




                                        </div>
                                        <div class="modal-footer">
                                            <input type="Submit" class="btn btn-primary pull-left" value="Submit" />
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Search Crime Map by Response time
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button></h5>
                                    </div>
                                    <form id="" action="<?php echo base_url('CrimemapResponsetime'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                <div class="row" id="modal_body1">

                                                    <div class="col-md-12">


                                                        <div class="panel panel-default">


                                                            <div class="panel-body">

                                                                <div class="row">


                                                                    <div class="col-md-12">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="typer" id="typer_map_responsetime" onchange="typerop(this.value,5)" required>
                                                                                        <option value="">Select Type</option>
                                                                                        <option value="0">SOS</option>
                                                                                        <option value="1">Filed Report</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="State" id="State" required>
                                                                                        <option value="">Select Local Government</option>
                                                                                        <?php
                                                                                        foreach ($state_new as $itm) {

                                                                                            echo '<option>' . $itm['LGA'] . '</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Report Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="reporttype" id="restype" required>
                                                                                        <option>Select Type</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Start date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="startdate" id="startdate" required="">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">End date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="enddate" id="enddate" required="">
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




                                        </div>
                                        <div class="modal-footer">
                                            <input type="Submit" class="btn btn-primary pull-left" value="Submit" />
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Search Crime Map by Location
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button></h5>
                                    </div>
                                    <form id="" action="<?php echo base_url('CrimemapLocation'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                <div class="row" id="modal_body1">

                                                    <div class="col-md-12">


                                                        <div class="panel panel-default">


                                                            <div class="panel-body">

                                                                <div class="row">


                                                                    <div class="col-md-12">

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="typer" id="typer_map_location" onchange="typerop(this.value,2)" required>
                                                                                        <option value="">Select Type</option>
                                                                                        <option value="0">SOS</option>
                                                                                        <option value="1">Filed Report</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Report Type</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                    <select class="form-control" name="reporttype" id="locationtype" required>
                                                                                        <option>Select Type</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">Start date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="startdate" id="startdate" required="">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label">End date</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <input type="date" class="form-control" name="enddate" id="enddate" required="">
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
                </div>

            </div>
            <!-- END PAGE CONTENT WRAPPER -->
        </div>


        <!-- START PRELOADS -->
        <?php include('include/mange_script.php'); ?>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/user.js'); ?>"></script>
        <!-- END TEMPLATE -->
        <!-- END SCRIPTS -->
        <script>
            function FiledReportview(iWitness_id) {

                //alert(iWitness_id);

                var base_url = $('#base_url').val();
                var datastring = 'iWitness_id=' + iWitness_id;

                //alert(datastring);
                //alert(base_url);
                $.ajax({
                    url: base_url + 'Admin/iWitness',
                    method: 'POST',
                    data: datastring,
                    success: function(response) {
                        //alert(response) 
                        $("#modal_body").html(response);
                    }

                });




            }

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
                    }

                });




            }
        </script>
</body>

</html>