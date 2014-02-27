<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		          <?php if($tabs){ ?>
                         </div>
                      </div>
		          <?php } ?>
	
            </div> <!-- /large-9 medium-8 columns -->
          </div> <!-- /row -->
        </section>

      <a class="exit-off-canvas"></a>

      </div> <!-- /inner-wrap -->
    </div> <!-- /marketing off-canvas-wrap -->
    
    <script src="js/all.js?v=5.0.3"></script>  
    <script src="js/scripts.js"></script>
    <script>
            $(document).foundation();
    </script>
    <?php eval(callHook('endAdminBody')); ?>
  </body>
</html>