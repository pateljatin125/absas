$(document).ready(function(){
	/* handling form validation */
	$("#login-form").validate({
		rules: {
			password: {
				required: true,
			},
			username: {
				required: true,
				email: true
			},
		},
		messages: {
			password:{
			  required: "Please enter your password"
			 },
			username: "Please enter your email address",
		},
		submitHandler: submitForm	
	});	
	$("#login-form1").validate({
		rules: {
			
			username: {
				required: true,
				email: true
			},
		},
		messages: {
			
			username: "Please enter your email address",
		},
		submitHandler: submitForm1	
	});	

	$("#login-form2").validate({
		rules: {
			password: {
				required: true,
			},
			repassword: {
				required: true,
				
			},
		},
		messages: {
			password:{
			  required: "Please enter your password"
			 },
			repassword: "Please enter your confirm password",
		},
		submitHandler: submitForm2	
	});

/* Handling login functionality */
	function submitForm1() {		
		var data = $("#login-form1").serialize();
		 var base_url = $('#base_url').val();
		$.ajax({				
			type : 'POST',
			url  : base_url+'Admin_login/forgotpassword',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				
				if($.trim(response) === "1"){
					//console.log('dddd');									
					$("#login-submit").html('Submit');
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
			url  : base_url+'Admin_login/u_signin',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				
				if($.trim(response) === "1"){
					console.log('dddd');									
					$("#login-submit").html('Signing In ...');
					setTimeout(window.location = base_url + 'Dashboard',2000);
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
		var data = $("#login-form").serialize();
		 var base_url = $('#base_url').val();
		$.ajax({				
			type : 'POST',
			url  : base_url+'Admin_login/updatepass',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){
				
				if($.trim(response) === "1"){
					//console.log('dddd');									
					$("#login-submit").html('Signing In ...');
					$("#error").html("success Full Update your password").show();
					setTimeout(window.location = base_url + 'AdminLogin',3000);
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
	function logout() {
		console.log('fdfdf');
		$.ajax({				
			type : 'POST',
			url  : 'response.php?action=logout',
			data : data,
			success : function(response){
				window.location.href = "/index.php";
			}
		});
		return false;
	}   
});