<?PHP

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/connection.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli($db_database, $db_username, $db_password, $selected_database);
    $mysqli->set_charset('utf8mb4');

    $sql = "
    SELECT *
    FROM projects
    WHERE active = ?
    ORDER BY sort_order ASC
  ";

    $result = $mysqli->execute_query($sql, [1]);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($rows ?: [], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Could not load projects.',
        // Uncomment temporarily if needed:
        // 'details' => $e->getMessage(),
    ]);
}
