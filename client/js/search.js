let pastesContainer = '';
let fuse;
const options = {
    includeScore: true,
    keys: ['creator', 'title']
};

fetch('/search/pubpastes').then(response => {
    response.json().then(data => {
        pastesContainer = data;
        fuse = new Fuse(pastesContainer, options)
    })
});

document.getElementById('search-bar').oninput = () => {
    let results = '';
    fuse.search(document.getElementById('search-bar').value).forEach(el => {
        results += '<a href="' + el['item']['url'] + '" ';
        results += 'class="search-element"><div class="search-element-title">';
        results += el['item']['title'] + '</div>';
        results += '<div class="search-element-owners">' + el['item']['creator'];
        results += '</div></a>';
    });
    document.getElementById('search-results').innerHTML = results;
}