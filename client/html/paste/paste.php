<?php
echo '<link rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/client/css/paste/paste.css" />'
?>

<h2 id="paste-title"></h2>
<h3 id="paste-username"></h3>
<h4 id="paste-visibility"></h4>
<textbox id="paste-content">

</textbox>

<script src="http://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"> </script>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/paste.js"> </script>';
?>
