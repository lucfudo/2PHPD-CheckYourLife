const button = {
    slctprogress: document.getElementById('select-inProgress'),
    slctcompleted: document.getElementById('select-completed')
};
const div = {
    content: document.getElementById('box-2'),
    taskprogress: document.getElementById('box-3'),
    taskcompleted: document.getElementById('box-4')
};

<!--show the desired tasks using the buttons-->
button.slctprogress.addEventListener('click', (event) => {
    div.content.classList.toggle('no-show');
    div.taskprogress.classList.toggle('no-show');
    if(div.content.className === 'no-show'){
        button.slctprogress.style.background=("#FAFAFA");
    }else{
        button.slctprogress.style.background=("#38F68A");
    }
});

button.slctcompleted.addEventListener('click', (event) => {
    div.taskcompleted.classList.toggle('no-show');
    if(div.taskcompleted.className === 'no-show'){
        button.slctcompleted.style.background=("#FAFAFA");
    }else{
        button.slctcompleted.style.background=("#38F68A");
    }
});


<!--tasks-->
// Variables
let LIST, id;

data = false;
if(data){
    LIST = JSON.parse(data);
    id = LIST.length;
    loadList(LIST);
}else{
    LIST = [];
    id = 0;
}

function loadList(array){
    array.forEach(function(item){
        if(item.done === 'false'){
            addInProgress(item.name, item.id, item.done, item.trash);
        }else{
            addInCompleted(item.name, item.id);
        }
    })
}

// Select the Elements
const title = document.getElementById('title');
const input = document.getElementById("input");
const taskInProgress = document.getElementById("task-inProgress");
const taskCompleted = document.getElementById("task-completed");
const edit = document.getElementById("edit");

// add task in progress
function addInProgress(task, id, done, trash){

    if(trash === 'true'){return; }

    const item = `
            <div class="task-inProgress">
                <p class="text text-inProgress">${task}</p>
                <button class="icon-delete"><img id="${id}" name="delete" src="../../assets/images/icon-delete.svg"></button>
                <button class="icon-validate"><img  id="${id}" name="validate" src="../../assets/images/icon-validate.svg"></button>
            </div>
            `;
    const position = "beforeend";

    taskInProgress.insertAdjacentHTML(position, item);
}
// add task in completed
function addInCompleted(task, id){
    const item = `
            <div class="task-completed">
                <p class="text text-completed">${task}</p>
                <button class="icon-delete"><img id="${id}" src="../../assets/images/icon-delete.svg"></button>
            </div>
            `;
    const position = "beforeend";

    taskCompleted.insertAdjacentHTML(position, item);
}

// add a task to the list user the enter
document.addEventListener("keyup", function () {
    if(event.keyCode === 13){
        const task = input.value;

        if(task){
            addInProgress(task, id, false, false);

            LIST.push({
                name: task,
                id: id,
                done: 'false',
                trash: 'false'
            });
            id++;
        }
        input.value = "";
    }
});

// complete task
function completeTask(element){
    var parent = $(element).parent().parent();
    parent.fadeOut(function(){
        addInCompleted(LIST[element.id].name, LIST[element.id]);
        parent.fadeIn();
    });
    removeTask(element);

    LIST[element.id].done = "true";
    LIST[element.id].trash = 'false';
}
// remove task
function removeTask(element){
    const parent = $(element).parent().parent();
    parent.fadeOut(function(){
        parent.remove();
    });
    if(LIST[element.id]){
        LIST[element.id].trash = 'true';
    }
}

// target the items "Task in progress"
taskInProgress.addEventListener("click", function(event){
    const element = event.target;

    if(element.name === 'validate'){
        completeTask(element);
    }else if(element.name === "delete"){
        removeTask(element);
    }
});

// target the items "Task complete"
taskCompleted.addEventListener("click", function(event){
    const element = event.target;
    removeTask(element);
});

// target the items "edit"
edit.addEventListener("click",
    function(){
        if(title.value === ""){
            alert('title not be empty');
        }
        else{
            LIST.push({title: title.value});
            const jsonString = JSON.stringify(LIST);
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "save-tasks.php");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(jsonString);
        }
});