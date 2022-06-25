<?php
echo '<link rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/client/css/register/register.css" />'
?>
<div id="register-content-wrapper" class="content">
    <h2 id="register-title">Register</h2>
    <div id="register-form">
        <span>Username:</span>
        <span id="register-username-warning" class="register-warning"></span>
        <input id="register-input-username" type="text"/>
        <span>E-Mail:</span>
        <span id="register-email-warning" class="register-warning"></span>
        <input id="register-input-email" type="email"/>
        <span>Password:</span>
        <span id="register-password-warning" class="register-warning"></span>
        <input id="register-input-password" type="password"/>
        <span>Repeat Password:</span>
        <span id="register-repeat-password-warning" class="register-warning"></span>
        <input id="register-input-password2" type="password"/>
        <button id="register-button" type="submit">Register</button>
    </div>
</div>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/helper.js"></script>';
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/register.js"> </script>';
?>
