<?php

/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

class HT_Model_administrator_models_inforproject extends Zend_Db_Table {

    protected $_db;
    protected $_name = "inforproject";
    protected $_primary = "inforId";
   
    public function __construct() {
    	$this->_name = "inforproject";
    	$this->_db = Zend_Registry::get('dbMain');
    	$this->_primary = "inforId";
    	parent::init();
    }

    public function getInfor($ip, $exName) {
       
        $sql = "SELECT * FROM inforproject WHERE ipaddress='" . $ip . "' AND exname='" . $exName . "'";
     
        return $this->_db->fetchRow($sql);
    }

    public function insertporject($ipAddress, $exName, $projectName) {
        $sql = $this->_db->query("INSERT INTO inforproject(ipaddress,exname,projectname) VALUES('" . $ipAddress . "','" . $exName . "','" . $projectName . "')");
        var_dump($sql);
        if ($sql > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkfolder($folderName) {
        $sql = "SELECT * FROM inforproject WHERE projectname='" . $folderName . "'";
        return $this->_db->fetchRow($sql);
    }

}
