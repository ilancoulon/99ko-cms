<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		          <?php if($tabs){ ?>
                         </div>
                      </div>
		          <?php } ?>
		            <!-- NOTICATIONS -->
				  	<div id="notifs" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				  			<h2 id="modalTitle">Notifications</h2>
				  			<?php eval(callHook('notifsAdminHome')); ?>
				  			<p>Nouveau hook 'notifsAdminHome', on pourrais donc compter le nombre de notifications en homepage de l'admin et indiquer ce nombre dans le menu (header.php). Cela permet une meilleur visibilité de cette page d'accueil dont on charge le plugin page par défaut.</p>
				  			<p>Ensuite on pourrait remplacer le paramètre de la sidebar en config :<pre>    "sidebarTitle" : "",
    "sidebarCallFunction" : "",</pre> par : <pre> "HomePage" : "1"</pre></p>
    						<p>Quand penses-tu ?</p>
							<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>
					<!-- /NOTICATIONS -->
		
            </div> <!-- /large-9 medium-8 columns -->
          </div> <!-- /row -->
        </section>

      <a class="exit-off-canvas"></a>

      </div> <!-- /inner-wrap -->
    </div> <!-- /marketing off-canvas-wrap -->
    
    <script src="assets/js/scripts.js"></script>
    <?php eval(callHook('endAdminBody')); ?>
  </body>
</html>
