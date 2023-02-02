<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <title>Tree View</title>

      <link rel='stylesheet' type='text/css' href='https://test.fhnb.ru/Trees/assets/style/index.css'>
      <script type='text/javascript' src=''></script>

      <style type='text/css'>

      </style>

    </head>
    <body>
      
      <nav>
          <div class="logo">Tree View</div>
          <ul>
              <li id="authBtn">Log In</li>
          </ul>
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
        		<div class="controlsGroup">
        		    <div class='editBtn'>Edit Title</div>
        		    <div class='editBtn'>Edit Description</div>
        		    <div class='editBtn'>Remove</div>
        		    <div class='editBtn'>Set parent</div>
        		</div>
    		</div>
          </div>

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

      </div>

      <footer>
      	Made by <a href="//fhnb.ru/">fhnb16</a>
      </footer>
      
      <div class="modalWindow" id="authModal">
          <div class="modalHeader">
            Sign In
            <span class="close">&times;</span>
          </div>
          <div class="modalBody"></div>
          <div class="modalFooter"></div>
      </div>

      <script type='text/javascript'>
      
var modalWindow = document.querySelector('#authModal');
var modalBtn = document.querySelector('#authBtn');
var closeBtn = document.querySelector('.close');

modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', outsideClick);

function openModal() {
  modalWindow.style.display = 'block';
}

function closeModal() {
  modalWindow.style.display = 'none';
}

function outsideClick(e) {
  if (e.target == modalWindow) {
    modalWindow.style.display = 'none';
  }
}
      
      var treeContent = document.querySelector('.treeItemContent');
      var treeJson = null;
      
        async function fetchData() {
            await fetch('https://test.fhnb.ru/Trees/getTree.php?fetch=all&nested=true')
            .then((res) => res.json())
            .then((data) => {
                treeJson = data
                var treeParent = document.querySelector(".treeView")
                treeParent.innerHTML = printTree(data)
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
        
        function printTree(Json, collapsed = false) {
                var json = "<ul class='maketree show'>";
                if(collapsed){
                  json = "<ul class='maketree'>";
                }
                for (prop in Json) {
                    var value = Json[prop];
                    switch (typeof(value.children)) {
                        case "object":
                            json += "<li data-id='"+value.id+"'><span>" + value.title + "</span><div class='expandBtn'>+</div>" + printTree(value.children, true) + "</li>";
                            break;
                        default:
                            json += "<li data-id='"+value.id+"'><span>" + value.title + "</span></li>";
                    }
                }
                return json + "</ul>";
        }
        
        fetchData()
        
      </script>
    </body>
</html>

