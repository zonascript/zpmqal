<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
	<div>

		<div id="form-content">
     <form method="post" id="reg-form" autocomplete="off">
			
	<div class="form-group">
	<input type="text" class="form-control" name="txt_fname" id="lname" placeholder="First Name" required />
	</div>
				
	<div class="form-group">
	<input type="text" class="form-control" name="txt_lname" id="lname" placeholder="Last Name" required />
	</div>
				
	<div class="form-group">
	<input type="text" class="form-control" name="txt_email" id="lname" placeholder="Your Mail" required />
	</div>
				
	<div class="form-group">
	<input type="text" class="form-control" name="txt_contact" id="lname" placeholder="Contact No" required />
	</div>
				
	<hr />
				
	<div class="form-group">
	<button class="btn btn-primary">Submit</button>
	</div>
				
    </form>     
</div>

		<?php

			if( $_POST ){
				
			    $fname = $_POST['txt_fname'];
			    $lname = $_POST['txt_lname'];
			    $email = $_POST['txt_email'];
			    $phno = $_POST['txt_contact'];

			    ?>
			    
			    <table class="table table-striped" border="0">
			    
			    <tr>
			    <td colspan="2">
			    	<div class="alert alert-info">
			    		<strong>Success</strong>, Form Submitted Successfully...
			    	</div>
			    </td>
			    </tr>
			    
			    <tr>
			    <td>First Name</td>
			    <td><?php echo $fname ?></td>
			    </tr>
			    
			    <tr>
			    <td>Last Name</td>
			    <td><?php echo $lname ?></td>
			    </tr>
			    
			    <tr>
			    <td>Your eMail</td>
			    <td><?php echo $email; ?></td>
			    </tr>
			    
			    <tr>
			    <td>Contact No</td>
			    <td><?php echo $phno; ?></td>
			    </tr>
			    
			    </table>
			    <?php
				
			}
			?>
	</div>
	
	<script type="text/javascript">
		$('#reg-form').submit(function(e){
		    e.preventDefault(); // Prevent Default Submission
				
		    $.ajax({
			url: 'submitform.php',
			type: 'POST',
			data: $(this).serialize(), // it will serialize the form data
		        dataType: 'html'
		    })
		    .done(function(data){
			    $('#form-content').fadeOut('slow', function(){
			         $('#form-content').fadeIn('slow').html(data);
		        });
		    })
		    .fail(function(){
			alert('Ajax Submit Failed ...');	
		    });
		});

	</script>
</body>
</html>