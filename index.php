<?
  $login = false;
  $role = "guest";

  require_once('auth.class.php');

  if ($auth->isAuth()) {
    $login = $auth->getLogin();
    $role = $auth->getRole();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <? if($role=="admin" || $role=="moderator"){ echo '<meta name="trees-task" content="Test task editable trees" data-role="'.$role.'"/>'; }?>

    <title>Trees Viewer/Editor</title>

    <link rel='stylesheet' type='text/css' href='assets/style/index.css'>

    <style type='text/css'>
    </style>

</head>

<body>

    <nav>
        <div class="logo">Trees Viewer/Editor</div>
<? if($login == false){ ?>
        <ul>
            <li id="authBtn">Log In</li>
        </ul>
<? } else{ ?>
        <div class="user">Hello,
            <?echo$login?>
            <? if($role=="admin"){ echo '[admin]';} ?>
            <? if($role=="moderator"){ echo '[moder]';} ?>
        </div>
        <ul>
            <li id="addBtn">Add item</li>
            <li onclick="location.href='?is_exit=1';">Log Out</li>
        </ul>
<? } ?>
    </nav>

    <div class="content">

        <div class="treeViewWrapper">
            <div class="treeView">

            </div>
            <div class="treeItemContent">
                <div class="title">

                </div>
                <div class="descr">

                </div>
<?
  if(($role=="admin" || $role=="moderator") && $login != false){
?>
                <div class="controlsGroup">
                    <div class='editBtn' onclick="openEditModal(this)">Edit Title</div>
                    <div class='editBtn' onclick="openEditModal(this)">Edit Description</div>
                    <div class='editBtn' onclick="openEditModal(this)">Set Parent</div>
                    <div class='editBtn' onclick="openEditModal(this)">Remove</div>
                </div>
<?
  }
?>
            </div>
        </div>

    </div>

    <footer>
        Made by <a href="//fhnb.ru/">fhnb16</a> in 2023
    </footer>

<?
  if($login == false){
?>
    <div class="modalWindow" id="authModal">
        <form class="modalWrapper" id="authForm" method="POST" action="auth.php">
            <div class="modalHeader">
                <span>Sign In</span>
                <span class="close">&times;</span>
            </div>
            <div class="modalBody">
                <input type="text" name="login" placeholder="Login" />
                <input type="password" name="pass" placeholder="Password" />
                <span class="authError"></span>
            </div>
            <div class="modalFooter"><button type="submit">Auth</button>
                <div class="cancelBtn" onclick="closeModal()">Cancel</div>
            </div>
        </form>
    </div>
<?
  }
?>

    <div class="modalWindow" id="editModal">
        <form class="modalWrapper" id="editForm">
            <div class="modalHeader">
                <span class="elementName">Edit</span>
                <span class="close">&times;</span>
            </div>
            <div class="modalBody">
                <input type="text" name="editableItem" class="editText" placeholder="" />
                <span class="editStatus"></span>
            </div>
            <div class="modalFooter"><button type="submit" class="updateBtn">Submit</button>
                <div class="cancelBtn" onclick="closeModal()">Cancel</div>
            </div>
        </form>
    </div>

    <div class="modalWindow" id="addModal">
        <form class="modalWrapper" id="addForm">
            <div class="modalHeader">
                <span class="elementName">Create new item</span>
                <span class="close closeAdd">&times;</span>
            </div>
            <div class="modalBody">
                <input type="text" title="New item Title" name="title" class="addTitle" placeholder="Title" required="required" />
                <input type="text" title="New item Description" name="description" class="addDescription" placeholder="Description" />
                <div>
                	<label>Parent item: </label>
                	<input type="number" title="Parent item ID" min="0" value="0" class="addParent" placeholder="Parent">
                </div>
                <span class="addStatus"></span>
            </div>
            <div class="modalFooter"><button type="submit" class="addSendBtn">Submit</button>
                <div class="cancelBtn" onclick="closeModal()">Cancel</div>
            </div>
        </form>
    </div>

    <script type='text/javascript' src='assets/js/index.js'></script>

    <script type='text/javascript'>
    </script>
</body>

</html>

<?

if (!file_exists('./config/config.php'))
{
  die('Create ./config/config.php with DB credintals based on ./config/config.sample.php.');
}

?>