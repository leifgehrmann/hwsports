<h1>Welcome to HW Sports! </h1>

<div id="infoMessage"><?php echo (isset($message) ? $message : '');?></div>

<? print_r($currentUser); //$currentUser->username ?>
<a href="<?= base_url('auth/login') ?>">Login</a>