<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../CSS/my-transactions.css">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="/assets/img/logo.png" alt="logo">
            <h2>DesignMart</h2>
        </div>
        <ul class="sidebar-links">
            <h4>
                <span>
                    Daily Use
                </span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="/index.php">
                    <span class="material-symbols-outlined">
                        home
                    </span>Home</a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        Overview
                    </span>Overview</a>
            </li>
            <li>
                <a href="" id="myTransactionLink">
                    <span class="material-symbols-outlined">
                        credit_card
                    </span>My Transactions</a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        local_mall
                    </span>My Orders</a>
            </li>
            <li>
                <a href="/products/my-product.php" id="myProductLink">
                    <span class="material-symbols-outlined">
                        inventory_2
                    </span>My Products</a>
            </li>
            <h4>
                <span>
                    Others
                </span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        settings
                    </span>Settings</a>
            </li>
            <li>
                <a href="/login.php">
                    <span class="material-symbols-outlined">
                        logout
                    </span>Log Out</a>
            </li>
        </ul>
        <div class="user-account">
            <div class="user-profile">
                <img src="/assets/img/moe.jpg" alt="">
                <div class="user-details">
                    <h3>Jamil Moe</h3>
                    <span>Web Developer</span>
                </div>
            </div>
        </div>
    </aside>
    <section class="home-section">
        <div class="product-section">
            <div class="section-header">
                <h2>My Transactions</h2>
            </div>
            <div class="products-container">
                <div class="product-card">
                    <img src="/assets/img/akio-font.png" alt="Product Image">
                    <div class="product-details">
                        <div class="product-info">
                            <h3>Font Akio Hiroshi</h3>
                            <span class="product-type">Font</span>
                            <p><b> Rp95,000</b></p>
                        </div>
                        <div class="product-actions">
                            <div class="status">Paid</div>
                            <button class="details-btn">Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popup Box for Details -->
    <div id="detailsPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h2>Transaction Details</h2>
            <p><strong>Product:</strong> <span id="productName"></span></p>
            <p><strong>Type:</strong> <span id="productType"></span></p>
            <p><strong>Price:</strong> <span id="price"></span></p>
            <p><strong>Status:</strong> <span id="status"></span></p>
            <p><strong>Description:</strong> <span id="description"></span></p>
        </div>
    </div>


    <script>
        const detailsPopup = document.getElementById('detailsPopup');
        const detailsBtn = document.querySelector('.details-btn');
        const closeBtn = document.querySelector('.close-btn');

        // Fungsi untuk mengambil dan menampilkan data transaksi
        async function showTransactionDetails() {
            try {
                // Mengambil data dari file JSON
                const response = await fetch('/data/transaction.json');
                if (!response.ok) throw new Error('Data not found');
                const data = await response.json();

                // Menampilkan data ke dalam popup
                document.getElementById('productName').textContent = data.transaction.productName;
                document.getElementById('productType').textContent = data.transaction.productType;
                document.getElementById('price').textContent = data.transaction.price;
                document.getElementById('status').textContent = data.transaction.status;
                document.getElementById('description').textContent = data.transaction.description;

                // Tampilkan popup
                detailsPopup.style.display = 'flex';
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // Event listener pada tombol Details
        detailsBtn.addEventListener('click', showTransactionDetails);

        // Sembunyikan popup ketika tombol X ditekan
        closeBtn.addEventListener('click', () => {
            detailsPopup.style.display = 'none';
        });

        // Sembunyikan popup jika area di luar konten popup diklik
        window.addEventListener('click', (e) => {
            if (e.target === detailsPopup) {
                detailsPopup.style.display = 'none';
            }
        });
    </script>


</body>

</html>