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
 * Définition des constantes
 *
 */

# Version de 99ko
define('VERSION',            '1.6.1');
# Permet d'activer le Débogage PHP @param true:false
# define('DEBUG',               false);
# Emplacement des librairies (dossier)
define('COMMON',       ROOT. 'common/');
# Emplacement de la lang du core (dossier)
define('LANG',       COMMON. 'lang/');
# Emplacement de stockage des données (dossier)
define('DATA',         ROOT. 'data/');
# Emplacement des fichiers téléchargés (dossier)
define('UPLOAD',       ROOT. 'data/upload/');
# Emplacement des données des plugins (dossier)
define('DATA_PLUGIN',  ROOT. 'data/plugin/');
# Emplacement des thèmes (dossier)
define('THEMES',       ROOT. 'theme/');
# Emplacement des plugins (dossier)
define('PLUGINS',      ROOT. 'plugin/');
# Emplacement de l'administration (dossier)
define('ADMIN_PATH',   ROOT. 'admin/');
# Inclusion de la clé générée lors de l'installation
if(file_exists(DATA.'key.php')) include(DATA.'key.php');

?>
