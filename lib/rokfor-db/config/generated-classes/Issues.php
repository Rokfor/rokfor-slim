<?php

use Base\Issues as BaseIssues;

/**
 * Skeleton subclass for representing a row from the '_issues' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Issues extends BaseIssues
{

  public function getConfigSys()
  {
    $_c = json_decode($this->__config__);
    if (!is_object($_c)) {
       $_c = new stdClass();
    }
    $_c->editorcolumns = $_c->editorcolumns ? $_c->editorcolumns : [];
    $_c->locale = $_c->locale ? $_c->locale : [];
    return json_encode($_c);
  }
  

}
