<!DOCTYPE html>
<html>
<head>
	<title>Submit Form Without Refreshing Page</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link href="css/refreshform.css" rel="stylesheet">
	<script src="js/refreshform.js"></script>
</head>
<body>
	<div id="mainform">
		<h2>Submit Form Without Refreshing Page</h2>
		<!-- Required Div Starts Here -->
		<form id="form" name="form">
			<h3>Fill Your Information!</h3>
			<label>Name:</label>
			<input id="name" placeholder="Your Name" type="text">
			<label>Email:</label>
			<input id="email" placeholder="Your Email" type="text">
			<label>Contact No.</label>
			<input id="contact" placeholder="Your Mobile No." type="text">
			<label>Gender:</label>
			<input name="gender" type="radio" value="male">Male
			<input name="gender" type="radio" value="female">Female
			<label>Message:</label>
			<textarea id="msg" placeholder="Your message..">
			</textarea>
			<input id="submit" type="button" value="Submit">
		</form>
	</div>
</body>
</html>