<h1>Admin View!</h1>

<h4>User info: <?= print_r($the_user,1) ?></h4>

<h1>Create User</h1>
<p>Please enter the users information below.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user"); ?>


      <p><?php echo form_submit('submit', 'Create User');?></p>

<?php echo form_close();?>

<a href="<?= site_url('front/logout') ?>">logout</a>
