<?
 include("../conf/config.inc.php");
 include("../lang/language.it.php");
 global $LANGUAGE; 
 @header("location ../admin_index.php");
 echo "$LANGUAGE[408] [<a href=\"../admin_index.php\">$LANGUAGE[409]</a>]";
?>
