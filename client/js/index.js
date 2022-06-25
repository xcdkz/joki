let is_converted = false;

document.getElementById('index-preview-button').onclick = () => {
    if(!is_converted) {
        const index_paste_box_val = document.getElementById('index-paste-box').value;
        fetch('/converter', {
            method: 'POST',
            body: index_paste_box_val,
        }).then(response => {
            response.text().then(text => {
                document.getElementById('index-paste-box').style.display = 'none';
                document.getElementById('index-preview-box').innerHTML = text;
                document.getElementById('index-preview-box').style.display = 'block';
                fetch('/converter/final', {
                    method: 'POST',
                    body: index_paste_box_val,
                }).then(response2 => {
                    response2.text().then(text2 => {
                        document.getElementById('index-preview-true-box').innerHTML = text2;
                        document.getElementById('index-preview-true-box').style.display = 'block';
                    })
                })
                document.getElementById('index-preview-button').innerHTML = 'Return';
                is_converted = true;
            })
        });
    } else {
        document.getElementById('index-paste-box').style.display = 'block';
        document.getElementById('index-preview-box').style.display = 'none';
        document.getElementById('index-preview-true-box').style.display = 'none';
        document.getElementById('index-preview-button').innerHTML = 'Preview';
        is_converted = false;
    }
};

document.getElementById('index-paste-button').onclick = () => {
    fetch('/converter/final', {
        method: 'POST',
        body: document.getElementById('index-paste-box').value
    }).then(response => {
        response.text().then(text => {
            fetch('/paste', {
                method: 'POST',
                redirect: 'follow',
                body: JSON.stringify({
                    title: document.getElementById('index-title').value,
                    content: text,
                    visibility: document.getElementById('index-select-visibility').value,
                    h_captcha_response: hcaptcha.getResponse(null),
                    token: window.localStorage.getItem('Token'),
                }),
            }).then(response => {
                if(response.status === 406) {
                    document.getElementById('index-warning-box').innerHTML = 'Title or body cannot be empty';
                } else if (response.redirected) {
                    window.location.href = response.url;
                }
            })
        })
    })
}

const fetchPublicPastes = (id) => {
    fetch('/paste/public?number=8')
        .then(response => response.json())
        .then(data => {
            let res = '';
            data.forEach(obj => {
                res += `<a href="http://${window.location.host}/paste/${obj['xid_id']}" class="index-public-list-item"><span class="index-public-title">${obj['title']}</span><span>${obj['date']}</span><span>${obj['creator_username']}</span></span></a>`;
            });
            document.getElementById(id).innerHTML = res;
        }).catch(e => {
            console.log(e);
        });
};

fetchPublicPastes('index-public-pastes-list');

fetch('/', {
    method: 'OPTIONS',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token')
    })
}).then(response => {
        if(response.status === 200) {
            document.getElementById('index-select-priv-option').disabled = false;
        }
});
