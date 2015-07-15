<?php
/**
 * DatabaseBackup - Index Controller
 *
 * @package DatabaseBackup
 * @subpackage Controllers
 * @copyright anne[dot]lhote[at]sciencespo.fr - Sciences Po
 * @license GLP - https://www.gnu.org/licenses/gpl-3.0.en.html
 */

class DatabaseBackup_IndexController extends Omeka_Controller_AbstractActionController
{
    public function init() 
    {
        $this->_helper->db->setDefaultModelName('DatabaseBackup');
    }
    
    /**
     * Prepare the index view.
     * 
     * @return void
     */
    public function indexAction()
    {
        $db = get_db();
        $db->setFetchMode(Zend_Db::FETCH_NUM);

        // Retrieve all tables
        $query = 'SHOW TABLES';
        $tables = $db->query($query)->fetchAll();

        // Iterate over each database table
        $return = '';
        foreach($tables as $table)
        {
            $table = $table[0];

            // Add comment
            $return .= '/* Table ' . $table . ' /nnnn';

            // Delete table
            $return .= 'DROP TABLE IF EXISTS ' . $table . ';nnnn';

            // Create table
            $query = 'SHOW CREATE TABLE ' . $table;
            $create = $db->query($query)->fetch();
            $return .= $create[1] . ';nnnn';

            // Populate table
            $query = 'SELECT * FROM ' . $table;
            $select = $db->query($query)->fetchAll();
            if(count($select) > 0) {
                $num_fields = count($select[0]);
                for($i = 0 ; $i < count($select) ; $i++)
                {
                    if ($i == 0) {
                        $return .= 'INSERT INTO ' . $table . ' VALUES nnnn';
                    }
                    for($j = 0 ; $j < $num_fields ; $j++)
                    {
                        if($j == 0) {
                            $return .= '(';
                        }
                        $select[$i][$j] = addslashes($select[$i][$j]);
                        if (isset($select[$i][$j])) {
                            $return .= '"' . $select[$i][$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    if ($i == count($select) - 1) {
                        $return .= ');nnnn';
                    } else {
                        $return .= '),nnnn';
                    }
                }
            }
            $return .= 'nnnnnnnn';
        }

        // Save it into an SQL file
        $fileName = '../files/DatabaseBackup.sql';
        $handle = fopen($fileName, 'w+');
        fwrite($handle, str_replace('nnnn', PHP_EOL, $return));
        fclose($handle);

        $this->view->fileName = $fileName;
    }
}
