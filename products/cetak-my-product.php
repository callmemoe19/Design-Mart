<?php
include('../koneksi.php');
require_once("../dompdf/autoload.inc.php");

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$query = mysqli_query($koneksi, "SELECT p.id, p.name, p.price, c.name AS category_name 
                                 FROM tb_products p
                                 LEFT JOIN tb_categories c ON p.category_id = c.id"); // Sesuaikan nama tabel kategori jika berbeda
$html = '<center><h3>Data Produk</h3></center><hr/><br>';
$html .= '<table border="1" width="100%">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
            </tr>';
$no = 1;
while ($product = mysqli_fetch_array($query)) {
    $html .= "<tr>
                <td>" . $no . "</td>
                <td>" . $product['name'] . "</td>
                <td>" . $product['category_name'] . "</td> <!-- Ganti dengan kategori yang benar -->
                <td>Rp. " . number_format($product['price']) . "</td>
            </tr>";
    $no++;
}
$html .= "</table>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('laporan-produk.pdf');
