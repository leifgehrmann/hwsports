					</div>
				</div>
			</div>
			<div id="footer">
				<div id="footer-block">
					<div id="footer-contact">
						<h1>Contact Us</h1>
						<? $lines = explode("\n",$centre['publicFooterContact']);
						foreach($lines as $line){?>
						<p><?=$line?></p>
						<? } ?>
					</div>
					<div id="footer-links">
						<h1>Links</h1>
						<? $lines = explode("\n",$centre['publicFooterLinks']);
						for($i=0;i<count($lines)/2;i++){?>
						<p><a href="<?=$lines[i*2]?>"><?=$lines[i*2+1]?></a></p>
						<? } ?>
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