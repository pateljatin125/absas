<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>ChampHunt</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
       <link rel="icon" href="<?php echo base_url('/assets/admin/'); ?>img/Vaaulogo1024.png" sizes="16x16 32x32" type="image/png">
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/admin/css/theme-default.css'); ?>"/>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>


<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

		
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        
        <div class="login-container lightmode">
        
            <div class="login-box animated fadeInDown">
               <div class="login-logo" style="margin-top: 70px;"><a href="<?php echo base_url('/AdminLogin/'); ?>">
                    <img width="150" src="<?php echo base_url('/assets/admin/img/Vaaulogo1024.png'); ?>" style="margin-top: -50px;">
                    <h2 style="color:white;">ChampHunt</h2>
                    </a></div>
                <div class="login-body">
                    <div class="login-title"><strong>Update  Password</strong></strong> to your account</div>
					<div class="alert alert-danger" role="alert" id="error" style="display: none;">...</div>
                    <form action="<?php echo base_url('/AdminUpdatepassword'); ?>" name="login_form1" role="form" class="form-horizontal" method="post">
					<input type="hidden" value="<?php echo 1; ?>" name="adminid">
					
					<input type="hidden" value="<?php echo $otp; ?>" name="otp">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder=" Enter new Password" name="newpassword" id="newpassword" tabindex="1"  />
                        </div>
						
                    </div>
                    
                    <div class="form-group">
                        
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block" name="login-submit" id="login-submit" tabindex="4">
							 <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Update
							</button>
							
							
							
                        </div>
                    </div>
                    
                   
                    
                    </form>
                </div>
               
            </div>
            
        </div>
        
    </body>
</html>






