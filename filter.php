<?php 
////////////////////////////////////////////////////////////////////////
//  EasyOChem marvintinymce filter for use with eomarvin2d TinyMCE plugin
// 
//  This filter will replaces <mar></mar>
// with the Javascript needed to display the molecular structure inline
//
//  To activate this filter, go to admin and enable 'marvintinymce' 
// which will also display the button in TinyMCE editor.
//
//
//  Filter written by Carl LeBlond
//
////////////////////////////////////////////////////////////////////////



class filter_marvintinymce extends moodle_text_filter {


function filter($text, array $options = array()){
    global $CFG, $tinymce_applet_has_been_initialised;
    
   

$callbackfunction='';


if(preg_match_all('/<mar>(.*?)<\/mar>/is', $text, $matches)){

$count = 0;




$callbackfunction = '


global $count;
$a=$count++;

if($a=="")$a=0;

$mrvfile=$matches[1];
//echo $mrvfile;
$mrvfile=str_replace( "&lt;", "<", $mrvfile);
$mrvfile=str_replace( "&gt;", ">", $mrvfile);
$mrvfile=addslashes($mrvfile);


$replace="

<script type=\"text/javascript\">




mview_name = \"MSketch$a\";


mview_begin(\"http://'.$_SERVER['HTTP_HOST'].'/marvin\", 600, 200); //arguments: codebase, width, height
mview_param(\"tabScale\", \"30\");
mview_param(\"mol\", \"$mrvfile\");
//mview_param(\"selectable\", \"false\");
mview_end();
</script>
";

return $replace;


';



}





        $search = '/<mar>(.*?)<\/mar>/is';



$newtext = preg_replace_callback($search, create_function('$matches', $callbackfunction), $text);

 
if(($newtext != $text) && !isset($tinymce_applet_has_been_initialised)){
      $$tinymce_applet_has_been_initialised = true;
           
         
$newtext = '
<script LANGUAGE="JavaScript1.1" SRC="http://'.$_SERVER['HTTP_HOST'].'/marvin/marvin.js"></script>
'.$newtext;


  } 
return $newtext;
}
}
?>
