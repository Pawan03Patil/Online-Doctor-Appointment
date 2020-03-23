<html>
<head>
	<link rel="stylesheet" href="main.css">
	<style>

#password-strength-status {padding: 5px 10px;color: #FFFFFF; border-radius:4px;margin-top:5px;}
.medium-password{background-color: #E4DB11;border:#BBB418 1px solid;}
.weak-password{background-color: #FF6600;border:#AA4502 1px solid;}
.strong-password{background-color: #12CC1A;border:#0FA015 1px solid;}
</style>
	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
function checkPasswordStrength() {
	var number = /([0-9])/;
	var alphabets = /([a-zA-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	
	if($('#p1').val().length<6) {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').addClass('weak-password');
		$('#password-strength-status').html("Weak");
		
	} else {  	
	    if($('#p1').val().match(number) && $('#p1').val().match(alphabets) && $('#p1').val().match(special_characters)) {            
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('strong-password');
			$('#password-strength-status').html("Strong");
        } else {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('medium-password');
		
			$('#password-strength-status').html("Medium");
        } 
	}
}
</script>

</head>
<body style="background-image:url(images/signup.jpg)">
<div class="header">
				<ul>
					<li style="float:left;border-right:none"><a href="cover.php" class="logo"><strong> Good Health </strong>Appointment Booking System</a></li>
					<li><a href="locateus.php">Locate Us</a></li>
					<li><a href="cover.php">Home</a></li>
				</ul>
</div>
<form action="signup.php" method="post">
	<div class="sucontainer">
		<label><b>Name:</b></label><br>
		<input type="text" placeholder="Enter Full Name" name="fname" required><br>
	
		<label><b>Date of Birth:</b></label><br>
		<input type="date" name="dob" required><br><br>
	
		<label><b>Gender</b></label><br>
		<input type="radio" name="gender" value="female">Female
		<input type="radio" name="gender" value="male">Male
		<input type="radio" name="gender" value="other">Other<br><br>
		
		<label><b>Contact No:</b></label><br>
		<input type="number" placeholder="Contact Number" name="contact" required><br>
		
		<label><b>Username:</b></label><br>
		<input type="text" placeholder="Create Username" name="username" required><br>
		
		<label><b>Email:</b></label><br>
		<input type="email" placeholder="Enter Email" name="email" required><br>

		<label><b>Password:</b></label><br>
		<input type="password" placeholder="Enter Password" name="pwd" id="p1" class="demoInputBox" onKeyUp="checkPasswordStrength();" required><br>
		<div id="password-strength-status"></div>

		<label><b>Repeat Password:</b></label><br>
		<input type="password" placeholder="Repeat Password" name="pwdr" id="p2" required><br>
		<p style="color:white">By creating an account you agree to our <a href="#" style="color:blue">Terms & Conditions</a>.</p><br>

		<div class="container" style="background-color:grey">
			<button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
			<button type="submit" name="signup" style="float:right">Sign Up</button>
		</div>
  </div>
<?php

function newUser()
{
		include 'dbconfig.php';
		$name=$_POST['fname'];
		$gender=$_POST['gender'];
		$dob=$_POST['dob'];
		$contact=$_POST['contact'];
		$email=$_POST['email'];
		$username=$_POST['username'];
		$password=$_POST['pwd'];
		$prepeat=$_POST['pwdr'];
		$hash = md5($password);
		$sql = "INSERT INTO Patient (Name, Gender, DOB,Contact,Email,Username,Password) VALUES ('$name','$gender','$dob','$contact','$email','$username','$hash') ";
	if (mysqli_query($conn, $sql)) 
	{
		echo "<h2>Record created successfully!! Redirecting to login page....</h2>";
		header( "Refresh:3; url=cover.php");

	} 
	else
	{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
function checkusername()
{
	include 'dbconfig.php';
	$username=$_POST['username'];
	$sql= "SELECT * FROM Patient WHERE Username = '$username'";

	$result=mysqli_query($conn,$sql);

		if(mysqli_num_rows($result)!=0)
		{
			echo"<b><br>Username already exists!!";
		}
		else if($_POST['pwd']!=$_POST['pwdr'])
		{
			echo"Passwords dont match";
		}
		else if(isset($_POST['signup']))
		{ 
			newUser();
		}

	
}
if(isset($_POST['signup']))
{
	if(!empty($_POST['username']) && !empty($_POST['pwd']) &&!empty($_POST['fname']) &&!empty($_POST['dob'])&& !empty($_POST['gender']) &&!empty($_POST['email']) && !empty($_POST['contact']))
			checkusername();
}
?>

</form>
</body>
</html>