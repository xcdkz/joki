fetch('/', {
    method: 'OPTIONS',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token')
    })
}).then(response => {
    if(response.status === 200) {
        response.json().then(data => {
            document.getElementById('navbar-username-wrapper').style.display = '';
            document.getElementById('navbar-username').innerHTML = data['username'];
            if(data['role'] === 'owner' || data['role'] === 'administrator') {
                document.getElementById('nav-admin-panel-button').style.display = '';
            }
        }).catch(() => {
            document.getElementById('register-buttons').style.display = '';
        })
    } else {
        window.localStorage.removeItem('Token');
        throw new Error('');
    }
}).catch(() => {
    document.getElementById('register-buttons').style.display = '';
});

document.getElementById('navbar-logout').onclick = () => {
    window.localStorage.removeItem('Token');
    window.location.reload();
}