<?php
include 'connect-db.php';

$sort = $_GET['sort'] ?? 'default';
$page = max(1, intval($_GET['page'] ?? 1));
$record_ppage = 9;
$start = ($page - 1) * $record_ppage;

switch ($sort) {
  case 'price_asc':
    $orderBy = "ORDER BY st_price ASC";
    break;
  case 'price_desc':
    $orderBy = "ORDER BY st_price DESC";
    break;
  case 'name_asc':
    $orderBy = "ORDER BY st_name ASC";
    break;
  case 'name_desc':
    $orderBy = "ORDER BY st_name DESC";
    break;
  default:
    $orderBy = "";
}

$total_stmt = $db_server->prepare("SELECT COUNT(*) FROM shoe_type");
$total_stmt->execute();
$total_stmt->bind_result($total_records);
$total_stmt->fetch();
$total_stmt->close();

$p_total = ceil($total_records / $record_ppage);

$stmt = $db_server->prepare("SELECT st.*, c.c_number 
                                    FROM shoe_type st
                                    LEFT JOIN capacity c ON st.st_id = c.st_id
                                    $orderBy LIMIT ?, ?
");
$stmt->bind_param("ii", $start, $record_ppage);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Bọc sản phẩm -->
<div id="shoes-container">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="shoe-card" data-stock="<?= $row['c_number']; ?>" data-id="<?= $row['st_id']; ?>">
      <img src="<?= $row['st_image_link']; ?>" alt="<?= $row['st_name']; ?>">
      <h2><?= $row['st_name']; ?></h2>
      <p>Gender: <?= $row['st_gen']; ?></p>
      <p class="price"><?= number_format($row['st_price']); ?>₫</p>
      <button class="cart-btn">Add to Cart</button>
      <button class="buy-btn">Buy</button>
    </div>

  <?php endwhile; ?>
</div>

<!-- Phân trang -->
<div id="pagination">
  <?php if ($page > 1): ?>
    <a href="#" class="page-link" data-page="1">First</a>
    <a href="#" class="page-link" data-page="<?= $page - 1 ?>">&laquo; Prev</a>
  <?php endif; ?>

  <span>Page <?= $page ?> of <?= $p_total ?></span>

  <?php if ($page < $p_total): ?>
    <a href="#" class="page-link" data-page="<?= $page + 1 ?>">Next &raquo;</a>
    <a href="#" class="page-link" data-page="<?= $p_total ?>">Last</a>
  <?php endif; ?>
</div>