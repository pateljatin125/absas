$(document).ready(function(){
	/* handling form validation */
	$("#login-form").validate({
		rules: {
			password: {
				required: true,
			},
			username: {
				required: true,
			
			},
		},
		messages: {
			password:{
			  required: "Please enter your password"
			 },
			username: "Please enter your Username",
		},
		submitHandler: submitForm	
	});	
	$("#login-form1").validate({
		rules: {
			
			username: {
				required: true,
				
			},
		},
		messages: {
			
			username: "Please enter your email address or Phone",
		},
		submitHandler: submitForm1	
	});	

	$("#login-form2").validate({
		rules: {
			
			username: {
				required: true,
				
			},
		},
		messages: {
			
			username: "Please enter New Password",
		},
		submitHandler: submitForm2	
	});
	$("#login-form3").validate({
		rules: {
			
			username: {
				required: true,
				
			},
			password: {
				required: true,
			},
		},
		messages: {
			password:{
			  required: "Please enter your password"
			 },
			username: "Please enter your email address or Phone",
		},
		submitHandler: submitForm3	
	});
/* Handling login functionality */
	function submitForm1() {		
		var data = $("#login-form1").serialize();
		 var base_url = $('#base_url').val();
		$.ajax({				
			type : 'POST',
			url  : base_url+'Home_login/UserForgotpassword',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				
				if($.trim(response) === "1"){
					//console.log('dddd');									
					$("#login-submit1").html('Submit');
					$("#error").html("Please Check Email have you send a link").show();
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html(response).show();
					});
				}
			}
		});
		return false;
	}
	/* Handling login functionality */
	function submitForm() {		
		var data = $("#login-form").serialize();
		 var base_url = $('#base_url').val();
		$.ajax({				
			type : 'POST',
			url  : base_url+'Home_login/u_signin',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				//console.log(response);
				if($.trim(response) === "1"){
														
					$("#login-submit").html('Signing In ...');
					setTimeout(window.location = base_url + 'UserDashboard',2000);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html(response).show();
					});
				}
			}
		});
		return false;
	}


	function submitForm2() {		
		var data = $("#login-form2").serialize();
		 var base_url = $('#base_url').val();
		$.ajax({				
			type : 'POST',
			url  : base_url+'Home_login/Userupdatepassword',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				
				if($.trim(response) === "1"){
					//console.log('dddd');									
					$("#login-submit2").html('Signing In ...');
					$("#error").html("Success  Update your password").show();
					setTimeout(window.location = base_url ,3000);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html(response).show();
					});
				}
			}
		});
		return false;
	}
	/* Handling login functionality */
	function submitForm3() {		
		var data = $("#login-form3").serialize();
		 var base_url = $('#base_url').val();
		$.ajax({				
			type : 'POST',
			url  : base_url+'Home_login/user_register',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				
				if($.trim(response) === "1"){
					//console.log('dddd');									
					$("#login-submit3").html('Signing In ...');
					$("#error").html("Success sign up").show();
					setTimeout(window.location = base_url + 'userprofile' ,3000);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html(response).show();
					});
				}
			}
		});
		return false;
	}
  
});