<html>
<?PHP
include "class.movietrailer.php";
include "config.inc.php";
function left($str, $length)
{
                return substr($str, 0, $length);
}
$showid    = $_GET["show"];
$episodeid = $_GET["episode"];
$db_handle = mysql_connect($server, $username, $password);
$db_found  = mysql_select_db($database, $db_handle);
if ($db_found) {
                $SQL     = "select * from tvshow_view where idshow = '" . $showid . "'";
                $SQL2    = "select * from episode_view where idshow = '" . $showid . "' ORDER BY CAST(c12 AS UNSIGNED INTEGER), CAST(c13 AS UNSIGNED INTEGER)";
                $SQL3    = "select * from episode where idfile = '" . $episodeid . "'";
                $SQL4    = "select * from streamdetails where idFile = '" . $episodeid . "' AND iStreamType = '0'";              
            
  $result  = mysql_query($SQL);
                $result2 = mysql_query($SQL2);
                while ($row = mysql_fetch_array($result2)) {
                                $episodelist = $episodelist . "<option value='" . $row['idEpisode'] . "'>S" . $row['c12'] . "E" . $row['c13'] . "-" . $row['c00'] . "</option>";
                }
                
                $episode_count = mysql_num_rows($result2);
                while ($db_field = mysql_fetch_assoc($result)) {
                                $idfile           = $db_field['idFile'];
                                $movietitle       = $db_field['c00'];
                                $movietitle2      = "'" . $db_field['c00'] . "'";
                                $moviedescription = $db_field['c02'] . $db_field['c01'];
                                $moviemoto        = $db_field['c03'];
                                $imdbrating       = "<img src='" . substr($db_field['rating'], 0, 1) . ".png'> - " . substr($db_field['rating'], 0, 3) . "/10";
                                $director         = $db_field['c06'];
                                $year             = substr($db_field['c05'], 0, 4);
                                $year2            = "'" . $year . "'";
                                $rating           = $db_field['c13'];
                                $channel          = $db_field['c14'];
                                $trailer          = $db_field['c19'];
                                $studio           = $db_field['c14'];
                                $filename         = $db_field['strFileName'];
                                $location         = $db_field['strPath'];
                                $imdb             = $db_field['uniqueid_value'];
                                if (file_exists("fanart/" . $imdb . "-1.jpg")) {
                                                $fanart_path = "fanart/" . $imdb . "-1.jpg";
                                                $tv          = "TV Show";
                                } Else {
                                                $fanart_path = "https://thetvdb.com/banners/fanart/original/" . $imdb . "-1.jpg";
                                                file_put_contents("fanart/" . $imdb . "-1.jpg", fopen($fanart_path, 'r'));
                                }
                $result3 = mysql_query($SQL3);
                while ($db_field3 = mysql_fetch_assoc($result3)); {
                                $episodedescription = $db_field3['c01'];
                                $episodetitle       = $db_field3['c00'];
                }
                                $result4 = mysql_query($SQL4);
                                while ($db_field4 = mysql_fetch_assoc($result4)) {
                                                $codec = $db_field4['strVideoCodec'];
                                }
                                
                                $resolution  = explode('[', $filename);
                                $resolution1 = explode(']', $resolution[1]);
                                $finalres    = substr($resolution1[0], 5);
?>
<head>
    <title><?PHP
                                print $movietitle;
?> </title>
<style>
.alpha60 {
/* Fallback for web browsers that doesn't support RGBa */
background: rgb(0, 0, 0);
/* RGBa with 0.6 opacity */
background: rgba(0, 0, 0, 0.6);
}
table
{
border:2px solid;
border-radius:25px;
-moz-border-radius:25px; /* Old Firefox */
}
a:link{color:white}
a:visited{color:white}
a:link{text-decoration:none}
{ margin: 0; padding: 0; }
html {
background: url('<?PHP
                                print $fanart_path;
?>') no-repeat center center fixed;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
} 
</style>
 
<script type="text/javascript" src="js/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
    <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.2.6.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("a.zoom").fancybox();
            $("a.zoom1").fancybox({
                'overlayOpacity'    :    0.7,
                'overlayColor'        :    '#000'
            });
            $("a.zoom2").fancybox({
                'zoomSpeedIn'        :    500,
                'zoomSpeedOut'        :    500
            });
        });
    </script>
    </head>
<?PHP
                                print "<br><br><font face='arial' color='white'><center><table class='alpha60' border='0' width='750px' cellspacing='3' cellpadding='2' bgcolor='black'><tr><td colspan='2'><font face='arial' color='#0066FF' size='6'><b><A href='http://thetvdb.com/?tab=series&id=" . $imdb . "'>" . $episodetitle . "</a></b></font><font face='arial' color='white'> - " . mysql_errno($db_handle) . "</td></tr><tr><td width='446px'>";
                                new MovieTrailer(@$movietitle2, @$year2);
                                print "</td><td width='300px' valign='top'><font face='arial' color='white'><b>Channel:</b><br>" . $channel . "<br><b>Episodes:</b><br><select name='episodes'>" . $episodelist . "</select><br><b>Rating:</b><br>" . $rating . "<br><b>IMDB Rating:</b><br>" . $imdbrating . "<br><b>Play Show</b><br><a href='http://" . $xbmc2 . "/jsonrpc?request={ \"jsonrpc\": \"2.0\", \"method\": \"Player.Open\", \"params\": { \"item\": { \"file\": \"" . $location . $filename . "\" } }, \"id\": 1 }'>" . $xbmc2label . "</a> | <a href='http://" . $xbmc1 . "/jsonrpc?request={ \"jsonrpc\": \"2.0\", \"method\": \"Player.Open\", \"params\": { \"item\": { \"file\": \"" . $location . $filename . "\" } }, \"id\": 1 }'>" . $xbmc1label . "</a></td></tr><tr><td colspan='2'><font face='arial' color='white'><b>Plot:</b><br>" . $episodedescription . "</td></tr><tr><td><font face='arial' color='white'><b>Tag Line:</b><br>" . $moviemoto . " </td></tr>";
                }
                mysql_close($db_handle);
} else {
                print "Database NOT Found ";
}
?>
