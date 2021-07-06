
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
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                   
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <?php if(isset($_SESSION['success'])){ ?>
    <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
  <?php }if(isset($_SESSION['error'])){ ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error'] ?></div>
  <?php } ?>    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form id="additem" action="<?php  echo base_url()."updateprofile"; ?>" role="form" class="form-horizontal" method="POST" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Admin </strong>Profile</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                  
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
										
										
                                            <input type="hidden" name="admin_id" value="<?php if (isset($admin)){
                                                foreach($admin as $datpr){
                                            echo $datpr['id'];
                                                }
                                        }?>">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="email" id="prod_name" value="<?php if (isset($admin)){
												foreach($admin as $datpr){
											echo $datpr['email'];
												}
										}?>" required/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            
											
											
                                            
                                            
                                               
                                            
                                            
                                        </div>
                                     
                                        <div class="col-md-6">
								
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="password" class="form-control" name="passwrd" id="password-field" value="<?php if (isset($admin)){
												foreach($admin as $datpr){
											echo $datpr['password'];
												}
										}?>" required>
                                                    </div>                                            
                                                 
                                                </div>
                                                <div class="col-md-1">
                                                    <i id="pass-status" class="fa fa-eye" aria-hidden="true" onClick="viewPassword()"></i>
                                                </div>
                                            </div>
                                        
                                            
                                           
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
								<input type="reset"   class="btn btn-default" value="Clear Form" />
                                     <input type="Submit"   name="login-submit" id="login-submit" class="btn btn-primary pull-right" value="update" />                                 
                                   
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
       

        <!-- START PRELOADS -->
               <?php include('include/mange_script.php'); ?> 
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS --> 
        <!-- START TOGGLE PASSWORD SCRIPTS -->
        <script>
            function viewPassword()
            {
              var passwordInput = document.getElementById('password-field');
              var passStatus = document.getElementById('pass-status');
             
              if (passwordInput.type == 'password'){
                passwordInput.type='text';
                passStatus.className='fa fa-eye-slash';
                
              }
              else{
                passwordInput.type='password';
                passStatus.className='fa fa-eye';
              }
            }
        </script>
        <!-- END TOGGLE PASSWORD SCRIPTS -->
    </body>
</html>
  





