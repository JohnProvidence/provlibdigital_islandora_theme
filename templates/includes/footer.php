<footer class="footer site-footer <?php print $classes; ?>" role="contentinfo">

  		<div class="site-footer__wrapper">

  			<div class="site-footer__identity">

  				<div class="site-branding">
	  				<div class="site-footer__library-name">
	  					<?php print $library_name; ?>
	  				</div>

	  				<div class="site-footer__collections-name">
	  					<?php print $dc; ?>
	  				</div>
  				</div>

  				<div class="site-footer__social-icons">
  					<?php if(theme_get_setting('pld_social_media_links_spc_twitter')):
  						$spc_twitter = theme_get_setting('pld_social_media_links_spc_twitter');
  					?>
  						<a href="<?php print $spc_twitter; ?>" class="icon">
  							<i class="fab fa-twitter" aria-hidden="true"></i>
  					<?php endif; ?>

  					<?php if(theme_get_setting('pld_social_media_links_rc_instagram')):
  						$rc_instagram = theme_get_setting('pld_social_media_links_rc_instagram');
  					?>
  						</a>
  						<a href="<?php print $rc_instagram; ?>" class="icon">
  							<i class="fab fa-instagram" aria-hidden="true"></i>
  						</a>
  					<?php endif; ?>
  				</div>
  			</div> <!-- end .site-footer__identity -->

  			<div class="site-footer__vitals">
          <div class="footer_col">
  				  <?php print render($page['footer_col_1']); ?>
          </div>
          <div class="footer_col">
  				  <?php print render($page['footer_col_2']); ?>
          </div>
          <div class="footer_col">
  				  <?php print render($page['footer_col_3']); ?>
          </div>
  			</div>

  			<div class="site-footer__legal">
  				<span class="site-footer__legal__copyright">
  					&copy; <?php echo date('Y'); ?> <?php print $library_name; ?>
  				</span>
  				<?php if(theme_get_setting('legal_notices')):
  					$legal = theme_get_setting('legal_notices');
  				?>
  				<span>
  					<a href="<?php print $base_url . '/' . $legal; ?>">
  						Legal Notices and Policies
  					</a>
  				</span>
  				<?php endif; ?>
  				<?php if(theme_get_setting('terms')):
  					$terms = theme_get_setting('terms');
  				?>
  				<span>
  					<a href="<?php print $base_url .'/' . $terms; ?>">
  						Terms of Service
  					</a>
  				</span>
  			<?php endif; ?>
  			</div>

  		</div>

  </footer>
