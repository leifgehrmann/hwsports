<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<h1>Welcome to Riccarton Tournaments</h1>
<div>
	<div class="widget half">
		<div class="widget-title">
			<div class="widget-title-left icon home"></div>
			<div class="widget-title-centre">Riccarton Tournaments</div>
			<div class="widget-title-right icon"></div>
		</div>
		<div class="widget-body">
			<p>On this website you can get the latest information about tournament events occuring on campus. This includes the calendar, scores of the matches, and winners of tournaments. You can also register here to purchase tickets and sign up for sports events.</p>
		</div>
	</div>
	<div class="widget half">
		<div class="widget-title">
			<div class="widget-title-left icon signup"></div>
			<div class="widget-title-centre">Subscribe!</div>
			<div class="widget-title-right icon"></div>
		</div>
		<div class="widget-body">
			<form method="POST" action="/subscribe/">
				<p><b>Want to keep up with sport tournament news?</b></p>
				<p>Enter in your email below to get any updates we post on the site.</p>
				<input type="text" placeholder="Your email..." name="email" style="margin-bottom:20px;"/>
				<input type="submit" value="Subscribe" class="green" name="Subscribe"/>
			</form>
		</div>
	</div>
</div>

<h1>News</h1>
<div class="widget full">
	<a href="#newsarticle">
		<div class="widget-title">
			<div class="widget-title-left icon news"></div>
			<div class="widget-title-centre">Register now!</div>
			<div class="widget-title-right icon chevron"></div>
		</div>
	</a>
	<div class="widget-body">
		<p><b>Published:</b> 14/02/2013 ~ 13:20</p>
		<p>Want to participate in the Heriot Watt Tournament, well now you can register on this website! We are offering the following sports this year.</p>
		<ul>
			<li>Heriot Hurdling (Men &amp; Womens)</li>
			<li>Wattball</li>
		</ul>
		<p>If you have already made an account, be sure to check into your account and sign up for the games you want to participate in.</p>
		<p>If you want to create a team in the Wattball tournament, you only need one member to bla bla bla.</p>
		<a href="#newsarticle" class="button right normal">Permalink</a>
	</div>
</div>
<div>
	<div class="widget half">
		<a href="#newsarticle">
			<div class="widget-title">
				<div class="widget-title-left icon news"></div>
				<div class="widget-title-centre">2013 Tournaments announced!</div>
				<div class="widget-title-right icon chevron"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Published:</b> 10/02/2013 ~ 16:20</p>
			<p>Within a couple of days, we will allow you all to register online for the sports
				tournaments. Before you can participate directly, it would be best to register
				now.
			</p>
			<a href="#newsarticle" class="button right normal">Permalink</a>
		</div>
	</div>
	<div class="widget half">
		<a href="#newsarticle">
			<div class="widget-title">
				<div class="widget-title-left icon news"></div>
				<div class="widget-title-centre">Congratulations to the winners!</div>
				<div class="widget-title-right icon chevron"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Published:</b> 12/08/2012 ~ 18:42</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
				incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis 
				nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
				Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu 
				fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in 
				culpa qui officia deserunt mollit anim id est laborum.
			</p>
			<a href="#newsarticle" class="button right normal">Permalink</a>
		</div>
	</div>
</div>