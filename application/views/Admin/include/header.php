<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META SECTION -->
    <title>AB-SAS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <meta name="baseUser" id="base_url" content="<?php echo base_url(); ?>">
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
    <!-- END MESSAGE BOX-->