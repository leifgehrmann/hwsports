					</div>
				</div>
			</div>
			<div id="footer">
				<div id="footer-block">
					<div id="footer-contact">
						<h1>Contact Us</h1>
						<? 
						$lines = explode("\n",$centre['publicTitle']);
						for($lines as $line){?>
						<p><?=$line?></p>
						<? } ?>
					</div>
					<div id="footer-links">
						<h1>Links</h1>
						<p><a href="http://www.hw.ac.uk">Heriot Watt University Homepage</a></p>
						<p><a href="#">Some other footer nonsense</a></p>
						<p><a href="#">Hopefully we will fix this</a></p>
						<p><a href="#">Privicy Policy</a></p>
						<p><a href="http://www.infusionsports.co.uk">About InfusionSports</a></p>
					</div>
					<div id="footer-powered">
						<h1>Powered By</h1>
						<a href="http://www.infusionsports.co.uk"><div class="product-logo"></div></a>
						<a href="http://www.infusionsystems.co.uk"><div class="company-logo"></div></a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>