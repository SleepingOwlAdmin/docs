<?php
/**
  * array $filename
  * array $lang
  * str $template_path - path dir
  * str $lng_path - path dir
  * str $output - path dir
  *
*/
require 'config.php';

require 'preg_matcher.php';

$addition_variable = [];

//Check config
if (!isset($langs)
  || empty($langs)
  || !isset($filenames)
  || empty($filenames)
  || !isset($output)
  || !isset($template_path)
  || !isset($lng_path)
) {
  echo ('Error or empty config');
  return false;
}


//Create output folder
if(!is_dir($output)) {
  mkdir($output);
}


foreach ($filenames as $key => $filename) {
  $f = $template_path . '/' . $filename . '.md';
  echo('<br><br>Generate: ' . $filename . '<hr><hr>');

  foreach ($langs as $key => $lang) {
    $l = $lng_path . '/' . $lang . '/' . $filename . '.json';
    echo('<br>Lang: ' . $lang . '<hr>');
    //Check for missing files
    if(!file_exists($f)){echo('ERROR! File ' . $f . ' not found!'); return false;}
    if(!file_exists($l)){echo('ERROR! File ' . $l . ' not found!'); return false;}

    //lang folder
    if(!is_dir($output . '/' . $lang)) {
      mkdir($output . '/' . $lang);
    }

    //new file name
    $new_file_name = $output . '/' . $lang . '/' . $filename . '.md';
    if(file_exists($new_file_name)) {
      echo('File ' . $new_file_name . ' is <span style="color:red;">NOT</span> updated!!! (For updated need deleted this file)');
    } else {
      //variable replace
      //add main variable (_sidebar)
      $variables = json_decode(file_get_contents($l), true);
      if ($lang !== '_sidebar') {
        $add_v = $lng_path . '/' . $lang . '/_sidebar.json';
        $addition_variable = json_decode(file_get_contents($add_v), true);
        $variables = array_merge($variables, $addition_variable);
      }

      $text = file_get_contents($f);
      $new_text = replaceStr($text, $variables);

      //save file
      file_put_contents($new_file_name, $new_text);
      echo('File ' . $new_file_name . ' is <strong style="color:green">GENERED!</strong>');
    }
    echo('<br>');
  }

}

echo '<br><hr><hr><h2 style="color:blue;">All works complite</h2>';

?>
