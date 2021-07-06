<?php include('include/header.php'); ?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/css/managedata.css'); ?>" />

<script>
    function sosfilter(id) {
        if (id == 1) {
            $("#sosPopularity").trigger("click");
        } else if (id == 2) {
            $("#sosLocation").trigger("click");
        } else if (id == 4) {
            //$("#sosDuration").trigger("click");
            $("#sosState").trigger("click");
        } else if (id == 5) {
            $("#sosResponsetime").trigger("click");
        }

    }

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


                    <!-- START DATATABLE EXPORT -->
                    <div class="panel panel-default" style="box-shadow:none">
                        <div class="panel-heading col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="panel-title"><strong>SOS Reports by Local Government </strong></h3>
                                </div>
                                
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
                                    <ul id="myTab" class="nav nav-tabs" role="tablist">

                                        <li role="presentation" class="active" style="margin-left: -5px;"><a href="#sos" id="sos-tab" role="tab" data-toggle="tab" aria-controls="sos" aria-expanded="true">SOS</a></li>
                                        <li role="presentation" class=""><a href="#Popularity" role="tab" id="Popularity-tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="false">Filed Reports</a></li>


                                    </ul>
                                    <div id="myTabContent" class="tab-content">

                                        <div role="tabpanel" class="tab-pane fade active in" id="sos" aria-labelledby="sos-tab">
                                            <div class="panel-heading col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 class="panel-title"><strong>Search By </strong></h3>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span style="font-size: 14px;margin-top:3px;display:inline-block">View By Report Category</span>
                                                        <select class="form-control pull-right" style="width:200px;" onchange="sosfilter(this.value)">
                                                            <option value="0">Search By</option>
                                                            <option value="1">Popularity</option>
                                                            <option value="2">Location</option>
                                                            <!--<option value="3">Duration</option>-->
                                                            <option value="4">Local Government</option>
                                                            <option value="5">Response time</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div style="display:none;">
                                                    <a href="#" data-toggle="modal" id="sosPopularity" data-target="#exampleModal6">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="sosLocation" data-target="#exampleModal7">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="sosDuration" data-target="#exampleModal8">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="sosState" data-target="#exampleModal9">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="sosResponsetime" data-target="#exampleModal10">Edit/</a>
                                                </div>

                                            </div>
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>SOS Type</th>
                                                        <th>Local Government</th>
                                                        <th>Frequency</th>
                                                        <th>Duration(Start and End Date) </th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $count = 1;
                                                    if (!empty($result_new)) {
                                                        foreach ($result_new as $rsnew) {
                                                            echo '<tr class="">';
                                                            echo '<td>' . $count . '</td>';
                                                            echo '<td>' . $rsnew['sos_category_name'] . '</td>';
                                                            echo '<td>' . $rsnew['STATE'] . '</td>';
                                                            echo '<td>' . $rsnew['Frequency'] . '</td>';
                                                            echo '<td>' . $rsnew['Duration'] . '</td>';
                                                            echo '</tr>';
                                                            $count++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="Popularity" aria-labelledby="Popularity-tab">
                                            <div class="panel-heading col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 class="panel-title"><strong>Search By </strong></h3>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span style="font-size: 14px;margin-top:3px;display:inline-block">View By Report Category</span>
                                                        <select class="form-control pull-right" style="width:200px;" onchange="reportfilter(this.value)">
                                                            <option value="0">Search By</option>
                                                            <option value="1">Popularity</option>
                                                            <option value="2">Location</option>
                                                            <!--<option value="3">Duration</option>-->
                                                            <option value="4">Local Government</option>
                                                            <option value="5">Response time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div style="display:none;">
                                                    <a href="#" data-toggle="modal" id="ReportPopularity" data-target="#exampleModal1">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="ReportLocation" data-target="#exampleModal2">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="ReportDuration" data-target="#exampleModal3">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="ReportState" data-target="#exampleModal4">Edit/</a>
                                                    <a href="#" data-toggle="modal" id="ReportResponsetime" data-target="#exampleModal5">Edit/</a>
                                                </div>

                                            </div>
                                            <table id="customers2" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo.</th>
                                                        <th>Report Type</th>
                                                        <th>Local Government</th>
                                                        <th>Frequency</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    if (!empty($result_new_1)) {
                                                        foreach ($result_new_1 as $rsnew) {
                                                            echo '<tr class="">';
                                                            echo '<td>' . $count . '</td>';
                                                            echo '<td>' . $rsnew['report_category_name'] . '</td>';
                                                            echo '<td>' . $rsnew['STATE'] . '</td>';
                                                            echo '<td>' . $rsnew['Frequency'] . '</td>';
                                                            // echo '<td>' . $rsnew['Duration'] . '</td>';
                                                            echo '</tr>';
                                                            $count++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search Filed Reports by Popularity
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('FiledReportsPopularity'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <!--<div class="form-group">-->
                                                                                        <!--               <label class="col-md-3 control-label">Report Type</label>-->
                                                                                        <!--               <div class="col-md-9">                                            -->
                                                                                        <!--                   <div class="input-group">-->
                                                                                        <!--                       <span class="input-group-addon"><span class="fa fa-pencil"></span></span>-->

                                                                                        <!--                        <select  class="form-control" name="reporttype" id="user_name">-->
                                                                                        <!--                            <option>Select Type</option>-->

                                                                                        <!--                        </select>-->
                                                                                        <!--                   </div>                                            -->

                                                                                        <!--               </div>-->
                                                                                        <!--           </div>-->
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
                                        <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search Filed Reports
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('SubmitOfficer'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Report Type</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="reporttype" id="user_name">
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
                                        <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search Filed Reports by Local Government
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('FiledReportsState'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="State" id="State">
                                                                                                        <option>Select Local Government</option>
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
                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        $count = 1;
                                                                                                        foreach ($filedcategory as $itm) {
                                                                                                            echo '<option value="' . $count . '">' . $itm['FiledReport_name'] . '</option>';
                                                                                                            $count++;
                                                                                                        }
                                                                                                        ?>
                                                                                                        ?>
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
                                                        <h5 class="modal-title" id="exampleModalLabel">Search Filed Reports by Response time
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('FiledReportsResponsetime'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">


                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="State" id="State">
                                                                                                        <option>Select Local Government</option>
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
                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        $count = 1;
                                                                                                        foreach ($filedcategory as $itm) {
                                                                                                            echo '<option value="' . $count . '">' . $itm['FiledReport_name'] . '</option>';
                                                                                                            $count++;
                                                                                                        }
                                                                                                        ?>
                                                                                                        ?>
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
                                        <div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search SoS Reports by Popularity
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('SoSReportsPopularity'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">


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
                                        <div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search SOS Reports by Location
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('SOSReportsLocation'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Report Type</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        foreach ($soscategory as $itm) {

                                                                                                            echo '<option value="' . $itm['sos_category_id'] . '">' . $itm['sos_category_name'] . '</option>';
                                                                                                        }
                                                                                                        ?>

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
                                                        <h5 class="modal-title" id="exampleModalLabel">Search Filed Reports by Location
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('FiledReportsLocation'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Report Type</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        $count = 1;
                                                                                                        foreach ($filedcategory as $itm) {
                                                                                                            echo '<option value="' . $count . '">' . $itm['FiledReport_name'] . '</option>';
                                                                                                            $count++;
                                                                                                        }
                                                                                                        ?>
                                                                                                        ?>
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
                                        <div class="modal fade" id="exampleModal8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search sos Reports BY
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('SubmitOfficer'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="State" id="State">
                                                                                                        <option>Select Local Government</option>
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

                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        foreach ($soscategory as $itm) {

                                                                                                            echo '<option value="' . $itm['sos_category_id'] . '">' . $itm['sos_category_name'] . '</option>';
                                                                                                        }
                                                                                                        ?>
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
                                        <div class="modal fade" id="exampleModal9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search SOS Reports by Local Government
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('SOSReportsState'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="State" id="State">
                                                                                                        <option>Select Local Government</option>
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

                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        foreach ($soscategory as $itm) {

                                                                                                            echo '<option value="' . $itm['sos_category_id'] . '">' . $itm['sos_category_name'] . '</option>';
                                                                                                        }
                                                                                                        ?>
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
                                        <div class="modal fade" id="exampleModal10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Search SOS Reports by Response time
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button></h5>
                                                    </div>
                                                    <form id="" action="<?php echo base_url('SOSReportsResponsetime'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                                                                <div class="row" id="modal_body1">

                                                                    <div class="col-md-12">


                                                                        <div class="panel panel-default">


                                                                            <div class="panel-body">

                                                                                <div class="row">


                                                                                    <div class="col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Local Government</label>
                                                                                            <div class="col-md-9">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

                                                                                                    <select class="form-control" name="State" id="State">
                                                                                                        <option>Select Local Government</option>
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

                                                                                                    <select class="form-control" name="reporttype" id="user_name">
                                                                                                        <option>Select Type</option>
                                                                                                        <?php
                                                                                                        foreach ($soscategory as $itm) {

                                                                                                            echo '<option value="' . $itm['sos_category_id'] . '">' . $itm['sos_category_name'] . '</option>';
                                                                                                        }
                                                                                                        ?>
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


                        </div>
                    </div>
                    <!-- END DATATABLE EXPORT -->



                </div>
            </div>


            <?php

            $category1 = $this->db->get_where('SOSManagement', array('SOS_category' => 1))->result_array();
            $category2 = $this->db->get_where('SOSManagement', array('SOS_category' => 2))->result_array();
            $category3 = $this->db->get_where('SOSManagement', array('SOS_category' => 3))->result_array();
            $category4 = $this->db->get_where('SOSManagement', array('SOS_category' => 4))->result_array();
            $category5 = $this->db->get_where('SOSManagement', array('SOS_category' => 5))->result_array();
            $category6 = $this->db->get_where('SOSManagement', array('SOS_category' => 6))->result_array();
            $category7 = $this->db->get_where('SOSManagement', array('SOS_category' => 7))->result_array();



            $data1 = $this->beats_model->select_data('*', 'iWitness');
            $data2 = $this->beats_model->select_data('*', 'Officer_Abuse');
            $data3 = $this->beats_model->select_data('*', 'Commend_Officer');
            $data4 = $this->beats_model->select_data('*', 'StolenVehicle_report');
            $data5 = $this->beats_model->select_data('*', 'Missing_Persons_report');
            $data6 = $this->beats_model->select_data('*', 'Lodgecomplaint_report');
            $data7 = $this->beats_model->select_data('*', 'Gun_Violence_report');
            $data8 = $this->beats_model->select_data('*', 'Drug_Abuse_report');
            $data9 = $this->beats_model->select_data('*', 'Domestic_Violence_report');
            $data10 = $this->beats_model->select_data('*', 'Terrorist_Attack_report');
            $data11 = $this->beats_model->select_data('*', 'Rape_report');
            $data12 = $this->beats_model->select_data('*', 'Kidnap_report');
            $data13 = $this->beats_model->select_data('*', 'Robbery_report');
            $data14 = $this->beats_model->select_data('*', 'Burglary_report');
            $data15 = $this->beats_model->select_data('*', 'CybercrimeFraud_report');
            $data16 = $this->beats_model->select_data('*', 'Submit_Tip_report');
            $data17 = $this->beats_model->select_data('*', 'Others_report');

            $dataPoints = array(
                array("y" => count($category1), "label" => "Kidnap"),
                array("y" => count($category2), "label" => "Robbery"),
                array("y" => count($category3), "label" => "Rape"),
                array("y" => count($category4), "label" => "Car Theft"),
                array("y" => count($category5), "label" => "Burglary"),
                array("y" => count($category6), "label" => "Terrorist Attack"),
                array("y" => count($category7), "label" => "Drug Abuse")
            );


            $dataPoints1 = array(
                array("y" => count($data1), "label" => "iWitness"),
                array("y" => count($data2), "label" => "Officer Conduct"),
                array("y" => count($data3), "label" => "Commend Officer"),
                array("y" => count($data4), "label" => "Stolen vehicle"),
                array("y" => count($data5), "label" => "Missing Persons"),
                array("y" => count($data6), "label" => "Lodge a complaint"),
                array("y" => count($data7), "label" => "Gun Violence"),
                array("y" => count($data8), "label" => "Drug Abuse"),
                array("y" => count($data9), "label" => "Domestic Violence"),
                array("y" => count($data10), "label" => "Terrorist Attack"),
                array("y" => count($data11), "label" => "Rape"),
                array("y" => count($data12), "label" => "Kidnap"),
                array("y" => count($data13), "label" => "Robbery"),
                array("y" => count($data14), "label" => "Burglary"),
                array("y" => count($data15), "label" => "Cybercrime"),
                array("y" => count($data16), "label" => "Submit a Tip"),
                array("y" => count($data17), "label" => "Other Reports")

            );
            ?>

            <script>
                window.onload = function() {

                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        theme: "light2",
                        title: {
                            text: "SOS Category"
                        },
                        axisY: {
                            title: "Number of SOS"
                        },
                        data: [{
                            type: "column",
                            yValueFormatString: "#,##0.## ",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();

                    var chart = new CanvasJS.Chart("chartContainer2", {
                        animationEnabled: true,
                        theme: "light2",
                        title: {
                            text: "Filed Reports"
                        },
                        axisY: {
                            title: "Number of FiledReports"
                        },
                        data: [{
                            type: "column",
                            yValueFormatString: "#,##0.## ",
                            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();

                }
            </script>

            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>


    <!-- START PRELOADS -->
    <?php include('include/mange_script.php'); ?>
    <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    <script type="text/javascript" src="<?php echo base_url('assets/admin/user.js'); ?>"></script>


    </body>

    </html>