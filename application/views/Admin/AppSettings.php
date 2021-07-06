
          <?php include('include/header.php'); ?>  
            <!-- START PAGE SIDEBAR -->
            <div class="page-container">
           <?php include('include/left_side.php'); ?>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php include('include/top_nav.php'); ?>
                <!-- END X-NAVIGATION VERTICAL -->                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <?php if(isset($_SESSION['success'])){ ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
                    <?php }if(isset($_SESSION['error'])){ ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error'] ?></div>
                    <?php } ?>    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Update Application Settings</strong></h3>&nbsp;&nbsp;&nbsp;
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
   
                            <form id="update-settings" action="<?php  echo base_url()."update-settings"; ?>" role="form" class="form-horizontal" method="POST" >

                                <div class="panel-body">
                                    
                                    <div class="row" style="margin-bottom:30px">
                                        <div class="col-md-6">
                                            <input type="hidden" name="tblSno" value="<?php echo $AppSettings[0]['tblSno']; ?>">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">State Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="stateName" id="state_name" value="<?php echo $AppSettings[0]['stateName']; ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:30px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Project Company</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="projCompany" id="state_name" value="<?php echo $AppSettings[0]['projCompany']; ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:30px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">SMS Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="smsNumber" id="state_name" value="<?php echo $AppSettings[0]['smsNumber']; ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:30px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Application Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="appName" id="state_name" value="<?php echo $AppSettings[0]['appName']; ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                                <div class="panel-footer">
                                    <input type="Submit"  name="login-submit" id="login-submit" class="btn btn-primary pull-right" value="update" /> 
                                </div>
                                </form>
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
    </body>
</html>
  





