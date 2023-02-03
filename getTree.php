<?
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require('config/connect.php');

if(isset($_GET['parent']) && !empty($_GET['parent']) && filter_var($_GET['parent'], FILTER_VALIDATE_INT)){
	$query = "SELECT * FROM `internet-clients_datatrees` WHERE `parent`='".$_GET['parent']."' ORDER BY `id`";
} else {
	$query = "SELECT * FROM `internet-clients_datatrees` WHERE `parent`='0' ORDER BY `id`";
}

if (isset($_GET['id']) && !empty($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
	$query = "SELECT * FROM `internet-clients_datatrees` WHERE `id`='".$_GET['id']."' ORDER BY `id`";
}

if(isset($_GET['fetch']) && !empty($_GET['fetch']) && $_GET['fetch'] == 'all'){
	$query = "SELECT * FROM `internet-clients_datatrees` ORDER BY `id`";
}

$result = $dblink->query($query);

header('Content-Type: application/json');

$output = $result->fetch_all(MYSQLI_ASSOC);

function buildTree(array $array): ?array {

	$keyed = array();
	foreach($array as &$value)
	{
	    $keyed[$value['id']] = &$value;
	}
	unset($value);
	$array = $keyed;
	unset($keyed);

	// tree it
	$tree = array();
	foreach($array as &$value)
	{
	    if ($parent = $value['parent'])
	        $array[$parent]['children'][] = &$value;
	    else
	        $tree[] = &$value;
	}
	unset($value);
	$array = $tree;
	unset($tree);

    return $array;
}

if($_GET['nested'] == "true") {

  echo json_encode(buildTree($output), JSON_PRETTY_PRINT);

} else {

  echo json_encode($output, JSON_PRETTY_PRINT);

}

?>