<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <? if($role=="admin" || $role=="moderator"){ echo '<meta name="trees-task" content="Test task editable trees" data-role="'.$role.'"/>'; }?>

    <title>Trees Viewer/Editor</title>

    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link rel='stylesheet' type='text/css' href='assets/css/index.css'>

    <style type='text/css'>
    </style>

</head>

<body>

    <nav>
        <div class="logo">Trees Viewer/Editor</div>
<? if($login == false){ ?>
        <ul>
            <li id="authBtn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg> Log In</li>
        </ul>
<? } else{ ?>
        <div class="user">Hello,
            <?echo$login?>
            <? if($role=="admin"){ echo '[admin]';} ?>
            <? if($role=="moderator"){ echo '[moder]';} ?>
        </div>
        <ul>
            <li id="addBtn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/></svg> Add item</li>
            <li onclick="location.href='?is_exit=1';"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg> Log Out</li>
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
                    <div class='editBtn' onclick="openEditModal(this)">Edit</div>
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
                <div class="editableItems">
                    <div>
                        <label>Title: </label>
                        <input type="text" name="title" title="Title" class="editTitle" placeholder="Title" />
                    </div>
                    <div>
                        <label>Description: </label>
                        <input type="text" name="description" title="Description" class="editDescription" placeholder="Description" />
                    </div>
                    <div>
                        <label>Parent item: </label>
                        <!--<input type="number" title="Parent item ID" min="0" value="0" class="editParent" placeholder="Parent">/-->
                        <select title="Parent item ID" class="editParent"><option value="0">(id 0)    Root Element</option></select>
                    </div>
                </div>
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
                <div class="editableItems">
                    <div>
                        <label>Title: </label>
                        <input type="text" title="New item Title" name="title" class="addTitle" placeholder="Title" required="required" />
                    </div>
                    <div>
                        <label>Description: </label>
                        <input type="text" title="New item Description" name="description" class="addDescription" placeholder="Description" />
                    </div>
                    <div>
                    	<label>Parent item: </label>
                    	<!--<input type="number" title="Parent item ID" min="0" value="0" class="addParent" placeholder="Parent">/-->
                        <select title="Parent item ID" class="addParent"><option value="0">(id 0)    Root Element</option></select>
                    </div>
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