<?php

/**
 * 99ko cms
 *
 * This source file is part of the 99ko cms. More information,
 * documentation and support can be found at http://99ko.hellojo.fr
 *
 * @package     99ko
 *
 * @author      Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
 * @copyright   2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2010 Jonathan Coulet (j.coulet@gmail.com)  
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined('ROOT') OR exit('No direct script access allowed');

/*
 * define
 * constantes
 *
 */

// version du core
define('VERSION',            '1.4.3');
// permet d'activer le mode debug
define('DEBUG', false);
// temps d'activité dans la zone admin avant logout force
define('INACTIVITY_TIMEOUT',  1800);
// chemin dossier common
define('COMMON',       ROOT. 'common/');
// chemin dossier lang core
define('LANG',       COMMON. 'lang/');
// chemin dossier data core
define('DATA',         ROOT. 'data/');
// chemin dossier data core
define('USERS',        ROOT. 'data/users.json');
// chemin dossier upload
define('UPLOAD',       ROOT. 'data/upload/');
// chemin dossier data plugins
define('DATA_PLUGIN',  ROOT. 'data/plugin/');
// chemin dossier themes
define('THEMES',       ROOT. 'theme/');
// chemin dossier plugins
define('PLUGINS',      ROOT. 'plugin/');
// chemin dossier admin
define('ADMIN_PATH',   ROOT. 'admin/');
// chemin fichier timezones
define('TIMEZONES',       ROOT. 'common/timezones.json');
// key genere lors de l'install
if(file_exists(DATA.'key.php')) include(DATA.'key.php');

?>