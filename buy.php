<?php
require 'modules/frontend.php';

if(!isset($_GET['want']))
  die("Missing parameter");

$list = explode(' ', htmlentities($_GET['want']));

html_user_header("Buy Game - The Indie Game Shop", true);

// Obvously not our final game database
$games = array("game1", "game2", "game3");

echo '<p>List:</p><ul>';
foreach($list as $item)
  {
    if(!in_array($item, $games))
      html_die("Unknown item $item!");
    echo '<li>',$item,'</li>';
  }
echo '</ul>';

html_footer();
?>