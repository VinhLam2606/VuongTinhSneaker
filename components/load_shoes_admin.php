<?php
include 'connect-db.php';

$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';
$sort = $_GET['sort'] ?? 'default';
$gender = $_GET['gender'] ?? '';
$page = max(1, intval($_REQUEST["page"] ?? 1));
$record_ppage = 9;
$start = ($page - 1) * $record_ppage;

switch ($sort) {
    case 'price_asc': $orderBy = "ORDER BY st_price ASC"; break;
    case 'price_desc': $orderBy = "ORDER BY st_price DESC"; break;
    case 'name_asc': $orderBy = "ORDER BY st_name ASC"; break;
    case 'name_desc': $orderBy = "ORDER BY st_name DESC"; break;
    default: $orderBy = "";
}

$filters = [];
$params = [];
$param_types = "";

if (!empty($search_query)) {
    $keywords = explode(" ", $search_query);
    $name_conditions = [];
    
    foreach ($keywords as $word) {
        $name_conditions[] = "st_name LIKE ?";
        $params[] = "%$word%";
        $param_types .= "s";
    }

    if (is_numeric($search_query)) {
        $name_conditions[] = "st_price = ?";
        $params[] = (float)$search_query;
        $param_types .= "d";
    }

    $filters[] = "(" . implode(" OR ", $name_conditions) . ")";
}

if (!empty($gender)) {
    $filters[] = "st_gen = ?";
    $params[] = $gender;
    $param_types .= "s";
}

$where_clause = !empty($filters) ? "WHERE " . implode(" AND ", $filters) : "";

$total_query = "SELECT COUNT(*) FROM shoe_type $where_clause";
$total_stmt = $db_server->prepare($total_query);
if (!empty($params)) {
    $total_stmt->bind_param($param_types, ...$params);
}
$total_stmt->execute();
$total_stmt->bind_result($total_records);
$total_stmt->fetch();
$total_stmt->close();

$p_total = ceil($total_records / $record_ppage);

$query = "SELECT * FROM shoe_type st
          $where_clause $orderBy LIMIT ?, ?";
$stmt = $db_server->prepare($query);

$param_types .= "ii";
array_push($params, $start, $record_ppage);

$stmt->bind_param($param_types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div id="shoes-container">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="shoe-card"  data-id="<?= $row['st_id']; ?>">
      <img src="<?= $row['st_image_link']; ?>" alt="<?= $row['st_name']; ?>">
      <h2><?= $row['st_name']; ?></h2>
      <p>Gender: <?= $row['st_gen']; ?></p>
      <p class="price"><?= number_format($row['st_price']); ?>₫</p>

      <button class="show_shoe_inf_btn" >Show Shoe Information</button>
      <button class="delete_shoe_btn" >Delete</button>
    </div>
  <?php endwhile; ?>
</div>

<div id="pagination">
  <?php if ($page > 1): ?>
    <a href="?query=<?= urlencode($search_query) ?>&gender=<?= $gender ?>&sort=<?= $sort ?>&page=1" 
       class="page-link" data-page="1">First</a>

    <a href="?query=<?= urlencode($search_query) ?>&gender=<?= $gender ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>" 
       class="page-link" data-page="<?= $page - 1 ?>">&laquo; Prev</a>
  <?php endif; ?>

  <span>Page <?= $page ?> of <?= $p_total ?></span>

  <?php if ($page < $p_total): ?>
    <a href="?query=<?= urlencode($search_query) ?>&gender=<?= $gender ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>" 
       class="page-link" data-page="<?= $page + 1 ?>">Next &raquo;</a>

    <a href="?query=<?= urlencode($search_query) ?>&gender=<?= $gender ?>&sort=<?= $sort ?>&page=<?= $p_total ?>" 
       class="page-link" data-page="<?= $p_total ?>">Last</a>
  <?php endif; ?>
</div>
