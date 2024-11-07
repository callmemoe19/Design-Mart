<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/index.css" />
    <title>Design Mart</title>
</head>

<body>
    <header class="header">
        <nav>
            <div class="nav__logo">
                <img src="assets/logo.png" alt=""><a href="#">DesignMart</a>
            </div>
            <ul class="nav__links" id="nav-links">
                <li class="link"><a href="#home">Home</a></li>
                <li class="link"><a href="#choose">Categories</a></li>
                <li class="link"><a href="#craft">Best Sellers</a></li>
                <li class="link"><a href="#about">About</a></li>
            </ul>
            <div class="nav__actions">
                <a href="login.php" class="btn-signin">Sign In</a>
                <a href="register.php" class="btn-signup">Sign Up</a>
            </div>

        </nav>
        <div class="section__container header__container" id="home">
            <h1>Explore High Quality
                Digital Products</h1>
            <p>
                Bingung cari produk desain? Di DM ajaaaaa.
            </p>
            <form action="/">
                <input type="text" placeholder="Search Product ..." />
                <button><i class="ri-search-line"></i></button>
            </form>
        </div>
    </header>
    <div id="snackbar">Harus login terlebih dahulu!</div>

    <section class="section__container craft__container" id="craft">
        <div class="craft__content">
            <h2 class="section__header">Where Creativity Meets Quality Design</h2>
            <p class="section__subheader">
                Elevate Your Space with Quality and Style
            </p>
            <button class="btn">Explore</button>
        </div>
        <div class="craft__image">
            <div class="craft__image__content">
                <img src="\assets\img\akio-font.png" alt="craft" />
                <p>Font Hiroshi</p>
                <h4>Rp65,000</h4>
                <a href="#" class="add-to-cart"><i class="ri-add-line"></i></a>
            </div>
        </div>
        <div class="craft__image">
            <div class="craft__image__content">
                <img src="/assets/img/akio-font.png" alt="craft" />
                <p>Font Hiroshi</p>
                <h4>Rp65,000</h4>
                <a href="#" class="add-to-cart"><i class="ri-add-line"></i></a>
            </div>
    </section>

    <footer class="footer">
        <div class="section__container footer__bar">
            <div class="footer__logo">
                <h4><a href="#">DesignMart</a></h4>
                <p>Copyright © 2024 DesignMart. All rights reserved.</p>
            </div>
            <ul class="footer__nav">
                <li class="footer__link"><a href="#">About</a></li>
                <li class="footer__link"><a href="#">Partnership</a></li>
                <li class="footer__link"><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </footer>

    <script>
        let isLoggedIn = false;

        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        const cartCountDisplay = document.getElementById('cart-count');
        let cartCount = 0;

        addToCartButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                if (!isLoggedIn) {
                    alert('Harus login terlebih dahulu!');
                } else {
                    cartCount++;
                    cartCountDisplay.textContent = cartCount;
                    alert('Item added to cart!');
                }
            });
        });

        const exploreButton = document.querySelector('.btn');
        const snackbar = document.getElementById('snackbar');

        exploreButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (!isLoggedIn) {
                showSnackbar();
            } else {
                alert("Explore section accessed!");
            }
        });

        function showSnackbar() {
            snackbar.classList.add("show");
            setTimeout(() => {
                snackbar.classList.remove("show");
            }, 3000);
        }
    </script>


</body>

</html>