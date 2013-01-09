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


namespace Morrow\Core\Libraries;

class formhtmlelementTextArea extends formhtmlelement{

	public function getDisplay($name, $values, $id, $params, $options, $multiple){	
		return "<textarea id=\"" . $id . "\" name=\"" . $name . "\" " .  HelperHtmlFormAttributes::getAttributeString($params, 'textarea')  . ">" . htmlspecialchars($values, ENT_QUOTES, $this->page->get('charset')) ."</textarea>";
	}

	public function getReadonly($name, $values, $id, $params, $options, $multiple){
		$content = '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars($values, ENT_QUOTES, $this->page->get('charset')) .'">';
                $content .= '<div '. HelperHtmlFormAttributes::getAttributeString($params, 'div') .'>'.htmlspecialchars($values, ENT_QUOTES, $this->page->get('charset')).'</div>';
                return $content;
	}	

	public function getListDisplay($values, $params, $options=array()){
		$values = helperString::truncate(htmlspecialchars($values, ENT_QUOTES, $this->page->get('charset')), 50);
		return $values;
	}	


}