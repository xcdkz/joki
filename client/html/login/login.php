<?php
echo '<link rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/client/css/login/login.css" />'
?>
<div id="login-content-wrapper" class="content">
    <h2 id="login-title">Log In</h2>
    <div id="login-form">
        <span>Username/E-mail:</span>
        <span id="login-username-warning" class="login-warning"></span>
        <input id="login-input-username-mail" type="text" maxlength="20" minlength="4" required/>
        <span>Password:</span>
        <span id="login-password-warning" class="login-warning"></span>
        <input id="login-input-password" type="password" maxlength="20" minlength="4" required/>
        <button id="login-button" type="submit">Log In</button>
    </div>
</div>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/helper.js"></script>';
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/login.js"> </script>';
?>
