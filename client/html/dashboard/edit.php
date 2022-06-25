<?php
echo '<link rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/client/css/dashboard/edit.css"/>';
?>
<div id="dashboard-edit-text-wrapper">
    <div id="dashboard-edit-title-wrapper">
        <span id="dashboard-edit-title-label">Title:</span>
        <input type="text" id="dashboard-edit-title" />
    </div>
    <textarea id="dashboard-edit-textarea"></textarea>
    <div id="dashboard-edit-textarea-preview" style="display: none"></div>
</div>
<div id="dashboard-edit-buttons-wrapper">
    <input type="text" id="dashboard-edit-add-owner-xid_id"/>
    <button id="dashboard-edit-add-owner">Add Owner</button>
    <button id="dashboard-edit-cancel">Cancel</button>
    <button id="dashboard-edit-preview">Preview</button>
    <button id="dashboard-edit-submit">Submit</button>
</div>
<?php
echo '<script src="http://' . $_SERVER['SERVER_NAME'] . '/client/js/dashboardedit.js"> </script>';
?>
