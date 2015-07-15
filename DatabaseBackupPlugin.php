<?php
/**
 * DatabaseBackup class - Represents the DatabaseBackup plugin
 *
 * @package DatabaseBackup
 * @copyright anne[dot]lhote[at]sciencespo.fr - Sciences Po
 * @license GLP - https://www.gnu.org/licenses/gpl-3.0.en.html
 */


/**
 * DatabaseBackup plugin
 */
class DatabaseBackupPlugin extends Omeka_Plugin_AbstractPlugin
{
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array('define_acl');

    /**
     * @var array Filters for the plugin.
     */
    protected $_filters = array('admin_navigation_main');

    /**
     * Define the ACL.
     * 
     * @param array $args
     */
    public function hookDefineAcl($args)
    {
         $acl = $args['acl']; // get the Zend_Acl
         $acl->addResource('DatabaseBackup_Index');
    }

    /**
     * Add the DatabaseBackup link to the admin main navigation.
     * 
     * @param array Navigation array.
     * @return array Filtered navigation array.
     */
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Database Backup'),
            'uri' => url('database-backup'),
            'resource' => 'DatabaseBackup_Index',
            'privilege' => 'index',
            'class' => 'nav-database-backup'
        );
        return $nav;
    }
}
