<div id="box-1">
    <button id="select-inProgress" class="select-task">
        <img src="../../assets/images/button-task-in-progress.svg">
    </button>
    <textarea id="title" class="text text-1" placeholder="Title"></textarea>
    <button id="select-completed" class="select-task">
        <img src="../../assets/images/button-task-completed.svg">
    </button>
</div>
<div id="box-2">
    <input id="input" class="text text-2" type="text" placeholder="Content">
    <i id="add-task">
        <img src="../../assets/images/icon-add.svg">
    </i>
</div>
<div id="box-3">
    <div class="task">
        <img class="icon-task" src="../../assets/images/icon-task-in-progress.svg">
        <p class="text text-3">Task in progress</p>
        <button class="select-all"></button>
    </div>
    <div id="task-inProgress">
<!--        <div class="task-inProgress">-->
<!--            <p class="text text-inProgress">Fudo</p>-->
<!--            <button class="icon-delete"><img src="../../assets/images/icon-delete.svg"></button>-->
<!--            <button class="icon-validate"><img src="../../assets/images/icon-validate.svg"></button>-->
<!--        </div>-->
    </div>
</div>
<div id="box-4">
    <div class="task">
        <img class="icon-task" src="../../assets/images/icon-task-completed.svg">
        <p class="text text-4">Task completed</p>
        <button class="select-all"></button>
    </div>
    <div id="task-completed">
<!--        <div class="task-completed">-->
<!--            <p class="text text-completed">Fudo</p>-->
<!--            <button class="icon-delete"><img src="../../assets/images/icon-delete.svg"></button>-->
<!--        </div>-->
    </div>
</div>
<div id="box-5">
    <button id ="edit" class="text text-5">Edit</button>
</div>

<?php
include '../../models/ConfigDao.php';
?>

<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity=
"sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin=
        "anonymous"></script>
<script>
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
    // Select the Elements
    const title = document.getElementById('title');
    const input = document.getElementById("input");
    const taskInProgress = document.getElementById("task-inProgress");
    const taskCompleted = document.getElementById("task-completed");
    const edit = document.getElementById("edit");
    // Variables
    let LIST, id, existing_title;
    let data = false;
    <?php
            if(isset($_POST['title'])){
                $data_base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $help = $_POST['title'];

                $query = "SELECT * FROM list where title = '$help'";
                $myList = $data_base->query($query);
                $data = $myList->fetch();
                $title = $data['json'];
                $title = $data['title'];
                $json = $data['json'];
                $array = json_decode($json, true);
                $title = array_pop($array);
                $data = json_encode($array);
                echo "data = true;";
                echo "existing_title = $help;";
            }else{$data = "flag";}?>



    if(data){
        data = <?php echo $data?>;
        LIST = data[0];
        id = LIST.id ;
        loadList(LIST);
    }else{
        LIST = [];
        id = 0;
    }

    function loadList(array){
        if (array.done === 'false') {
            alert(array.name+ array.id+ array.done+ array.trash);
            addInProgress(array.name, array.id, array.done, array.trash);
        }
        if (array.done !== 'false'){
            title.value = existing_title;
            alert(typeof existing_title );
            alert(array.name+ array.id);
            addInCompleted(array.name, array.id);
        }

        }

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
</script>