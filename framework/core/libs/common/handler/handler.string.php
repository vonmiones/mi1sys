<?php

function zpad($value,$quantity)
{
	return str_pad($value,$quantity, '0', STR_PAD_LEFT); 
}


function initials($str) {
    $ret = '';
    foreach (explode(' ', $str) as $word)
      if ($word != "AND" && $word != "OF" && $word != "&" ) {
        switch ($word) {
          case "ASSESSORS":
              $ret .= trim("ASS");
            break;
          case "ACCOUNTING":
              $ret .= trim("ACC");
            break;
          
          default:
            $ret .= trim($word[0]);
            break;
        }
      }
    return $ret;
}


function generatePassword($numAlpha=8,$numNonAlpha=0)
{
   $listAlpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
   $listNonAlpha = ',;:!?.$/*-+&@_+;./*&?$-!,';
   return str_shuffle(
      substr(str_shuffle($listAlpha),0,$numAlpha) .
      substr(str_shuffle($listNonAlpha),0,$numNonAlpha)
    );
}

function generatePassword2($length = 8)
{
    $nps = "";
    for($i=0;$i<$length;$i++)
    {
        $nps .= chr( (mt_rand(1, 36) <= 26) ? mt_rand(97, 122) : mt_rand(48, 57 ));
    }
    return $nps;
}

function findWord($string, $word) {
    $string = preg_replace('/[^a-zA-Z0-9\']/', ' ', $string);  // remove all non-alphanumeric characters
    $string = strtolower($string); // convert string to lowercase
    $words = explode(' ', $string); // split string into words
    $fuzzyWord = metaphone($word); // use metaphone to find the phonetic similarity of the word
    foreach ($words as $w) {
        if (metaphone($w) === $fuzzyWord) {
            return true;
        }
    }
    return false;
}