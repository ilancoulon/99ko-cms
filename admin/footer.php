<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		          <?php if($tabs){ ?>
                         </div>
                      </div>
		          <?php } ?>

		            <!-- NOTICATIONS -->
				  	<div id="notifs" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				  			<h2 id="modalTitle"><?php echo lang('Notifications center'); ?></h2>
				  			<?php
				  				echo showMsg($notif1, $notif1Type);
				  				echo showMsg($notif2, $notif2Type);
				  				echo showMsg($notif3, $notif3Type);
				  				echo showMsg($notif4, $notif4Type);
				  				echo showMsg($notif5, $notif5Type);
							?>
							<?php eval(callHook('adminNotifications')); ?>
							<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>
					<!-- /NOTICATIONS -->
		
            </div> <!-- /large-9 medium-8 columns -->
          </div> <!-- /row -->
        </section>

      <a class="exit-off-canvas"></a>

      </div> <!-- /inner-wrap -->
    </div> <!-- /nav off-canvas-wrap -->
    
    <script src="assets/js/scripts.js"></script>
    <?php eval(callHook('endAdminBody')); ?>
  </body>
</html>
