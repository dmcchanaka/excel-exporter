<?php 
require_once './library/config.php';
$connection = new createConnection();
$connection->connectToDatabase();

require_once './library/SimpleXLSXGen.php';

$firstQuery = "SELECT `id`,`name`,`mobile_no` FROM excel_sheet";
$resultFirstQuery = mysqli_query($connection->myconn, $firstQuery) or die(mysqli_error($connection->myconn));

$headings = array();
$data = array();

$headings = array('id' ,'name', 'status');
array_push($data, $headings);
while($row = $resultFirstQuery->fetch_assoc()){
    $body = array($row['id'], $row['name'], $row['mobile_no']);
    array_push($data, $body);
}

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
$xlsx->saveAs('excel/sample_excel.xlsx');

$filename = 'excel/sample_excel.xlsx';

$response = array();

if (file_exists($filename)) {
    $response['status'] = 1;
    // echo 1;
} else {
    // echo 0;
    $response['status'] = 1;
}
$response['url'] = getBaseUrl(trim($filename));
echo json_encode($response);
exit();


function getBaseUrl($filename) {
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

    // return: http://localhost/myproject/
    return $protocol . $hostName . "/excel-exporter/" . $filename;
}