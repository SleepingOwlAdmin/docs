<?php

/**
  * replace function
  * return
  *
  * Valid: {{TITLE}}, {{TITLE2}}, {{1TITLE}}, {{TIT-LE}}, {{TIT_LE}}
  * Invalid: {{ TITLE }}, {{title}}, {{TIT LE}}, {{TITLE 1}}
  *
  * !!! do NOT use variable names from file _sidebar.json (this file injected to all translations)
*/
function replaceStr($str, $vars) {

  preg_match_all("/\{{[A-Z0-9_-]+\}}+/", $str, $matches);
  foreach($matches as $match_group) {
    foreach($match_group as $match) {
      $match = str_replace("}}", "", $match);
      $match = str_replace("{{", "", $match);
        $match = strtolower($match);
        $allowed = array_keys($vars);
        $match_up = strtoupper($match);
        $str = (in_array($match, $allowed)) ? str_replace("{{".$match_up."}}", $vars[$match], $str) : str_replace("{{".$match_up."}}", '', $str);
      }
    }

    return $str;
  }

?>
