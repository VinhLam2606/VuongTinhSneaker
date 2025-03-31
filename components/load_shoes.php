<?php
include 'connect-db.php';

$sort = $_GET['sort'] ?? 'default';
$page = max(1, intval($_GET['page'] ?? 1));
$record_ppage = 9;
$start = ($page - 1) * $record_ppage;
$gender = $_GET['gender'] ?? '';  // Get gender parameter

// Apply sorting logic
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

// Apply gender filter
$gender_filter = "";
$params = [];
$param_types = "";

if (!empty($gender)) {
  $gender_filter = "WHERE st_gen = ?";
  $params[] = $gender;
  $param_types .= "s";
}

// Get total records for pagination
$total_query = "SELECT COUNT(*) FROM shoe_type $gender_filter";
$total_stmt = $db_server->prepare($total_query);

if (!empty($gender)) {
  $total_stmt->bind_param($param_types, ...$params);
}

$total_stmt->execute();
$total_stmt->bind_result($total_records);
$total_stmt->fetch();
$total_stmt->close();

$p_total = ceil($total_records / $record_ppage);

// Fetch shoes with filtering
$query = "SELECT st.*, c.c_number 
          FROM shoe_type st
          LEFT JOIN capacity c ON st.st_id = c.st_id
          $gender_filter
          $orderBy LIMIT ?, ?";

$stmt = $db_server->prepare($query);

$params[] = $start;
$params[] = $record_ppage;
$param_types .= "ii";

$stmt->bind_param($param_types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Shoe List -->
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

<!-- Pagination -->
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