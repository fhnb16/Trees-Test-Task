var role = "guest";

if (document.querySelector('meta[name="trees-task"]') !== null) {
    var role = document.querySelector('meta[name="trees-task"]').getAttribute('data-role');
}


var treeParent = document.querySelector(".treeView")
var treeContent = document.querySelector('.treeItemContent');
var treeJson = [];

var authWindow = document.querySelector('#authModal');
var editWindow = document.querySelector('#editModal');
var addWindow = document.querySelector('#addModal');
var authBtn = document.querySelector('#authBtn');
var addBtn = document.querySelector('#addBtn');
var closeBtn = document.querySelector('.close');
var closeBtnAdd = document.querySelector('.closeAdd');

if (authWindow !== null) {
    authBtn.addEventListener('click', openAuthModal);
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', outsideClick);
    var form = document.getElementById('authForm');
    form.addEventListener('submit', authRequestFunc);
}

if (editWindow !== null) {
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', outsideClick);
    var form = document.getElementById('editForm');
    form.addEventListener('submit', editRequestFunc);
}

if (addWindow !== null) {
    if (addBtn !== null) {
        addBtn.addEventListener('click', openAddModal);
    }
    closeBtnAdd.addEventListener('click', closeModal);
    window.addEventListener('click', outsideClick);
    var form = document.getElementById('addForm');
    form.addEventListener('submit', addRequestFunc);
}

function openAuthModal() {
    authWindow.classList.add("active");
}

function openAddModal() {
    addWindow.classList.add("active");
}

function openEditModal(e) {
    editWindow.classList.add("active");

    var msg = editWindow.querySelector('.modalBody .infoMsg');
    if (msg !== null) {
        msg.remove();
    }
    editWindow.querySelector('.elementName').innerHTML = (e.textContent || e.innerText) + " <small>id " + e.parentElement.getAttribute("data-id") + "</small>"
    editWindow.querySelector('.editText').style.display = "block";
    editWindow.querySelector('.editText').type = "text";
    document.getElementById('editForm').setAttribute("data-id", e.parentElement.getAttribute("data-id"));
    document.querySelector(".editStatus").innerText = "";

    switch (e.textContent || e.innerText) {
        case "Edit Title":
            editWindow.querySelector('.editText').name = "title";
            editWindow.querySelector('.editText').value = getValue(treeJson, e.parentElement.getAttribute("data-id")).title;
            editWindow.querySelector('.updateBtn').setAttribute("data-prop", "title");
            break;
        case "Edit Description":
            editWindow.querySelector('.editText').name = "description";
            editWindow.querySelector('.editText').value = getValue(treeJson, e.parentElement.getAttribute("data-id")).description;
            editWindow.querySelector('.updateBtn').setAttribute("data-prop", "description");
            break;
        case "Set Parent":
            editWindow.querySelector('.editText').name = "parent";
            editWindow.querySelector('.editText').type = "number";
            editWindow.querySelector('.editText').value = getValue(treeJson, e.parentElement.getAttribute("data-id")).parent;
            editWindow.querySelector('.editText').min = 0;
            editWindow.querySelector('.editText').title = "Parent item ID";
            editWindow.querySelector('.updateBtn').setAttribute("data-prop", "parent");
            break;
        case "Remove":
            editWindow.querySelector('.editText').style.display = "none";
            var span = document.createElement("span");
            span.setAttribute("class", "infoMsg");
            span.textContent = "Are you sure want to delete item `" + getValue(treeJson, e.parentElement.getAttribute("data-id")).title + "` with id " + e.parentElement.getAttribute("data-id") + "?";
            editWindow.querySelector('.modalBody').prepend(span);
            editWindow.querySelector('.updateBtn').setAttribute("data-prop", "remove");
            break;
    }

}

function closeModal() {
    if (authWindow !== null) {
        authWindow.classList.remove("active");
    }
    if (editWindow !== null) {
        editWindow.classList.remove("active");
    }
    if (addWindow !== null) {
        addWindow.classList.remove("active");
    }
}

function outsideClick(e) {
    if (e.target == authWindow || e.target == editWindow || e.target == addWindow) {
        closeModal();
    }
}

async function authRequestFunc(event) {
    event.preventDefault();
    var params = new URLSearchParams([...new FormData(event.target).entries()]);
    //console.log(form.elements['login'].value+":"+form.elements['pass'].value);
    await fetch('auth.php', {
            method: "POST",
            body: params
        })
        .then((res) => res.json())
        .then((data) => {
            console.log(data)
            if (data.result == "200") {
                window.location.replace("?auth=success");
            } else {
                document.querySelector(".authError").innerText = data.message;
                document.querySelector(".authError").setAttribute("title", "Error code: " + data.status);
            }
        })
}

async function editRequestFunc(event) {
    event.preventDefault();

    switch (event.target.querySelector('.updateBtn').getAttribute("data-prop")) {
        case "title":
            await UpdateRequest(event.target.getAttribute("data-id"), "update", event.target.querySelector('.updateBtn').getAttribute("data-prop"), editWindow.querySelector('.modalBody input[name="' + event.target.querySelector('.updateBtn').getAttribute("data-prop") + '"]'));
            break;
        case "description":
            await UpdateRequest(event.target.getAttribute("data-id"), "update", event.target.querySelector('.updateBtn').getAttribute("data-prop"), editWindow.querySelector('.modalBody input[name="' + event.target.querySelector('.updateBtn').getAttribute("data-prop") + '"]'));
            break;
        case "parent":
            await UpdateRequest(event.target.getAttribute("data-id"), "update", event.target.querySelector('.updateBtn').getAttribute("data-prop"), editWindow.querySelector('.modalBody input[name="' + event.target.querySelector('.updateBtn').getAttribute("data-prop") + '"]'));
            break;
        case "remove":
            await UpdateRequest(event.target.getAttribute("data-id"), "remove", event.target.querySelector('.updateBtn').getAttribute("data-prop"), editWindow.querySelector('.modalBody input[name="' + event.target.querySelector('.updateBtn').getAttribute("data-prop") + '"]'));
            break;
    }

}

async function addRequestFunc(event) {
    event.preventDefault();

    await UpdateRequest(null, "add", null, {
        "title": addForm.querySelector(".addTitle").value,
        "description": addForm.querySelector(".addDescription").value,
        "parent": addForm.querySelector(".addParent").value
    });

}

function UpdateRequest(id, task, property, val) {

    var params = {};

    switch (task) {
        case "update":
            params = {
                id: id,
                task: task,
                property: property,
                value: val.value
            };
            break;
        case "remove":
            params = {
                id: id,
                task: task
            };
            break;
        case "add":
            params = {
                id: id,
                task: task,
                property: property,
                value: {
                    "title": val.title,
                    "description": val.description,
                    "parent": val.parent
                }
            };
            break;
    }

    var options = {
        method: 'POST',
        body: JSON.stringify(params)
    };

    fetch('updateTree.php', options)
        .then(response => response.json())
        .then(response => {
            if (response.status == "success") {
                fetchData()
                closeModal()
                treeContent.querySelector(".title").innerHTML = "";
                treeContent.querySelector(".descr").innerHTML = "";
            } else {
                document.querySelector(".editStatus").innerText = response.message
            }
        });

}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        closeModal();
    }
};

async function fetchData() {
    await fetch('getTree.php?fetch=all&nested=true')
        .then((res) => res.json())
        .then((data) => {
            treeJson = data
            if (role == "admin" || role == "moderator") {
                treeParent.innerHTML = printTree(data, 3)
            } else {
                treeParent.innerHTML = printTree(data)
            }
            Array.from(document.querySelectorAll(".expandBtn")).forEach(function(element) {
                element.addEventListener('click', expandFunction);
            });
            Array.from(treeParent.querySelectorAll("li>span")).forEach(function(element) {
                element.addEventListener('click', getTextFunction);
            });
            if (role == "admin" || role == "moderator") {
                Array.from(treeParent.querySelectorAll(".addBtn")).forEach(function(element) {
                    element.addEventListener('click', openAddModal);
                });
            }
        })
}

function expandFunction(event) {
    event.target.parentElement.querySelector("ul").classList.toggle("show");
    if (event.target.parentElement.querySelector("ul").classList.contains('show')) {
        event.target.innerText = "-";
    } else {
        event.target.innerText = "+";
    }
}

function getTextFunction(event) {
    var idStr = "";
    if (role == "admin" || role == "moderator") {
        idStr = " <small>id " + event.target.parentElement.getAttribute('data-id') + "</small>";
    }
    treeContent.querySelector(".title").innerHTML = (getValue(treeJson, event.target.parentElement.getAttribute('data-id')).title) + idStr;
    treeContent.querySelector(".descr").innerHTML = getValue(treeJson, event.target.parentElement.getAttribute('data-id')).description;
    if (document.querySelector('.controlsGroup') !== null) {
        document.querySelector('.controlsGroup').setAttribute("style", "display: flex");
        document.querySelector('.controlsGroup').setAttribute("data-id", event.target.parentElement.getAttribute('data-id'));
    }
}

function getValue(entireObj, valToFind, keyToFind = "id") {
    let foundObj;
    JSON.stringify(entireObj, (_, nestedValue) => {
        if (nestedValue && nestedValue[keyToFind] === valToFind) {
            foundObj = nestedValue;
        }
        return nestedValue;
    });
    return foundObj;
};

function printTree(Json, state = 0) { // 0 - expanded root collapsed childs, 2 all expanded
    var json = "<ul class='maketree'>";
    var expandBtn = "<div class='expandBtn'>+</div>";
    switch (state) {
        case 0:
            json = "<ul class='maketree show'>";
            break;
        case 1:
            json = "<ul class='maketree'>";
            break;
        default:
            json = "<ul class='maketree show'>";
            expandBtn = "<div class='expandBtn'>-</div>";
            break;
    }
    if (state == 0) {
        state = 1;
    }
    var idStr = "";
    for (prop in Json) {
        var value = Json[prop];
        if (value.title == undefined) {
            continue;
        }

        if (role == "admin" || role == "moderator") {
            idStr = " <small>id " + value.id + "</small>";
        }

        if (typeof(value.children) == "object") {
            json += "<li data-id='" + value.id + "'><span>" + value.title + idStr + "</span>" + expandBtn + printTree(value.children, state) + "</li>";

        } else {
            json += "<li data-id='" + value.id + "'><span>" + value.title + idStr + "</span>" + "</li>";

        }
    }
    return json + "</ul>";
}

window.onload = fetchData;