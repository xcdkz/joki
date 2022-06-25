let usersContainer = '';
let fuse;
const options = {
    includeScore: true,
    keys: ['username', 'mail']
};

fetch('/admin/users', {
    method: 'POST',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token')
    })
}).then(response => {
    if(response.status === 200) {
        response.json().then(data => {
            usersContainer = data;
            fuse = new Fuse(usersContainer, options)
        })
    } else {
        window.location.replace(`http://${window.location.host}`);
    }
})

document.getElementById('admin-panel-user-search-bar').oninput = () => {
    let results = '';
    let buttonsXids = [];
    fuse.search(document.getElementById('admin-panel-user-search-bar').value).forEach(el => {
        results += '<div class="admin-user-wrapper">';
        results += '<div class="admin-user-element-username">';
        results += el['item']['username'] + '</div>';
        results += '<div class="admin-user-element-email">' + el['item']['email'];
        results += '</div><div class="admin-user-element-xid-id">';
        results += el['item']['xid_id'] + '</div>';
        results += '<div id="admin-user-element-role">' + el['item']['role'];
        results += '</div>';
        results += '<button id="admin-user-button-make-admin-' + el['item']['xid_id'];
        results += '">Make an admin</button>';
        results += '<button id="admin-user-button-remove-user-' + el['item']['xid_id'];
        results += '">Remove</button>';
        results += '<button id="admin-user-button-degrade-user-' + el['item']['xid_id'];
        results += '">Degrade</button>';
        results += '</div>';
        buttonsXids.push(el['item']['xid_id']);
    });
    document.getElementById('admin-panel-user-search-results').innerHTML = results;
    buttonsXids.forEach(el => {
        document.getElementById(`admin-user-button-make-admin-${el}`).onclick = () => {
            fetch('/admin/makeadmin', {
                method: 'POST',
                body: JSON.stringify({
                    token: window.localStorage.getItem('Token'),
                    xid_id: el
                })
            }).then(response => {
                if(response.status === 200) {
                    window.location.replace(`http://${window.location.host}/admin/panel`);
                } else {
                    window.location.replace(`http://${window.location.host}`);
                }
            })
        };
        document.getElementById(`admin-user-button-remove-user-${el}`).onclick = () => {
            fetch('/admin/removeuser', {
                method: 'POST',
                body: JSON.stringify({
                    token: window.localStorage.getItem('Token'),
                    xid_id: el
                })
            }).then(response => {
                if (response.status === 200) {
                    window.location.replace(`http://${window.location.host}/admin/panel`);
                } else {
                    window.location.replace(`http://${window.location.host}`);
                }
            })
        }
        document.getElementById(`admin-user-button-degrade-user-${el}`).onclick = () => {
            fetch('/admin/degradeuser', {
                method: 'POST',
                body: JSON.stringify({
                    token: window.localStorage.getItem('Token'),
                    xid_id: el
                })
            }).then(response => {
                if (response.status === 200) {
                    window.location.replace(`http://${window.location.host}/admin/panel`);
                } else {
                    window.location.replace(`http://${window.location.host}`);
                }
            })
        }
    })
}
