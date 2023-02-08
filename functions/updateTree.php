<?
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header('Content-Type: application/json');

require_once ('../config/connect.php');

require_once ('./auth.class.php');

require_once('./functions.php');

$data = json_decode(file_get_contents('php://input') , true);

if ((!isset($data) && !isset($data['task'])))
{
    header("Location: index.php");
}

if ((isset($data["value"]["title"]) && isset($data["value"]["title"])))
{
    if ((empty($data["value"]["title"]) || empty($data["value"]["title"])))
    {
        header("Location: index.php");
    }
}

if (!$auth->isAuth())
{
    die('{"status":"error", "message":"You are not logged!"}');
}

function removeRecursive($id) {
    global $dblink;
    $query = "SELECT id FROM `internet-clients_datatrees` WHERE parent=?";
    if ($stmt = $dblink->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_assoc()) {
            removeRecursive($data['id']);
        }
    }
    $delete = 'DELETE FROM `internet-clients_datatrees` WHERE id = ?';
    $stmt = $dblink->prepare($delete);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $dblink->error;
}

$query = "";

switch ($data['task'])
{
    case "add":
        $query .= "INSERT INTO  `internet-clients_datatrees` (`title`, `description`, `parent`) VALUES ('" . $dblink->real_escape_string(htmlspecialchars($data["value"]["title"])) . "', '" . $dblink->real_escape_string(htmlspecialchars($data["value"]["description"])) . "', '" . $dblink->real_escape_string(htmlspecialchars($data["value"]["parent"])) . "');";
    break;
    case "remove":
        removeRecursive($dblink->real_escape_string(htmlspecialchars($data["id"])));
        $err = $dblink->error;
        $dblink->close();
        die('{"status":"success", "message":"Success updated!"}');
    break;
    case "update":
        $query .= "UPDATE `internet-clients_datatrees` SET `title`='" . $dblink->real_escape_string(htmlspecialchars($data["value"]["title"])) . "', `description`='" . $dblink->real_escape_string(htmlspecialchars($data["value"]["description"])) . "', `parent`='" . $dblink->real_escape_string(htmlspecialchars($data["value"]["parent"]))."' WHERE `id`='" . $dblink->real_escape_string(htmlspecialchars($data["id"])) . "';";
    break;
    default:
        die('{"status":"error", "message":"Wrong parameter: "' . $data['task'] . '}');
    break;
}

$result = $dblink->query($query);

$err = $dblink->error;

$dblink->close();

if ($result)
{
    die('{"status":"success", "message":"Success updated!"}');
}
else
{
    die('{"status":"error", "message":"' . $err . '"}');
}

?>
