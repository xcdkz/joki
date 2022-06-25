document.getElementById('register-button').onclick = () => {
    fetch('/register', {
        method: 'POST',
        body: JSON.stringify({
            username: document.getElementById('register-input-username').value,
            email: document.getElementById('register-input-email').value,
            password: document.getElementById('register-input-password').value,
            password2: document.getElementById('register-input-password2').value
        }),
    }).then(response => {
        response.json().then(data => {
            window.localStorage.setItem('Token', data['token']);
            window.location.href = data['url'];
        })
    });
}

document.getElementById('register-input-username').oninput = () => warnfunc('register-input-username', 'register-username-warning', 'Username');

document.getElementById('register-input-email').oninput = () => warnfunc('register-input-email', 'register-email-warning', 'E-Mail');

document.getElementById('register-input-password').oninput = () => warnfunc('register-input-password', 'register-password-warning', 'Password');

document.getElementById('register-input-password2').oninput = () => {
    if(document.getElementById('register-input-password').value
        !== document.getElementById('register-input-password2').value) {
        document.getElementById('register-repeat-password-warning').innerHTML = 'Passwords don\'t match!';
    } else {
        document.getElementById('register-repeat-password-warning').innerHTML = '';
    }
}