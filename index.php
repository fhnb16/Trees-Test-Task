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

      <title>Tree View</title>

      <link rel='stylesheet' type='text/css' href='https://test.fhnb.ru/Trees/assets/style/index.css?5'>
      <script type='text/javascript' src=''></script>

      <style type='text/css'>

      </style>

    </head>
    <body>
      
      <nav>
          <div class="logo">Tree View</div>
          <? if($login == false){ ?>
          <ul>
              <li id="authBtn">Log In</li>
          </ul>
          <? } else{ ?>
          <div class="user">Hello, <?echo$login?> <? if($role=="admin"){ echo '[admin]';} ?><? if($role=="moderator"){ echo '[moder]';} ?></div>
          <ul>
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
        		    <div class='editBtn' onclick="openEditModal(this)">Remove</div>
        		    <div class='editBtn' onclick="openEditModal(this)">Set parent</div>
        		</div>
<?
  }
?>
    		</div>
          </div>

<?
if(($role=="admin" || $role=="moderator") && $login != false){
?>
<div class="changesToApply">
    <div class="applyTop">
        Unsaved changes:
    </div>
    <div class="applyBody">
        
    </div>
    <div class="applyBottom">
        <div class='applyBtn'>Apply changes</div>
    </div>
</div>
<?
}
?>

      </div>

      <footer>
      	Made by <a href="//fhnb.ru/">fhnb16</a> in 2023 ?>
      </footer>

<?
if($login == false){
?>
      <div class="modalWindow" id="authModal">
      	<form class="modalWrapper" id="authForm" method="POST" action="auth.php" >
          <div class="modalHeader">
            <span>Sign In</span>
            <span class="close">&times;</span>
          </div>
          <div class="modalBody">
              <input type="text" name="login" placeholder="Login" />
              <input type="password" name="pass" placeholder="Password" />
              <span class="authError"></span>
          </div>
          <div class="modalFooter"><button type="submit">Auth</button></div>
      	</form>
      </div>
<?
}
?>

      <div class="modalWindow" id="editModal">
      	<form class="modalWrapper" id="editForm" >
          <div class="modalHeader">
            <span class="elementName">Edit</span>
            <span class="close">&times;</span>
          </div>
          <div class="modalBody">
              <input type="text" name="login" placeholder="Login" />
              <input type="password" name="pass" placeholder="Password" />
              <span class="authError"></span>
          </div>
          <div class="modalFooter"><button type="submit">OK</button><div class="cancelBtn" onclick="closeModal()">Cancel</div></div>
      	</form>
      </div>

      <script type='text/javascript'>

var role = "guest";

if(document.querySelector('meta[name="trees-task"]') !== null){
	var role = document.querySelector('meta[name="trees-task"]').getAttribute('data-role')
}
      
var authWindow = document.querySelector('#authModal');
var editWindow = document.querySelector('#editModal');
var authBtn = document.querySelector('#authBtn');
var closeBtn = document.querySelector('.close');

if(authWindow !== null){
	authBtn.addEventListener('click', openAuthModal);
	closeBtn.addEventListener('click', closeModal);
	window.addEventListener('click', outsideClick);
	var form  = document.getElementById('authForm');
	form.addEventListener('submit', authRequestFunc);
}

if(editWindow !== null){
	closeBtn.addEventListener('click', closeModal);
	window.addEventListener('click', outsideClick);
	var form  = document.getElementById('editForm');
	form.addEventListener('submit', editRequestFunc);
}

function openAuthModal() {
  authWindow.classList.add("active");
}

function openEditModal(e) {
  editWindow.querySelector('.elementName').innerText = e.textContent || e.innerText;
  editWindow.classList.add("active");
}

function closeModal() {
	if(authWindow !== null){
      authWindow.classList.remove("active");
	}
	if(editWindow !== null){
      editWindow.classList.remove("active");
	}
}

function outsideClick(e) {
  if (e.target == authWindow || e.target == editWindow) {
	if(authWindow !== null){
      authWindow.classList.remove("active");
	}
	if(editWindow !== null){
      editWindow.classList.remove("active");
	}
  }
}

async function authRequestFunc(event){
    event.preventDefault();
    var params = new URLSearchParams([...new FormData(event.target).entries()]);
    //console.log(form.elements['login'].value+":"+form.elements['pass'].value);
	await fetch('auth.php', {method:"POST", body:params})
	            .then((res) => res.json())
	            .then((data) => {
	                console.log(data)
	            	if(data.result=="200"){
                      window.location.replace("?auth=success");
	            	}else{
	                  document.querySelector(".authError").innerText = data.message;
	                  document.querySelector(".authError").setAttribute("title", "Error code: " + data.status);
	            	}
	            })
}

function editRequestFunc(event){
    event.preventDefault();

}
      
      var treeContent = document.querySelector('.treeItemContent');
      var treeJson = [];
      var tempTree = [];
      var changesJson = [];
      
        async function fetchData() {
            await fetch('getTree.php?fetch=all&nested=true')
            .then((res) => res.json())
            .then((data) => {
                treeJson = data
                tempTree = data
                var treeParent = document.querySelector(".treeView")
                if(role == "admin" || role == "moderator"){
                  treeParent.innerHTML = printTree(tempTree, 3)
                }else{
                  treeParent.innerHTML = printTree(data)
                }
                Array.from(document.querySelectorAll(".expandBtn")).forEach(function(element) {
                      element.addEventListener('click', expandFunction);
                    });
                Array.from(treeParent.querySelectorAll("li>span")).forEach(function(element) {
                      element.addEventListener('click', getTextFunction);
                    });
            })
        }
        
        function expandFunction(event){
            event.target.parentElement.querySelector("ul").classList.toggle("show");
            if(event.target.parentElement.querySelector("ul").classList.contains('show')){
                event.target.innerText = "-";
            } else {
                event.target.innerText = "+";
            }
        }
        
        function getTextFunction(event){
            treeContent.querySelector(".title").innerText = getValue(treeJson, event.target.parentElement.getAttribute('data-id')).title;
            treeContent.querySelector(".descr").innerText = getValue(treeJson, event.target.parentElement.getAttribute('data-id')).description;
            document.querySelector('.controlsGroup').setAttribute("style", "display: flex");
            document.querySelector('.controlsGroup').setAttribute("data-id", event.target.parentElement.getAttribute('data-id'));
        }
        
        function getValue( entireObj , valToFind , keyToFind = "id") {
          let foundObj;
          JSON.stringify(entireObj, (_, nestedValue) => {
            if (nestedValue && nestedValue[keyToFind] === valToFind) {
              foundObj = nestedValue;
            }
            return nestedValue;
          });
          return foundObj;
        };
        
        function printTree(Json, state=0) { // 0 - expanded root collapsed childs, 2 all expanded
                var json = "<ul class='maketree'>";
                var expandBtn = "<div class='expandBtn'>+</div>";
                switch(state){
                	case 0: json = "<ul class='maketree show'>";
                	break;
                	case 1: json = "<ul class='maketree'>";
                	break;
                	default: json = "<ul class='maketree show'>"; expandBtn = "<div class='expandBtn'>-</div>";
                	break;
                }
                if(state==0){
                	state=1;
                }
                for (prop in Json) {
                    var value = Json[prop];
                    if(typeof(value.children) == "object"){
                        json += "<li data-id='"+value.id+"'><span>" + value.title + "</span>" + expandBtn + printTree(value.children, state) + "</li>";
                        
                    }else{
                        json += "<li data-id='"+value.id+"'><span>" + value.title + "</span></li>";
                        
                    }
                }
                return json + "</ul>";
        }
        
        window.onload = fetchData;
        
      </script>
    </body>
</html>

