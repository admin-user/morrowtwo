<?php

/*////////////////////////////////////////////////////////////////////////////////
    MorrowTwo - a PHP-Framework for efficient Web-Development
    Copyright (C) 2009  Christoph Erdmann, R.David Cummins

    This file is part of MorrowTwo <http://code.google.com/p/morrowtwo/>

    MorrowTwo is free software:  you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
////////////////////////////////////////////////////////////////////////////////*/





class DBSession extends Session{

	/**
		Table Structure
			 - Table name may vary and must be set in $config['session.db.table']

		CREATE TABLE `sessions` (
		  `session_id` varchar(32) NOT NULL default '',
		  `session_data` text NOT NULL,
		  `session_expiration` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  PRIMARY KEY  (`session_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;

	**/
 
	private $config = null;
	private $db = null;
	private $format = '%Y%m%d%H%M%S';
	private $table = null;

 	public function __construct($data){
		if (ini_get('session.auto_start') == true){
			trigger_error('You must turn off session.auto_start in your php.ini or use different session handler');

		}

		#setting the session handlers
		$junk =  session_set_save_handler(array($this, "on_session_start"),array($this,"on_session_end"),array($this,"on_session_read"),array($this,"on_session_write"),array($this,"on_session_destroy"),array($this,"on_session_gc"));

		$this->config = Factory::load('config');
		$this->db = Factory::load('db',$this->config->get('session.db'));

		#important!: call the parent constructor
		parent::__construct($data);
	}



	public function on_session_start($save_path, $session_name) {
	}

	public function on_session_end() {
		// Nothing needs to be done in this function
		// since we used persistent connection.
	}

	public function on_session_read($key) {
		$stmt = "select session_data from " . $this->config->get('session.db.table');
		$stmt .= " where session_id = ? ";
		$stmt .= "and session_expiration > ?";

		$sth = $this->db->Result($stmt, array($key, strftime($this->format))); 
		
		if($sth['NUM_ROWS'] > 0)
		{
			return($sth['RESULT'][0]['session_data']);
		}
		else
		{
			return '';
		}
	}
	public function on_session_write($key, $val) {
		$expires = '+' . ini_get('session.cache_expire') . ' Minutes';

		$data = array(
				'session_id' => $key,
				'session_data' => $val,
				'session_expiration' => strftime($this->format, strtotime($expires)),
				);


		$this->db->replace( $this->config->get('session.db.table'), $data);
		
	}

	public function on_session_destroy($key) {

		$this->db->delete($this->config->get('session.db.table'), "where session_id = ?", false, $key);

	}

	public function on_session_gc($max_lifetime) 
	{
		
		$this->db->delete($this->config->get('session.db.table'), "where session_expiration < ?", false, strftime($this->format));

	}
}