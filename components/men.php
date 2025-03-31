<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style/footer.css" />
    <link rel="stylesheet" href="../style/navbar.css" />
    <link rel="stylesheet" href="../style/men.css" />
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet" />
    <title>Nike, Just Do It. Nike.com</title>
</head>

<body>
    <div id="top_bar">
        <div class="top">
            <?php include 'top.php'; ?>
        </div>
        <div class="bottom">
            <?php include 'bottom.php'; ?>
        </div>
    </div>
    
    
    <div class="sort-container">
        <label for="sort">Sort by:</label>
        <select id="sort">
            <option value="default">Default</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="name_asc">Name: A to Z</option>
            <option value="name_desc">Name: Z to A</option>
        </select>
    </div>

    <div id="shoes-container"></div>
    <div id="pagination"></div>

    <script>
        let currentPage = 1;
        let currentSort = 'default';
        let currentSearch = new URLSearchParams(window.location.search).get('query') || '';
        
        function loadShoes(page = 1, sort = 'default', search = '') {
            fetch(`load_shoes.php?page=${page}&sort=${sort}&gender=Men&query=${encodeURIComponent(search)}`)
                .then(res => res.text())
                .then(data => {
                    const parser = new DOMParser();
                    const html = parser.parseFromString(data, 'text/html');
                    document.getElementById('shoes-container').innerHTML =
                        html.getElementById('shoes-container').innerHTML;
                    document.getElementById('pagination').innerHTML =
                        html.getElementById('pagination').innerHTML;
                });
        }

        window.onload = () => loadShoes(currentPage, currentSort, currentSearch);

        document.getElementById('sort').addEventListener('change', function() {
            currentSort = this.value;
            currentPage = 1;
            loadShoes(currentPage, currentSort, currentSearch);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('page-link')) {
                e.preventDefault();
                let page = parseInt(e.target.getAttribute('data-page')); // Lấy số trang từ `data-page`
                loadShoes(page, currentSort, currentSearch);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

    </script>
    <script src="../scripts/add_to_cart.js"></script>

</body>

</html>