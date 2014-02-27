<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
    </div>
    <!-- Fin Contenu -->
      
      <!-- Sidebar -->
      
      <?php if($sidebar){ ?>
      <aside id="sidebar" class="large-3 columns">
        <?php showSidebarItems('<div class="panel" id="[id]"><h2>[title]</h2>[content]</div>'); ?>
      </aside>
      <?php } ?>
      
      <!-- Fin Sidebar -->
      
  </div>

  <!-- Fin Contenu et Sidebar -->


      <!-- Footer -->

      <footer class="row">
        <div class="large-12 columns">
            <hr />
            <div class="row">
              <div class="large-6 columns">
                  <p>&copy; Copyright <?php echo date('Y') ?> <a title="<?php showSiteDescription(); ?>" href="<?php showSiteUrl(); ?>"><?php showSiteName(); ?></a> &middot; <?php echo lang('Generate in ');showExecTime(); ?>s</p>
              </div>
 
              <div class="large-6 small-12 columns">
                  <ul class="inline-list right">
                    <li><?php showTheme(); ?></li>
                    <li><a rel="nofollow" href="<?php echo ADMIN_PATH ?>"><?php echo lang('Administration') ?></a></li>
                    <li><?php echo lang("<a href='http://99ko.hellojo.fr' title='CMS sans base de données' onclick='window.open(this.href);return false;'>Just using 99ko</a>") ?></li>
                  </ul>
              </div>
 
            </div>
        </div>
      </footer>
 
    <!-- Fin Footer <?php echo $compressed; ?> -->
  
    <!-- Scripts -->
    <script src="<?php echo ADMIN_PATH ?>js/all.js"></script>
    <script>
      $(document).foundation();    
    </script>
    <?php eval(callHook('endFrontBody'));   // Appel du hook pour les plugins dans le pied de page  ?>
  </body>
</html>
