<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
    </div>
    <!-- Fin Contenu -->
      
    <?php if(useSidebar()){ ?>
      <!-- Sidebar -->
      <aside id="sidebar" class="large-3 columns">
        <?php show::showSidebarItems(); ?>
      </aside>
      <!-- Fin Sidebar -->
    <?php } ?>      
  </div>

  <!-- Fin Contenu et Sidebar -->

      <!-- Footer -->

      <footer class="row">
        <div class="large-12 columns">
            <hr />
            <div class="row">
              <div class="large-6 columns">
                  <p>&copy; Copyright <?php echo date('Y') ?> <a title="<?php show::showSiteDescription(); ?>" href="<?php show::showSiteUrl(); ?>"><?php show::showSiteName(); ?></a> &middot; <?php echo lang('Generate in ');show::showExecTime(); ?>s</p>
              </div>
 
              <div class="large-6 small-12 columns">
                  <ul class="inline-list right">
                    <li><?php show::showTheme(); ?></li>
                    <li><a rel="nofollow" href="<?php echo ADMIN_PATH ?>"><?php echo lang('Administration') ?></a></li>
                    <li><?php echo lang("<a href='http://99ko.hellojo.fr' title='CMS sans base de données' onclick='window.open(this.href);return false;'>Just using 99ko</a>") ?></li>
                  </ul>
              </div>
 
            </div>
        </div>
      </footer>
 
    <!-- Fin Footer <?php echo $compressed; ?> -->
  
    <!-- Scripts -->
    <script src="<?php echo ADMIN_PATH ?>assets/js/foundation.min.js?v=5.2.1"></script>
    <script>$(document).foundation();</script>
    <?php eval(callHook('endFrontBody'));   // Appel du hook pour les plugins dans le pied de page  ?>
  </body>
</html>
