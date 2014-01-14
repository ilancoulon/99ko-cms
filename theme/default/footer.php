    <!-- Footer -->
 
      <footer class="row">
        <div class="large-12 columns"><hr>
            <div class="row">
 
              <div class="large-6 columns">
                  <p>&copy; Copyright <?php echo date('Y') ?> <a title="<?php showSiteDescription(); ?>" href="<?php showSiteUrl(); ?>"><?php showSiteName(); ?></a> &middot; <?php echo lang('Generate in ');showExecTime(); ?>s</p>
              </div>
 
              <div class="large-6 small-12 columns">
                  <ul class="inline-list right">
                    <li><?php showTheme(); ?></li>
                    <li><a rel="nofollow" href="admin/"><?php echo lang('Administration') ?></a></li>
                    <li><?php echo lang('Just using') ?></li>
                  </ul>
              </div>
 
            </div>
        </div>
      </footer>
 
    <!-- End Footer -->
 
    </div>
  </div>
  
    <!-- Scripts -->
    <script src="admin/js/all.js"></script>
    <script>
      $(document).foundation();

      var doc = document.documentElement;
      doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
    <?php eval(callHook('endFrontBody')); ?>
  </body>
</html>
