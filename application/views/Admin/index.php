<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>AB-SAS</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
      <link rel="icon" href="<?php echo base_url('/assets/admin/img/asas_logo.png'); ?>" sizes="16x16 32x32" type="image/png">
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/admin/css/theme-default.css'); ?>"/>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>


<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/libs/common.js'); ?>"></script>
		
        <!-- EOF CSS INCLUDE -->  

    </head>
    <body>
        
        <div class="login-container lightmode">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"><a href="<?php echo base_url('/AdminLogin/'); ?>" style="margin:0">
                    <img width="150" src="<?php echo base_url('/assets/admin/img/asas_logo.png'); ?>" style="width:90px;margin-top:35px;">
                    <h2 style="font-weight:bold;color:#fa1f13;margin-top:20px;margin-bottom:0">AB-SAS</h2>
                    </a></div>
                <div class="login-body">
                    <div class="login-title"><strong>Log In</strong> to your account</div>
					<div class="alert alert-danger" role="alert" id="error" style="display: none;">...</div>
                    <form id="login-form" name="login_form" role="form" class="form-horizontal" method="post">
					<input type="hidden" id="base_url" value="<?php echo base_url();?>">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="email" class="form-control" placeholder="E-mail" name="username" id="username" tabindex="1" autocomplete="off"/>
                        </div>
						
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" tabindex="2"/>
                        </div>
						
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="<?php echo base_url('AdminForgot') ?>" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-block" name="login-submit" id="login-submit" tabindex="4" style="background:#Fa1f13;">
							 <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> <span style="color:#ffffff;">Log In</span>
							</button>
							
							
							
                        </div>
                    </div>
                    
                   
                    
                    </form>
                </div>
               
            </div>
            
        </div>
        
    </body>
</html>






