<html>
<?PHP
include "config.inc.php";
$showid    = $_GET["show"];
$episodeid = $_GET["ep"];
$db_handle = mysql_connect($server, $username, $password);
$db_found  = mysql_select_db($database, $db_handle);
if ($db_found) {
$SQL3    = "select c01,c00 from episode where idepisode = '" . $episodeid . "' AND idshow = '" . $showid . "'";
  $result  = mysql_query($SQL3);

                               while ( $db_field = mysql_fetch_assoc($result));
                               {
                                $episodedescription = $db_field['c01'];
                                $episodetitle       = $db_field['c00'];
                               }
print $SQL3;
print $episodedescription;
print $episodetitle;
}