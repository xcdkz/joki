<!DOCTYPE html>
<meta charset="utf-8">
<link rel="stylesheet" href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/client/css/navbar.css"';?>/>
<link rel=image/x-icon"type= href="../assets/favicon.ico">
<ul id="navbar">
    <li class="logo">
        <a href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '"';?>>Jōki</a>
    </li>
    <li>
        <div id="main-menu">
            <a href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/about"';?>>About</a>
            <a href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/contact"';?>>Contact</a>
            <a href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/search"';?>>Search</a>
            <a id="nav-admin-panel-button" style="display: none;" href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/admin/panel"';?>>Administration</a>
        </div>
    </li>
    <li id="register-buttons" class="user-section" style="display: none">
        <a class="nav-button" href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/register"';?>>Register</a>
        <a class="nav-button" href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/login"'?>>Log In</a>
    </li>
    <li id="navbar-username-wrapper" class="user-section" style="display: none">
        <a id="navbar-username" class="nav-button" href=<?php echo '"http://' . $_SERVER['SERVER_NAME'] . '/dashboard"';?>></a>
        <a class="nav-button" href="#" id="navbar-logout">Logout</a>
    </li>
</ul>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/navbar.js"> </script>';
?>
