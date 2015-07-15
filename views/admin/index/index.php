<?php
/**
 * DatabaseBackup - Admin index view.
 * 
 * @package DatabaseBackup
 * @subpackage Views
 * @copyright anne[dot]lhote[at]sciencespo.fr - Sciences Po
 * @license GLP - https://www.gnu.org/licenses/gpl-3.0.en.html
 */

$head = array(
    'title'      => 'Database Backup',
    'body_class' => 'primary database-backup'
);
echo head($head);
?>

<style type="text/css">
.database-backup button > a {
    color: white;
}
</style>

<div id="primary" class="database-backup">
    <?php echo flash(); ?>
    <h2>Database Backup</h2>
    <button>
        <a href="<?php echo $this->fileName; ?>" download="<?php echo 'backup-' . time() . '.sql' ?>">Backup Database</a>
    </button>
</div>

<?php echo foot(); ?>