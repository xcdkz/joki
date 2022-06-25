const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let previewMode = false;

fetch('/dashboard/edit', {
    method: 'POST',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token'),
        paste_id: urlParams.get('id')
    })
}).then(response => {
    if(response.status === 200) {
        response.json().then(data => {
            document.getElementById('dashboard-edit-title').value = data['title'];
            document.getElementById('dashboard-edit-textarea').innerHTML = data['content'];
        })
    } else {
        window.location.replace(`http://${window.location.host}`);
    }
});

document.getElementById('dashboard-edit-preview').onclick = () => {
    if(previewMode) {
        document.getElementById('dashboard-edit-textarea-preview').style.display = 'none';
        document.getElementById('dashboard-edit-textarea').style.display = '';
        previewMode = false;
    } else {
        document.getElementById('dashboard-edit-textarea-preview').innerHTML = document.getElementById('dashboard-edit-textarea').value;
        document.getElementById('dashboard-edit-textarea').style.display = 'none';
        document.getElementById('dashboard-edit-textarea-preview').style.display = '';
        previewMode = true;
    }
};

document.getElementById('dashboard-edit-cancel').onclick = () => {
    window.location.replace(`http://${window.location.host}/dashboard`);
}

document.getElementById('dashboard-edit-submit').onclick = () => {
    fetch('/dashboard/edit/update', {
        method: 'POST',
        body: JSON.stringify({
            token: window.localStorage.getItem('Token'),
            title: document.getElementById('dashboard-edit-title').value,
            content: document.getElementById('dashboard-edit-textarea').value,
            paste_id: urlParams.get('id')
        })
    }).then(response => {
        if(response.status === 200) {
            response.json().then(data => {
                window.location.replace(data['url']);
            })
        } else {
            window.location.replace(`http://${window.location.host}`);
        }
    })
}

document.getElementById('dashboard-edit-add-owner').onclick = () => {
    fetch('/dashboard/edit/addowner', {
        method: 'POST',
        body: JSON.stringify({
            token: window.localStorage.getItem('Token'),
            paste_id: urlParams.get('id'),
            new_owner: document.getElementById('dashboard-edit-add-owner-xid_id').value
        })
    }).then(response => {
        if(response.status === 200) {
            window.location.replace(`http://${window.location.host}/dashboard`);
        }
        window.location.replace(`http://${window.location.host}`);
    })
}