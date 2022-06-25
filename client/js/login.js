document.getElementById('login-button').onclick = () => {
    if(document.getElementById('login-input-username-mail').value.length >= 4
    && document.getElementById('login-input-password').value.length >= 4
    && document.getElementById('login-input-username-mail').value.length <= 20
    && document.getElementById('login-input-password').value.length <= 20) {
        fetch('/login', {
            method: 'POST',
            body: JSON.stringify({
                user_mail: document.getElementById('login-input-username-mail').value,
                password: document.getElementById('login-input-password').value,
            }),
        }).then(response => {
            response.json().then(data => {
                window.localStorage.setItem('Token', data['token']);
                window.location.href = data['url'];
            })
        });
    }
}

document.getElementById('login-input-username-mail').oninput = () => warnfunc('login-input-username-mail', 'login-username-warning', 'Username/E-Mail');

document.getElementById('login-input-password').oninput = () => warnfunc('login-input-password', 'login-password-warning', 'Password');