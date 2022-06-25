<?php
echo '<link rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/client/css/search/search.css" />'
?>

<div id="search-wrapper">
    <input type="text" id="search-bar" />
    <div id="search-results">
<!--        <a class="search-element">some title</a>-->
    </div>
</div>

<script src="http://cdn.jsdelivr.net/npm/fuse.js@6.6.2"></script>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/search.js"> </script>';
?>
