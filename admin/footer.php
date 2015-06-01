<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		          <?php if($runPlugin->useAdminTabs()){ ?>
                         </div>
                      </div>
		          <?php } ?>

		            <!-- NOTICATIONS -->
				  	<div id="notifs" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				  			<h2 id="modalTitle"><?php echo $core->lang('Notifications center'); ?></h2>
				  			<?php foreach($core->check() as $k=>$v){ ?>
							<?php echo show::msg($v['msg'], $v['type']); ?>
							<?php } ?>
							<?php eval($core->callHook('adminNotifications')); ?>
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
    <?php eval($core->callHook('endAdminBody')); ?>
  </body>
</html>
