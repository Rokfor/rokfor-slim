<?php

use Base\Contributions as BaseContributions;
use Propel\Runtime\ActiveQuery\Criterion\LikeCriterion;

class Contributions extends BaseContributions
{
  
  private function debuglog($msg) {
    file_put_contents('test.log', "$msg\n", FILE_APPEND);
  }

  function updateCacheLegacy(&$s) {
    // This might be a little bit strict but
    // ensures, that caches of related contributions
    // are deleted as well

    // Clearing Contributions with Data referring to this contribution




    foreach ($this->getRDatas() as $r) {
      try {
        if (in_array($r->getContributions()->getId(), $s) === false) {
          $s[] = $r->getContributions()->getId();
        }
      } catch (Exception $e) {}
    }

    // Cycle thru fields

    foreach ($this->getDatas() as $f) {

      // Field to Contribution
      //  Gets an array of ChildRDataContribution objects which
      //  contain a foreign key that references this object.

      foreach ($f->getRDataContributions() as $c) {
        try {
          if (in_array($c->getRContribution()->getId(), $s) === false) {
            $s[] = $c->getRContribution()->getId();
          }          
        } catch (Exception $e) {}

      }

      // Field to Field
      //  Gets a collection of ChildData objects
      //  related by a many-to-many relationship

      foreach ($f->getRDataRefs() as $c) {
        try {
          if (in_array($c->getContributions()->getId(), $s) === false) {
            $s[] = $c->getContributions()->getId();
          }  
        } catch (Exception $e) {}
      }

      // Many to Many Relations...

      foreach ($f->getRContributions() as $c) {
        try {
          if (in_array($c->getId(), $s) === false) {
            $s[] = $c->getId();
          }            
        } catch (Exception $e) {}
      }
    }
    return $this;
  }
  
  
  function updateCache() {
    $oneYearAgo = new DateTime();
    $oneYearAgo->modify('-1 year');
    try {
      /* 
      
      It seems that this way we're deleting way too many cached entries...

      $existing = \ContributionscacheQuery::create()
        ->filterByContribution('%|'.$this->getId().'|%',  \Propel\Runtime\ActiveQuery\Criteria::LIKE)
        ->find();
      $likeArray = ['\\\|'.$this->getId().'\\\|'];
      foreach ($existing as $_existing) {
        foreach (explode('|', $_existing->getContribution()) as $chunk) {
          $escaped_chunk = '\\\|'.str_replace('|', '', $chunk).'\\\|';
          if ($chunk && !in_array($escaped_chunk, $likeArray, true)) {
            $likeArray[] = $escaped_chunk;
          }
        }
      } 

      // $this->debuglog(print_r($likeArray, true));
      \ContributionscacheQuery::create()
        ->where('_contributions_cache._contribution REGEXP ?', join('|', $likeArray))
        ->_or()
        ->filterByTouched(array('max' => $oneYearAgo->format('Y-m-d H:i:s')))
        ->delete();
      */

      /*
       Step 1: Delete all contributions related to this, and this one itself
      */

      \ContributionscacheQuery::create()
        ->filterByContribution('%|'.$this->getId().'|%',  \Propel\Runtime\ActiveQuery\Criteria::LIKE) 
        ->_or()
        ->filterByTouched(array('max' => $oneYearAgo->format('Y-m-d H:i:s')))
        ->delete();        

      /*
       Step 2: Delete all entries which are bound to a referenced contribution
      */

      $w = [];
      $this->updateCacheLegacy($w);
      sort($w);
      if (count($w) > 0) {
        \ContributionscacheQuery::create()
        ->filterByForcontribution($w)
        ->delete();
      }

    } catch (\Throwable $th) {
     }
    return $this;
  }
  
                
  function checkCache($signature) {
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->add('_signature', $signature, \Propel\Runtime\ActiveQuery\Criteria::EQUAL);
    $c = $this->getContributionscaches($criteria);
    if ($c->count() > 0) {
      $c->getFirst()->setTouched(new \DateTime())->save();
      return json_decode($c->getFirst()->getCache());
    }
    return false;
  }
  
}
