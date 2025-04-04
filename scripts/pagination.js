let currentPage = 1;
let currentSort = 'default';
let currentSearch = new URLSearchParams(window.location.search).get('query') || '';

let gender = document.getElementById('gender-container')?.dataset.gender || '';
let isAdmin = document.getElementById('gender-container')?.dataset.admin || 0; 


console.log("Gender:", gender);
console.log("Is Admin:", isAdmin);

function loadShoes(page = 1, sort = 'default', search = '') {
    let url;
    if (isAdmin) {
        url = `load_shoes_admin.php?page=${page}&sort=${sort}&gender=${encodeURIComponent(gender)}&query=${encodeURIComponent(search)}`;
    } else {
        url = `load_shoes.php?page=${page}&sort=${sort}&gender=${encodeURIComponent(gender)}&query=${encodeURIComponent(search)}`;
    }

    console.log("Fetching:", url);

    fetch(url)
        .then(res => res.text())
        .then(data => {
            const parser = new DOMParser();
            const html = parser.parseFromString(data, 'text/html');

            document.getElementById('shoes-container').innerHTML =
                html.getElementById('shoes-container').innerHTML;
            document.getElementById('pagination').innerHTML =
                html.getElementById('pagination').innerHTML;
        })
        .catch(error => console.error("Fetch error:", error));
}

window.onload = () => loadShoes(currentPage, currentSort, currentSearch);

document.getElementById('sort')?.addEventListener('change', function() {
    currentSort = this.value;
    currentPage = 1;
    loadShoes(currentPage, currentSort, currentSearch);
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('page-link')) {
        e.preventDefault();
        let page = parseInt(e.target.getAttribute('data-page'));
        loadShoes(page, currentSort, currentSearch);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
