fetch('/', {
    method: 'OPTIONS',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token')
    })
}).then(response => {
    if(response.status === 200) {
        response.json().then(data => {
            document.getElementById('dashboard-header').innerHTML = data['username'];
            document.getElementById('dashboard-header-id').innerHTML = data['xid_id'];
        }).catch(() => {
            throw new Error();
        });
    } else {
        throw new Error();
    }
}).catch(() => {
    window.location.replace(`http://${window.location.hostname}`);
})

fetch('/dashboard/pastes', {
    method: 'POST',
    body: JSON.stringify({
        token: window.localStorage.getItem('Token')
    })
}).then(response => {
    response.json().then(data => {
        let str = '';
        data.forEach(el => {
            str += `<div class="dashboard-paste">`;
            str += `<a class="dashboard-paste-headers" href="${el['url']}">`;
            str += `<div class="dashboard-paste-title">${el['title']}</div>`;
            str += `<div class="dashboard-paste-creator">${el['creator']}</div>`;
            str += `<div class="dashboard-paste-owners">Owners: ${el['owners']}</div>`;
            str += `<div class="dashboard-paste-date">${el['date']}</div>`;
            str += `<div class="dashboard-paste-visibility">${el['visibility']}</div></a>`;
            str += `<div class="dashboard-options" id="dashboard-options-${el['_id']}">`;
            str += `<button class="dashboard-option" id="dashboard-options-${el['_id']}-edit">Edit</button>`;
            str += `<button class="dashboard-option" id="dashboard-options-${el['_id']}-remove">Remove</button>`;
            str += `</div></div>`;
        })
        document.getElementById('dashboard-pastes-wrapper').innerHTML = str;
        data.forEach(el => {
            document.getElementById(`dashboard-options-${el['_id']}-edit`).onclick = () => {
                window.location.replace(`http://${location.host}/dashboard/edit?id=${el['_id']}`);
            }
            document.getElementById(`dashboard-options-${el['_id']}-remove`).onclick = () => {
                fetch(`/dashboard/paste/remove/${el['_id']}`, {
                    method: 'POST',
                    body: JSON.stringify({
                        token: window.localStorage.getItem('Token')
                    })
                }).then(response => {
                    if(response.status === 200) {
                        window.location.reload();
                    }
                })
            }
        })
    })
});
