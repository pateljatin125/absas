
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
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Sub-Admins </strong>Profile</h3>&nbsp;&nbsp;&nbsp;
                                        <a href="#" class=""><button class="btn btn-primary fa fa-plus new-subadmin"> Add new Sub-Admin </button></a>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <form id="new-subadmin" action="<?php  echo base_url()."new-subadmin"; ?>" role="form" class="form-horizontal hidden" method="POST" >

                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="email" id="prod_name" value="" required/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="passwrd" id="prod_name" value="" required>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="Submit"  name="login-submit" id="login-submit" class="btn btn-primary pull-right" value="Add" /> 
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </form>
                                <?php 
                                
                                foreach($admin as $sub_admins)
                                {
                                 ?>
                            <form id="additem" action="<?php  echo base_url()."update-subadmin"; ?>" role="form" class="form-horizontal" method="POST" >

                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-5">
										
										
                                            <input type="hidden" name="admin_id" value="<?php echo $sub_admins['id']; ?>">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="email" id="prod_name" value="<?php echo $sub_admins['email']; ?>" required/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="password" class="form-control" name="passwrd" id="password-field<?= $sub_admins['id']; ?>" value="<?php echo $sub_admins['password']; ?>" required>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                            <a href="<?php  echo base_url()."delete-subadmin?id=".$sub_admins['id'] ; ?>"><input type="button"  name="login-submit" id="login-submit" class="btn btn-primary pull-right" value="delete" /> </a>
                                            <input type="Submit"  name="login-submit" id="login-submit" class="btn btn-primary pull-right" value="update" /> 
                                            
                                            <div id="status_<?php echo $sub_admins['id']; ?>"><?php if ($sub_admins['is_active'] == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $sub_admins['id']; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to suspend admin." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $sub_admins['id']; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to reactivate admin." /> </a><?php } ?>&nbsp; <i id="pass-status<?= $sub_admins['id']; ?>" class="fa fa-eye" aria-hidden="true" onClick="viewPassword(<?= $sub_admins['id']; ?>)"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <?php }  ?>
                                <div class="panel-footer">
								<!-- <input type="reset"   class="btn btn-default" value="Clear Form" /> -->
                                     <!-- <input type="Submit"   name="login-submit" id="login-submit" class="btn btn-primary pull-right" value="update" />                                  -->
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
       

        <!-- START PRELOADS -->
               <?php include('include/mange_script.php'); ?> 

               <script>
                   $('.new-subadmin').on('click',function(){
                        $('#new-subadmin').toggleClass('hidden');
                   });

                       function changeBannerStatus(status, event_id) {
                        //alert(status);
                        //alert(banner_id);

                        var base_url = $('#base_url').val();
                        var datastring = 'status=' + status + '&id=' + event_id;

                        //alert(datastring);
                        $.ajax({
                            url: base_url + 'Admin/subadmin_status',
                            method: 'POST',
                            data: datastring,
                            success: function(data) {
                            //alert(data);
                            //console.log(data);
                            if (data == 1) {
                                $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to suspend this admin." /></a>');
                                //location.href = data;
                            } else {
                                $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to reactivate this admin." /></a>');

                            }
                            }
                        });




                        }
               </script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->  
        <!-- START TOGGLE PASSWORD SCRIPTS -->   
        <script>
            function viewPassword(id)
            {
              var passwordInput = document.getElementById('password-field'+ id);
              var passStatus = document.getElementById('pass-status' + id);
             
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
  





