<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Person extends BasePerson
{
  public function setNameMiddle($str)
  {
    parent::_set('name_middle', LsRequestFilter::emptyStringToNull(preg_replace('/[.]/', '', $str)));
  }


  public function getFullName($useNickName=true, $filterSuffix=false)
  {
    if ($filterSuffix)
    {   
      $allowedSuffixes = array('Jr', 'Sr', 'II', 'III', 'IV', 'V');
      $newSuffixes = array();

      foreach ($allowedSuffixes as $suffix)
      {
        if (preg_match('/(^| )' . $suffix . '( |$)/i', $this->name_suffix))
        {
          $newSuffixes[] = $suffix;
        }
      }
      
      $suffix = implode(' ', $newSuffixes);
    }
    else
    {
      $suffix = $this->name_suffix;
    }
    

    $full = $this->name_prefix . ' ' . 
      $this->name_first . ' ' . 
      $this->name_middle . ' ' .
      ($useNickName && $this->name_nick ? '"' . $this->name_nick . '"' : '') . ' ' .
      $this->name_last . ' ' .
      $suffix;
    $full = trim(preg_replace("/\s+/i", ' ', $full));

    return $full; 
  }
  
  
  public function onEntitySave(Entity $entity)
  {
    //save to entity name only if doesn't exist
    if (!$entity->rawGet('name'))
    {
      $entity->setEntityField('name', $this->getFullName(false));
    }
  }
  
  public function getLastNameRegex()
  {
    $last_re = preg_replace("/(\p{Ll})/eu","'['.'\\1'.strtoupper('\\1').']'",$this->name_last);
    $last_re = preg_replace('/[\s-]+/su','[\s-]+',$last_re);
    return $last_re;
  }
  
  public function getNameRegexes()
  {
    $regexes = array(self::getNameRegex());
    foreach ($this->Entity->Alias as $alias)
    {
      $p = PersonTable::parseFlatName($alias->name);
      $regexes[] = $p->getNameRegex(); 
    }
    return $regexes;
  }
  
  public function getNameRegex($first_required = false)
  {
    $last_re = $this->getLastNameRegex();
    $name_first = $this->name_first;
    if (isset(PersonTable::$shortFirstNames[$name_first]))    
    {
      $fn_arr = (array) PersonTable::$shortFirstNames[$name_first];
      $name_first = $this->name_first . ' ' . implode(' ', $fn_arr);
    }
    if ($first_required)
    {
      $fm = $this->name_middle . ' ' . $this->name_nick;
    }
    else
    {
      $fm = $name_first . ' ' . $this->name_middle . ' ' . $this->name_nick;
    }
    $fm_arr = preg_split('/[\s-]+/',$fm,-1,PREG_SPLIT_NO_EMPTY);
    $initials = '';
    foreach($fm_arr as &$fm)
    {
      $len = strlen(LsString::stripNonAlpha($fm));
      $fm = preg_replace("/(\p{Ll})/e","'['.'\\1'.strtoupper('\\1').']'",$fm);
      $initials .= strtoupper($fm[0]);
      //if string is longer than 3, then 
      if ($len > 3)
      {
        $offset = strpos($fm,']',strpos($fm,']') + 1) +1;
        $str = substr($fm,$offset);
        $str = str_replace(']',']?',$str);
        $fm = substr($fm,0,$offset) . $str;
      }
    }
    
    $fm = implode('|',$fm_arr);
    $separator = '\b([\'"\(\)\.]{0,3}\s+|\.\s*|\s?-\s?)?';
    
    if ($first_required)
    {
      $nf_arr = LsString::split($name_first);
      foreach($nf_arr as &$nf)
      {
        $nf = preg_replace("/(\p{Ll})/e","'['.'\\1'.strtoupper('\\1').']'",$nf);
      }
      $name_first = implode('|',$nf_arr);
      $re = '((\b(' . $name_first . ')' . $separator . '(' . $fm . '|[' . $initials . '])?' . $separator . '((\p{L}|[\'\-])+' . $separator . ')?)+((' . $last_re . ')\b))';    
    } 
    else
    {
      $re = '((\b(' . $fm . '|[' . $initials . '])' . $separator . '((\p{L}|[\'\-])+' . $separator . ')?)+((' . $last_re . ')\b))';
    }
    
    return $re;
  }
  
  public function getExtendedBio()
  {
    $orgs = $this->Entity->getRelatedEntitiesQuery('Org', RelationshipTable::POSITION_CATEGORY,null,null,null,false,1)->execute();  
    $orgs = $this->Entity->getRelatedEntitiesQuery('Org', RelationshipTable::MEMBERSHIP_CATEGORY,null,null,null,false,1)->execute();
    //$orgs = $orgs->merge($membership_orgs);
    //$orgs = $q->execute();
    $bio = $this->Entity->blurb . ' ' . $this->Entity->summary;            
    /*$aliases = $this->Entity->Alias;            
          
    foreach ($aliases as $alias)
    {
      $alias_name = LsLanguage::getCommonPronouns($this->Entity->name, 
                                                  $alias->name, 
                                                  array_merge( LsLanguage::$business,
                                                    LsLanguage::$schools,
                                                    LsLanguage::$grammar,
                                                    LsLanguage::$states,
                                                    LsLanguage::$geography,
                                                    array(
                                                      $this->name_last,
                                                      $this->name_first,
                                                      $this->name_middle,
                                                      $this->name_nick,
                                                      'Retired',
                                                      'Requested',
                                                      'Info',
                                                      'Employed'
                                                     )
                                                   )
                                                  );
      
      $bio .= ' ' . $alias_name;        
    }*/
    foreach ($orgs as $org)
    {
      $names = $org->getAllNames();
      foreach($names as $name)
      {
        $bio .= ' ' . $name;
      }
    }
    return $bio;
  } 
  
    
  public function getCommonBioPronouns($str)
  {
    $eb = $this->getExtendedBio();
    
    $summary_matches = LsLanguage::getCommonPronouns(LsLanguage::titleize(trim($eb)), trim($str), array_merge(
      LsLanguage::$business,
      LsLanguage::$schools,
      LsLanguage::$grammar,
      LsLanguage::$states,
      LsLanguage::$geography,
      array(
        $this->name_last,
        $this->name_first,
        $this->name_middle,
        $this->name_nick,
        'Retired',
        'Requested',
        'Info',
        'Employed'
        )));
     
     return $summary_matches;
      
  } 
  
  public function checkAffiliations($arr, $rel_category = RelationshipTable::POSITION_CATEGORY)
  {
    $orgs = $this->Entity->getRelatedEntitiesQuery('Org', $rel_category,null,null,null,false,1)->execute();
    $matching = array();  
    $match = false;
    foreach($arr as $a)
    {
      foreach($orgs as $org)
      {
        if ($org->hasSimilarName($a))
        {
          $match = $org;
        }
      }
    }     
    return $match;
  }
  
  public function parseBio($bio = null)
  {
    if (!$bio)
    {
      $bio = $this->Entity->summary;
    }
    $name_matches = LsLanguage::getAllNames($bio);
    $names = array();

    for ($i = 0; $i < count($name_matches); $i++)
    {
      $name = $name_matches[$i];
      $arr = array('for\s+the', 'of\s+the', 'at\s+the', 'at','of','the','for','and');
      foreach($arr as $a)
      {
        $splat = preg_split('/\s+' . $a . '\s+/isu',$name,-1,PREG_SPLIT_NO_EMPTY);
        if (count($splat) > 1)
        {
          if (!in_array($splat[0], LsLanguage::$commonPositions))
          {
            $name_matches = array_merge($name_matches, $splat);
          }
          else
          {
            array_shift($splat);
            $a = str_replace('\s+',' ', $a);
            $name = implode(" $a ",$splat); 
          }
        }
      }  
      
      $splat = preg_split('/\'s\s+/isu',$name,-1,PREG_SPLIT_NO_EMPTY);

      if (count($splat) > 1)
      {
        $name_matches = array_merge($name_matches, $splat);
      }    

    }
    unset($name);

    $exclude = array_merge(LsLanguage::$regions, LsLanguage::$commonFirstNames, LsLanguage::$commonLastNames, LsLanguage::$states, LsLanguage::$commonCities, LsLanguage::$grammar, LsLanguage::$weekdays, LsLanguage::$months, LsLanguage::$geography, LsLanguage::$possessives, explode(' ', $this->Entity->name), array($this->Entity->name), LsLanguage::$schools, LsLanguage::$commonPositions);
    
    $names = array();
    foreach($name_matches as $name)
    {
      $new = str_replace("'s "," ", $name);
      if ($new != $name) $name_matches[] = $new;
      $name = trim($name);
      $name = preg_replace('/[\,\.\'\’]$/isu','',$name);
      if (!in_array($name, $exclude))
      {
        $names[] = $name;
      }
      //else $this->printDebug($name . ' rejected');
    }
    $names = array_unique($names);
    $names = LsArray::strlenSort($names);
    
    /*
    $found_entities = array();
   
    foreach($names as $name)
    {
      
      $entities = EntityTable::getByExtensionAndNameQuery(array('Person'),$name, $strict = 1)->execute();
      if (count($entities))
      {
        //$this->printDebug($name . ":");
        foreach($entities as $e)
        {
          //$this->printDebug('  ' . $org->name);
          $found_entities[] = $e;
        }
      }
      else if (count(LsString::split($name)) > 1)
      {
        $possible_orgs = array();
        $google_scraper = new LsGoogle;
        $google_scraper->setQuery(trim($name));
        $google_scraper->execute();
        if ($google_scraper->getNumResults())
        {
          $results = $google_scraper->getResults();
          foreach ($results as $result)
          {
            $title = LsHtml::stripTags($result->title);
            preg_match('/http\:\/\/[^\/]+\//isu',$result->unescapedUrl,$match);
            if (!$match) continue;      
            $trimmed_url = $match[0];
            $title_first = LsString::split($title);
            $title_first = array_shift($title_first);
            if (!stristr($title,'wikipedia') && (OrgTable::checkUrl($trimmed_url, $name) && preg_match('/^(The\s+)?' . LsString::escapeStringForRegex($title_first) . '/su',$name)))
            {
              $this->printDebug($name . ":");
              $possible_orgs[] = $name;
              $this->printDebug('   ' . $title);  
              //$this->printDebug('     ' . $result->unescapedUrl); 
              //$this->printDebug('      ' . LsHtml::stripTags($result->content));
              break;           
            }
            
          }
        }
        //var_dump($possible_orgs);
      }
    }*/
    //$this->printDebug('');
    return $names;
  }
  
  public function getRelatedOrgsSummary()
  {
    $orgs = $this->Entity->getRelatedEntitiesQuery('Org', array(RelationshipTable::POSITION_CATEGORY, RelationshipTable::MEMBERSHIP_CATEGORY), null, null, null, false, 1)->execute();
    $summary = array();
    foreach($orgs as $org)
    {
      $summary[] = $org->name;
    }
    return implode('; ',$summary);
  }
  
}
