<?php

use Base\Formats as BaseFormats;

/**
 * Skeleton subclass for representing a row from the '_formats' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Formats extends BaseFormats
{
  public function getConfigSys()
  {
    $_c = json_decode($this->__config__);
    if ($_c === NULL) {
      $_c = new stdClass();
    }
    $_c->parentnode = $this->getParentnode();
    $_c->editorcolumns = $_c->editorcolumns ? $_c->editorcolumns : [];
    $_c->locale = $_c->locale ? $_c->locale : [];
    return json_encode($_c);
  }
  
  public function setConfigSys($v)
  {

      // Setting Parentnode
      $_c = json_decode($v);
      if ($_c->parentnode) {
        $this->setParentnode($_c->parentnode);
      }

      return parent::setConfigSys($v);
  } // setConfigSys()

}
