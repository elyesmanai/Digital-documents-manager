<?php 
session_start();
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/logstyle.css" rel="stylesheet">
</head>
<body>
<div class="container">
		<div class="row">
			<div class="content col-md-6 col-md-offset-3">
				<img src="img/logo.png" alt="logo" width="30%;">
				<h2>Welcome!</h2>
				<?php  if (isset($_SESSION['id'])) {}
						else{echo "Connectez-vous";} echo "<br>";
						if (strpos($url, 'error=success')!== false)
														{echo "Votre compte a été créé";} 
						?>
			</div>
		</div>

    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<ul id="myTab" class="nav nav-tabs nav-justified">
				            <li class="active"><a href="#login-form" data-toggle="tab"  id="login-form-link"><strong>Login</strong></a>
				            </li>
				            <li class=""><a href="#register-form" id="register-form-link" data-toggle="tab"><strong>Register</strong></a>
				            </li>
						</ul>
						<hr>
					</div>
					<div id="myTabContent" class="tab-content">
						        <div class="tab-pane fade active in" id="login-form">
									<div class="row">
										<div class="col-lg-10 col-lg-offset-1">
											<form action="login.php" method="POST">
												<?php if (strpos($url, 'error=wrong')!== false)
														{echo "Username or Password incorrect!";} ?>
												<div class="form-group">
													<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
												</div>
												<div class="form-group">
													<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6 col-sm-offset-3">
															<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
														</div>
													</div>
												</div>
												
											</form>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="register-form">
									<div class="row">
										<div class="col-lg-10 col-lg-offset-1">
											<form action="signup.php" method="POST">
												<div class="form-group">
												<?php if (strpos($url, 'error=empty')!== false)
									 					{echo "Please fill all the forms";}
									 				elseif(strpos($url, 'error=exist')!== false)
									 					{echo "username taken";}
									 					 ?>
													<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
												</div>
												<div class="form-group">
													<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
												</div>
												<div class="form-group">
													<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
												</div>
												<div class="form-group">
													<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
													<?php
													if(strpos($url, 'error=notequal')!== false)
									 					{echo "Passwords are not the same";}
													?>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6 col-sm-offset-3">
															<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
														</div>
													</div>
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
		<script src="js/log.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
</body>
</html>
