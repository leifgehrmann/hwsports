<h1>Welcome to HW Sports!</h1>

(centre ID: <?=$this->session->userdata('centreID');?>)


<div id="infoMessage"><?php echo $message;?></div>

<? print_r($currentUser); //$currentUser->username ?>
<a href="<?= base_url('auth/login') ?>">Login</a>