<?php
echo '<link rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/client/css/index/content.css" />'
?>
<div id="index-content-wrapper" class="content">
    <div id="index-text-side">
        <h2 id="index-new-paste">New paste: </h2>
        <div id="index-title-box">
            <span id="index-title-label">Title: </span>
            <input type="text" id="index-title" name="index-title"/>
        </div>
        <span id="index-warning-box"></span>
        <div id="index-text-box">
            <div id="index-textarea-wrapper">
                <textarea id="index-preview-box" style="display: none;" disabled></textarea>
                <div id="index-preview-true-box" style="display: none;" disabled></div>
                <textarea name="index-paste-box" id="index-paste-box" tabindex="2"></textarea>
            </div>
            <div id="index-content-buttons">
                <button id="index-paste-button" type="submit" class="reg-button">Paste</button>
                <button id="index-preview-button" class="reg-button">Preview</button>
                <select id="index-select-visibility">
                    <option value="pub">Public</option>
                    <option value="unl">Unlisted</option>
                    <option value="pri" id="index-select-priv-option" disabled>Private</option>
                </select>
                <div class="h-captcha" data-sitekey="2c5ca5e5-0b9d-4ee1-afff-ba72b8f306ff" size="compact"></div>
            </div>
        </div>
    </div>
    <div id="index-public-side">
        <h2 id="index-public-header">Public pastes: </h2>
        <div id="index-public-pastes-list"></div>
    </div>
</div>
<script src='http://js.hcaptcha.com/1/api.js' async defer></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"> </script>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/index.js"> </script>';
?>

