<?PHP

//CONNECT to the database=======================
include("connection.php");
$connection = mysql_connect($db_database, $db_username, $db_password) or die('I cannot connect to the database because: ' . mysql_error());
mysql_select_db($selected_database);
//=============================================

try {
    //Get the news
    $query = "SELECT * FROM projects WHERE active=1 ORDER BY sort_order ASC, RAND()";
    $result = mysql_query($query);
    //end news get


    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $rows[] = $row;
    }


    if (empty($rows)) {
        echo json_encode([]);
        exit;
    }


    echo json_encode($rows);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Could not load latest news.',
    ]);
}
