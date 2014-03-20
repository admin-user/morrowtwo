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


namespace Morrow\Views;

class Jsonp extends AbstractView {
	public $mimetype = 'application/javascript';
	public $charset  = 'utf-8';
	
	public $callback = '';

	public function getOutput($content, $handle) {
		if (empty($this->callback)) $this->callback = $_REQUEST['callback'];

		fwrite($handle, $this->callback . '(');
		fwrite($handle, json_encode($content['content']));
		fwrite($handle, ');');
		return $handle;
	}
}
