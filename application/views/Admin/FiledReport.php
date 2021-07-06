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
                    <div class="panel panel-default" style="box-shadow:none">
                        <div class="panel-heading col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="panel-title"><strong>Report's Management </strong></h3>
                                </div>
                                <div class="notification-rp col-md-2">
                                    <span>Total Report Recieved</span>
                                    <span class="badge-rp" id="reportTotal"><?php echo $total; ?></span>
                                </div>
                                <!--   <div  class="col-md-6 text-right">-->
                                <!--       <span style="font-size: 14px;margin-top:3px;display:inline-block">View By Report Category</span>  -->
                                <!--       <select class="form-control pull-right" style="width:200px;">-->
                                <!--    <option>Select Category</option>-->
                                <!--    <option>Popularity</option>-->
                                <!--    <option>Location</option>-->
                                <!--    <option>Duration</option>-->
                                <!--    <option>State</option>-->
                                <!--    <option>Response time</option>-->
                                <!--</select>-->
                                <!--    </div>-->
                            </div>

                            <?php if (isset($_SESSION['userAdd'])) { ?>
                                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
                            <?php }
                            if (isset($_SESSION['usernotAdd'])) { ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
                            <?php } ?>

                        </div>

                        <div class="panel-body">
                            <div class="panel panel-default tabs" style="border: none;">
                                <div class="bs-example bs-example-tabs">
                                    <ul id="myTab" class="nav nav-tabs freport " role="tablist">
                                        <li role="presentation" class="active notification-rpm">
                                            <a href="#Popularity" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">iWitness</a>
                                            <?php if ($nsresult0[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp">
                                                    <?php echo $nsresult0[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity1" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Officer Conduct</a>
                                            <?php if ($nsresult1[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp1">
                                                    <?php echo $nsresult1[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity2" role="tab" id="Duration-tab" data-toggle="tab" aria-controls="Duration" aria-expanded="false">Commend Officer</a>
                                            <?php if ($nsresult2[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp2">
                                                    <?php echo $nsresult2[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity3" role="tab" id="State-tab" data-toggle="tab" aria-controls="State" aria-expanded="false">Stolen vehicle</a>
                                            <?php if ($nsresult3[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityr3">
                                                    <?php echo $nsresult3[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity4" role="tab" id="Response-tab" data-toggle="tab" aria-controls="Response" aria-expanded="false">Missing Persons</a>
                                            <?php if ($nsresult4[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp4">
                                                    <?php echo $nsresult4[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity5" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">Lodge a complaint</a>
                                            <?php if ($nsresult5[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp5">
                                                    <?php echo $nsresult5[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity13" role="tab" id="State-tab" data-toggle="tab" aria-controls="State" aria-expanded="false">Burglary</a>
                                            <?php if ($nsresult13[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp13">
                                                    <?php echo $nsresult13[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity6" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Gun Violence</a>
                                            <?php if ($nsresult6[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp6">
                                                    <?php echo $nsresult6[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity7" role="tab" id="Duration-tab" data-toggle="tab" aria-controls="Duration" aria-expanded="false">Drug Abuse</a>
                                            <?php if ($nsresult7[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp7">
                                                    <?php echo $nsresult7[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity8" role="tab" id="State-tab" data-toggle="tab" aria-controls="State" aria-expanded="false">Domestic Violence</a>
                                            <?php if ($nsresult8[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp8">
                                                    <?php echo $nsresult8[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity9" role="tab" id="Response-tab" data-toggle="tab" aria-controls="Response" aria-expanded="false">Terrorist Attack</a>
                                            <?php if ($nsresult9[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp9">
                                                    <?php echo $nsresult9[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity10" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">Rape</a>
                                            <?php if ($nsresult10[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp10">
                                                    <?php echo $nsresult10[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity11" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Kidnap</a>
                                            <?php if ($nsresult11[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp11">
                                                    <?php echo $nsresult11[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity12" role="tab" id="Duration-tab" data-toggle="tab" aria-controls="Duration" aria-expanded="false">Robbery</a>
                                            <?php if ($nsresult12[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp12">
                                                    <?php echo $nsresult12[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity14" role="tab" id="Response-tab" data-toggle="tab" aria-controls="Response" aria-expanded="false">Cybercrime</a>
                                            <?php if ($nsresult14[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp14">
                                                    <?php echo $nsresult14[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity15" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">Submit a Tip</a>
                                            <?php if ($nsresult15[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp15">
                                                    <?php echo $nsresult15[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity18" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Fire</a>
                                            <?php if ($nsresult18[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp18">
                                                    <?php echo $nsresult18[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity21" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Riot</a>
                                            <?php if ($nsresult21[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp21">
                                                    <?php echo $nsresult21[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity16" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Other Reports</a>
                                            <?php if ($nsresult16[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp16">
                                                    <?php echo $nsresult16[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>

                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity17" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Vandalism</a>
                                            <?php if ($nsresult17[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp17">
                                                    <?php echo $nsresult17[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity19" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Accident</a>
                                            <?php if ($nsresult19[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp19">
                                                    <?php echo $nsresult19[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity20" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Medical</a>
                                            <?php if ($nsresult20[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp20">
                                                    <?php echo $nsresult20[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity22" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Environmental Hazard</a>
                                            <?php if ($nsresult22[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp22">
                                                    <?php echo $nsresult22[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity23" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Child Abuse</a>
                                            <?php if ($nsresult23[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp23">
                                                    <?php echo $nsresult23[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity24" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Human Trafficking</a>
                                            <?php if ($nsresult24[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp24">
                                                    <?php echo $nsresult24[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                        <li role="presentation" class="notification-rpm">
                                            <a href="#Popularity25" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Blow a Whistle</a>
                                            <?php if ($nsresult25[0]['total'] != 0) : ?>
                                                <span class="badge-rpm" id="Popularityrp25">
                                                    <?php echo $nsresult25[0]['total']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="Popularity" aria-labelledby="Popularity-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>iWitness ID</th>
                                                        <th>iWitness_date</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="iWitnessId_<?php echo $itm['iWitness_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['iWitness_id']; ?></td>
                                                            <td><?php echo $itm['iWitness_date'] . $itm['iWitness_tym']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status1_<?php echo $itm["iWitness_id"]; ?>"><?php if ($itm['iWitness_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["iWitness_id"]; ?>,1);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["iWitness_id"]; ?>,1);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">
                                                                <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm['iWitness_id']; ?>">Edit</a>/-->
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["iWitness_id"]; ?>,1)"><span class="fa fa-pencil-square-o "></span></a>

                                                                <!--<a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['iWitness_id']; ?>);">Delete</span></a>-->
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview(<?php echo $itm["iWitness_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity1" aria-labelledby="Location-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>OfficerAbuse_id </th>
                                                        <th>Description</th>
                                                        <th>Location</th>
                                                        <th>Officer_name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result1 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="OfficerAbuseId_<?php echo $itm['OfficerAbuse_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['OfficerAbuse_id']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Officer_name']; ?></td>

                                                            <td id="status2_<?php echo $itm["OfficerAbuse_id"]; ?>"><?php if ($itm['OfficerAbuse_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["OfficerAbuse_id"]; ?>,2);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["OfficerAbuse_id"]; ?>,2);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["OfficerAbuse_id"]; ?>,2)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview1(<?php echo $itm["OfficerAbuse_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity2" aria-labelledby="Duration-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>CommendOffice_id</th>
                                                        <th>Officer_name</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result2 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="CommendOfficeId_<?php echo $itm['CommendOffice_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['CommendOffice_id']; ?></td>
                                                            <td><?php echo $itm['Officer_name']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status3_<?php echo $itm["CommendOffice_id"]; ?>"><?php if ($itm['CommendOffice_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["CommendOffice_id"]; ?>,3);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["CommendOffice_id"]; ?>,3);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["CommendOffice_id"]; ?>,3)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview2(<?php echo $itm["CommendOffice_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity3" aria-labelledby="State-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Vehicle_make</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result3 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="StolenVehicleId_<?php echo $itm['StolenVehicle_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['StolenVehicle_report_id']; ?></td>
                                                            <td><?php echo $itm['Vehicle_make']; ?></td>
                                                            <td><?php echo $itm['Vehicle_model']; ?></td>
                                                            <td><?php echo $itm['Plate_Number']; ?></td>

                                                            <td id="status4_<?php echo $itm["StolenVehicle_report_id"]; ?>"><?php if ($itm['StolenVehicle_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["StolenVehicle_report_id"]; ?>,4);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["StolenVehicle_report_id"]; ?>,4);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["StolenVehicle_report_id"]; ?>,4)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview3(<?php echo $itm["StolenVehicle_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity4" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Full_Name</th>
                                                        <th>Age</th>
                                                        <th>Sex</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result4 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="MissingPersonsId_<?php echo $itm['Missing_Persons_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Missing_Persons_report_id']; ?></td>
                                                            <td><?php echo $itm['Full_Name']; ?></td>
                                                            <td><?php echo $itm['Age']; ?></td>
                                                            <td><?php echo $itm['Sex']; ?></td>

                                                            <td id="status5_<?php echo $itm["Missing_Persons_report_id"]; ?>"><?php if ($itm['Missing_Persons_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Missing_Persons_report_id"]; ?>,5);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Missing_Persons_report_id"]; ?>,5);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Missing_Persons_report_id"]; ?>,5)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview4(<?php echo $itm["Missing_Persons_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity5" aria-labelledby="Location-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Complaint</th>

                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result5 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="LodgecomplaintId_<?php echo $itm['Lodgecomplaint_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Lodgecomplaint_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>


                                                            <td id="status6_<?php echo $itm["Lodgecomplaint_report_id"]; ?>"><?php if ($itm['Lodgecomplaint_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Lodgecomplaint_report_id"]; ?>,6);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Lodgecomplaint_report_id"]; ?>,6);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Lodgecomplaint_report_id"]; ?>,6)"><span class="fa fa-pencil-square-o "></span></a>

                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview5(<?php echo $itm["Lodgecomplaint_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity6" aria-labelledby="Duration-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>GunViolence_id</th>

                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result6 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="GunViolenceId_<?php echo $itm['GunViolence_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['GunViolence_id']; ?></td>

                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status7_<?php echo $itm["GunViolence_id"]; ?>"><?php if ($itm['GunViolence_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["GunViolence_id"]; ?>,7);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["GunViolence_id"]; ?>,7);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["GunViolence_id"]; ?>,7)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview6(<?php echo $itm["GunViolence_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity7" aria-labelledby="State-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>

                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result7 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="DrugAbuseId_<?php echo $itm['DrugAbuse_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['DrugAbuse_report_id']; ?></td>

                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status8_<?php echo $itm["DrugAbuse_report_id"]; ?>"><?php if ($itm['DrugAbuse_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["DrugAbuse_report_id"]; ?>,8);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["DrugAbuse_report_id"]; ?>,8);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["DrugAbuse_report_id"]; ?>,8)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview7(<?php echo $itm["DrugAbuse_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity8" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>

                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result8 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="DomesticViolenceId_<?php echo $itm['DomesticViolence_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['DomesticViolence_report_id']; ?></td>

                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status9_<?php echo $itm["DomesticViolence_report_id"]; ?>"><?php if ($itm['DomesticViolence_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["DomesticViolence_report_id"]; ?>,9);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["DomesticViolence_report_id"]; ?>,9);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["DomesticViolence_report_id"]; ?>,9)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview8(<?php echo $itm["DomesticViolence_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity9" aria-labelledby="Location-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Date/Time</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result9 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="TerroristAttackId_<?php echo $itm['TerroristAttack_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['TerroristAttack_report_id']; ?></td>
                                                            <td><?php echo $itm['Date'] . $itm['tym']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status10_<?php echo $itm["TerroristAttack_report_id"]; ?>"><?php if ($itm['TerroristAttack_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["TerroristAttack_report_id"]; ?>,10);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["TerroristAttack_report_id"]; ?>,10);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["TerroristAttack_report_id"]; ?>,10)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview9(<?php echo $itm["TerroristAttack_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity10" aria-labelledby="Duration-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Victim_Name</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result10 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="RapeId_<?php echo $itm['Rape_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Rape_report_id']; ?></td>
                                                            <td><?php echo $itm['Victim_Name']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status11_<?php echo $itm["Rape_report_id"]; ?>"><?php if ($itm['Rape_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Rape_report_id"]; ?>,11);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Rape_report_id"]; ?>,11);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Rape_report_id"]; ?>,11)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview10(<?php echo $itm["Rape_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity11" aria-labelledby="State-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Full_Name</th>
                                                        <th>Age</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result11 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="KidnapId_<?php echo $itm['Kidnap_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Kidnap_report_id']; ?></td>
                                                            <td><?php echo $itm['Full_Name']; ?></td>
                                                            <td><?php echo $itm['Age']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status12_<?php echo $itm["Kidnap_report_id"]; ?>"><?php if ($itm['Kidnap_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Kidnap_report_id"]; ?>,12);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Kidnap_report_id"]; ?>,12);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Kidnap_report_id"]; ?>,12)"><span class="fa fa-pencil-square-o "></span></a>

                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview11(<?php echo $itm["Kidnap_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity12" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Items</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result12 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="RobberyId_<?php echo $itm['Robbery_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Robbery_report_id']; ?></td>
                                                            <td><?php echo $itm['Items']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status13_<?php echo $itm["Robbery_report_id"]; ?>"><?php if ($itm['Robbery_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Robbery_report_id"]; ?>,13);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Robbery_report_id"]; ?>,13);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Robbery_report_id"]; ?>,13)"><span class="fa fa-pencil-square-o "></span></a>

                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview12(<?php echo $itm["Robbery_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity13" aria-labelledby="Location-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Items</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result13 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="BurglaryId_<?php echo $itm['Burglary_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Burglary_report_id']; ?></td>
                                                            <td><?php echo $itm['Items']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status14_<?php echo $itm["Burglary_report_id"]; ?>"><?php if ($itm['Burglary_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Burglary_report_id"]; ?>,14);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Burglary_report_id"]; ?>,14);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">
                                                                <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm['iWitness_id']; ?>">Edit</a>/-->
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Burglary_report_id"]; ?>,14)"><span class="fa fa-pencil-square-o "></span></a>

                                                                <!--<a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm['iWitness_id']; ?>);">Delete</span></a>-->
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview13(<?php echo $itm["Burglary_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity14" aria-labelledby="Duration-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>

                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result14 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="CybercrimeFraudId<?php echo $itm['CybercrimeFraud_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['CybercrimeFraud_report_id']; ?></td>

                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status15_<?php echo $itm["CybercrimeFraud_report_id"]; ?>"><?php if ($itm['CybercrimeFraud_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["CybercrimeFraud_report_id"]; ?>,15);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["CybercrimeFraud_report_id"]; ?>,15);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["CybercrimeFraud_report_id"]; ?>,15)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview14(<?php echo $itm["CybercrimeFraud_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity15" aria-labelledby="State-tab">
                                            <table id="customers2" class="table datatable">

                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>

                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;

                                                    foreach ($result15 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="SubmitTipId_<?php echo $itm['Submit_Tip_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Submit_Tip_id']; ?></td>

                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>

                                                            <td id="status16_<?php echo $itm["Submit_Tip_id"]; ?>"><?php if ($itm['Submit_Tip_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Submit_Tip_id"]; ?>,16);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Submit_Tip_id"]; ?>,16);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>


                                                            <td class="tips">

                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Submit_Tip_id"]; ?>,16)"><span class="fa fa-pencil-square-o "></span></a>


                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview15(<?php echo $itm["Submit_Tip_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }

                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity16" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result16 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="OthersId_<?php echo $itm['Others_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Others_report_id']; ?></td>
                                                            <td><?php echo $itm['Location']; ?></td>
                                                            <td><?php echo $itm['Description']; ?></td>
                                                            <td id="status17_<?php echo $itm["Others_report_id"]; ?>"><?php if ($itm['Others_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Others_report_id"]; ?>,17);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Others_report_id"]; ?>,17);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Others_report_id"]; ?>,17)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview16(<?php echo $itm["Others_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity17" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Vandalism ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result17 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="VandalismId_<?php echo $itm['Vandalism_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Vandalism_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status18_<?php echo $itm["Vandalism_report_id"]; ?>"><?php if ($itm['Vandalism_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Vandalism_report_id"]; ?>,18);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Vandalism_report_id"]; ?>,18);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Vandalism_report_id"]; ?>,18)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview17(<?php echo $itm["Vandalism_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity18" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Fire ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result18 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="FireId_<?php echo $itm['Fire_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Fire_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status19_<?php echo $itm["Fire_report_id"]; ?>"><?php if ($itm['Fire_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Fire_report_id"]; ?>,19);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Fire_report_id"]; ?>,19);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Fire_report_id"]; ?>,19)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview18(<?php echo $itm["Fire_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity19" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Accident ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result19 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="AccidentId_<?php echo $itm['Accident_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Accident_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status20_<?php echo $itm["Accident_report_id"]; ?>"><?php if ($itm['Accident_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Accident_report_id"]; ?>,20);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Accident_report_id"]; ?>,20);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Accident_report_id"]; ?>,20)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview19(<?php echo $itm["Accident_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity20" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Medical ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result20 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="MedicalId_<?php echo $itm['Medical_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Medical_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status21_<?php echo $itm["Medical_report_id"]; ?>"><?php if ($itm['Medical_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Medical_report_id"]; ?>,21);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Medical_report_id"]; ?>,21);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Medical_report_id"]; ?>,21)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview20(<?php echo $itm["Medical_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Popularity21" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Riot ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result21 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="RiotId_<?php echo $itm['Riot_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Riot_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status22_<?php echo $itm["Riot_report_id"]; ?>"><?php if ($itm['Riot_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Riot_report_id"]; ?>,22);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Riot_report_id"]; ?>,22);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Riot_report_id"]; ?>,22)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview21(<?php echo $itm["Riot_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="Popularity22" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Environmental Hazard ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result22 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="EnvironmentalHazardId_<?php echo $itm['Environmental_Hazard_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Environmental_Hazard_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status23_<?php echo $itm["Environmental_Hazard_report_id"]; ?>"><?php if ($itm['Environmental_Hazard_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Environmental_Hazard_report_id"]; ?>,23);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Environmental_Hazard_report_id"]; ?>,23);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Environmental_Hazard_report_id"]; ?>,23)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview22(<?php echo $itm["Environmental_Hazard_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="Popularity23" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Child Abuse ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result23 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="ChildAbuseId_<?php echo $itm['Child_Abuse_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Child_Abuse_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status24_<?php echo $itm["Child_Abuse_report_id"]; ?>"><?php if ($itm['Child_Abuse_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Child_Abuse_report_id"]; ?>,24);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Child_Abuse_report_id"]; ?>,24);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Child_Abuse_report_id"]; ?>,24)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview23(<?php echo $itm["Child_Abuse_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="Popularity24" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Human Trafficking ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result24 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="HumanTraffickingId_<?php echo $itm['Human_Trafficking_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Human_Trafficking_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status25_<?php echo $itm["Human_Trafficking_report_id"]; ?>"><?php if ($itm['Human_Trafficking_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Human_Trafficking_report_id"]; ?>,25);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Human_Trafficking_report_id"]; ?>,25);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Human_Trafficking_report_id"]; ?>,25)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview24(<?php echo $itm["Human_Trafficking_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="Popularity25" aria-labelledby="Response-tab">
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Blow Whistle ID</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($result25 as $itm) { ?>
                                                        <tr class="<?php echo ($itm['is_read'] == 1) ? 'readnew' : '' ?>" id="BlowWhistleId_<?php echo $itm['Blow_Whistle_report_id']; ?>">
                                                            <td><?php echo $count; ?>.</td>
                                                            <td><?php echo $itm['Blow_Whistle_report_id']; ?></td>
                                                            <td><?php echo $itm['Name']; ?></td>
                                                            <td><?php echo $itm['Complaint']; ?></td>
                                                            <td id="status26_<?php echo $itm["Blow_Whistle_report_id"]; ?>"><?php if ($itm['Blow_Whistle_report_status'] == 1) { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Blow_Whistle_report_id"]; ?>,26);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Blow_Whistle_report_id"]; ?>,26);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                            <td class="tips">
                                                                <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return SOSFeedback(<?php echo $itm["Blow_Whistle_report_id"]; ?>,26)"><span class="fa fa-pencil-square-o "></span></a>
                                                                <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal" onclick="return FiledReportview25(<?php echo $itm["Blow_Whistle_report_id"]; ?>)"><span class="fa fa-eye "></span></a>
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
                    </div>
                    <!-- END DATATABLE EXPORT -->

                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">FeedBack Filed Report
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></h5>
                                </div>
                                <form id="" action="<?php echo base_url('FeedbackFiledReport'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                                    <h5 class="modal-title" id="exampleModalLabel">Filed Report Details
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
    <script type="text/javascript" src="<?php echo base_url('assets/admin/user.js'); ?>"></script>
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
                    chnagenewoldreport(1, iWitness_id);
                }

            });


        }

        function SOSFeedback(iWitness_id, catid) {
            // alert(iWitness_id);
            // alert(catid);
            chnagenewoldreport(catid, iWitness_id);
            $('#aptid').html('<input type="hidden" class="form-control" name="report_id" id="report_id" value="' + iWitness_id + '" /><input type="hidden" class="form-control" name="cat_id" id="cat_id" value="' + catid + '" />');




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

        function changeBannerStatus(status, event_id, cat_id) {
            //alert(status);
            //alert(banner_id);

            var base_url = $('#base_url').val();
            var datastring = 'status=' + status + '&SOSid=' + event_id + '&cat_id=' + cat_id;

            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/iWitnessStatus',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    //alert(data);
                    //console.log(data);
                    if (data == 1) {
                        $('#status' + cat_id + '_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to deactive this banner." /></a>');
                        //location.href = data;
                    } else {
                        $('#status' + cat_id + '_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to Aeactive this banner." /></a>');

                    }
                    chnagenewoldreport(cat_id, event_id);
                }
            });

        }


        function ReportCategory(id) {
            //alert(id)
            var base_url = $('#base_url').val();
            var datastring = 'id=' + id;

            //alert(base_url);
            $.ajax({
                url: base_url + 'Admin/ReportCategory',
                method: 'POST',
                data: datastring,
                success: function(data) {
                    alert(data);
                    //console.log(data);
                    $('#tab1').html(data);
                    //   table.ajax.reload();

                }
            });
        }

        function chnagenewoldreport(reportid, recordid) {
            var base_url = $('#base_url').val();
            var lang = '';
            var id = '';
            var idnew = recordid;
            $.ajax({
                url: base_url + 'Admin/Filereaded',
                method: 'POST',
                data: {
                    'report_id': reportid,
                    'record_id': recordid
                },
                success: function(data) {
                    var json = $.parseJSON(data)
                    // console.log(json.rptotal[0]['total']);
                    $("span#reportTotal").text(json.alltotal);
                    $("span#filedTotalM").text(json.alltotal);

                    switch (reportid + "") {
                        case "1":
                            lang = "iWitness";
                            id = "iWitnessId_" + idnew;
                            $("span#Popularityrp").text(json.rptotal[0]['total']);
                            break;
                        case "2":
                            lang = "Officer_Abuse";
                            id = "OfficerAbuseId_" + idnew;
                            $("span#Popularityrp1").text(json.rptotal[1]['total']);
                            break;
                        case "3":
                            lang = "Commend_Officer";
                            id = "CommendOfficeId_" + idnew;
                            $("span#Popularityrp2").text(json.rptotal[2]['total']);
                            break;
                        case "4":
                            lang = "StolenVehicle_report";
                            id = "StolenVehicleId_" + idnew;
                            $("span#Popularityrp3").text(json.rptotal[3]['total']);
                            break;
                        case "5":
                            lang = "Missing_Persons_report";
                            id = "MissingPersonsId_" + idnew;
                            $("span#Popularityrp4").text(json.rptotal[4]['total']);
                            break;
                        case "6":
                            lang = "Lodgecomplaint_report";
                            id = "LodgecomplaintId_" + idnew;
                            $("span#Popularityrp5").text(json.rptotal[5]['total']);
                            break;
                        case "7":
                            lang = "Gun_Violence_report";
                            id = "GunViolenceId_" + idnew;
                            $("span#Popularityrp6").text(json.rptotal[6]['total']);
                            break;
                        case "8":
                            lang = "Drug_Abuse_report";
                            id = "DrugAbuseId_" + idnew;
                            $("span#Popularityrp7").text(json.rptotal[7]['total']);
                            break;
                        case "9":
                            lang = "Domestic_Violence_report";
                            id = "DomesticViolenceId_" + idnew;
                            $("span#Popularityrp8").text(json.rptotal[8]['total']);
                            break;
                        case "10":
                            lang = "Terrorist_Attack_report";
                            id = "TerroristAttackId_" + idnew;
                            $("span#Popularityrp9").text(json.rptotal[9]['total']);
                            break;
                        case "11":
                            lang = "Rape_report";
                            id = "RapeId_" + idnew;
                            $("span#Popularityrp10").text(json.rptotal[10]['total']);
                            break;
                        case "12":
                            lang = "Kidnap_report";
                            id = "KidnapId_" + idnew;
                            $("span#Popularityrp11").text(json.rptotal[11]['total']);
                            break;
                        case "13":
                            lang = "Robbery_report";
                            id = "RobberyId_" + idnew;
                            $("span#Popularityrp12").text(json.rptotal[12]['total']);
                            break;
                        case "14":
                            lang = "Burglary_report";
                            id = "BurglaryId_" + idnew;
                            $("span#Popularityrp13").text(json.rptotal[13]['total']);
                            break;
                        case "15":
                            lang = "CybercrimeFraud_report";
                            id = "CybercrimeFraudId_" + idnew;
                            $("span#Popularityrp14").text(json.rptotal[14]['total']);
                            break;
                        case "16":
                            lang = "Submit_Tip_report";
                            id = "SubmitTipId_" + idnew;
                            $("span#Popularityrp15").text(json.rptotal[15]['total']);
                            break;
                        case "17":
                            lang = "Others_report";
                            id = "OthersId_" + idnew;
                            $("span#Popularityrp16").text(json.rptotal[16]['total']);
                            break;
                        case "18":
                            lang = "Vandalism_report";
                            id = "VandalismId_" + idnew;
                            $("span#Popularityrp17").text(json.rptotal[17]['total']);
                            break;
                        case "19":
                            lang = "Fire_report";
                            id = "FireId_" + idnew;
                            $("span#Popularityrp18").text(json.rptotal[18]['total']);
                            break;
                        case "20":
                            lang = "Accident_report";
                            id = "AccidentId_" + idnew;
                            $("span#Popularityrp19").text(json.rptotal[19]['total']);
                            break;
                        case "21":
                            lang = "Medical_report";
                            id = "MedicalId_" + idnew;
                            $("span#Popularityrp20").text(json.rptotal[20]['total']);
                            break;
                        case "22":
                            lang = "Riot_report";
                            id = "RiotId_" + idnew;
                            $("span#Popularityrp21").text(json.rptotal[21]['total']);
                            break;
                        case "23":
                            lang = "Environmental_Hazard_report";
                            id = "EnvironmentalHazardId_" + idnew;
                            $("span#Popularityrp22").text(json.rptotal[22]['total']);
                            break;
                        case "24":
                            lang = "Child_Abuse_report";
                            id = "ChildAbuseId_" + idnew;
                            $("span#Popularityrp23").text(json.rptotal[23]['total']);
                            break;
                        case "25":
                            lang = "Human_Trafficking_report";
                            id = "HumanTraffickingId_" + idnew;
                            $("span#Popularityrp24").text(json.rptotal[24]['total']);
                            break;
                        case "26":
                            lang = "Blow_Whistle_report";
                            id = "BlowWhistleId_" + idnew;
                            $("span#Popularityrp25").text(json.rptotal[25]['total']);
                            break;
                        default:
                            lang = "iWitness";
                            id = "iWitnessId_" + idnew;
                    }
                    // console.log( id);
                    $("#" + id).removeClass('readnew');
                }
            });
        }
    </script>

    </body>

    </html>