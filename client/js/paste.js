const url = window.location.href.split('/')[4];

fetch(`/paste/public/${url}`, {
    method: 'POST',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token')
    })
}).then(response => {
    if(response.status === 200) {
        response.json().then(data => {
            document.getElementById('paste-username').innerHTML = data['creator_username'];
            document.getElementById('paste-title').innerHTML = data['title'];
            document.getElementById('paste-visibility').innerHTML = data['visibility'];
            showdown.setFlavor('github');
            const converter = new showdown.Converter(),
                text = data['content'].replace(/<br \/>/g, '\n'),
                html = converter.makeHtml(text);
            document.getElementById('paste-content').innerHTML = html;
        });
    } else {
        throw new Error();
    }
}).catch(() => {
    window.location.replace(`http://${window.location.hostname}/404`);
});
