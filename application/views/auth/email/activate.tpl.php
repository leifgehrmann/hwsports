<html>
<body>
	<h1>Activate your account</h1>
	<p>
		Please click this link to <?php echo anchor('auth/activate/'. $id .'/'. $activation, 'Activate Your Account');?>.</p>
	<p>
		If you've received this mail in error, it's likely that another user 
		entered your email address while trying to create an account for a different 
		email address. If you don't click the verification link, the account won't 
		be activated.
	</p>
</body>
</html>