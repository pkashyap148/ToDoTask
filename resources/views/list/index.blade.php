@extends('layouts.app')

@section('title')
    ToDo List
@endsection

@section('style')
<style>
    #head{
        color:#52EC7B;
    }
    .form-control{
        border:none;
        background: #F1F1F1;
        color: darkgrey;
        border-radius: 0;
    }
    
    #addbtn{
        border: none;
        background: #52EC7B;
        color: white;
        border-radius: 0;
    }

    #date{
        font-size: 10px;
    }
</style>
    
@endsection

@section('content')
    <div class="container">
        <div class="block text-center">
            <h1 id="head">ToDo List</h1>
            <div class="container">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form id="task_form" onsubmit="submitfunc(event)" action="" name="taskform" method="post" class="row g-3">
                            @csrf
                            <div class="col-auto">
                              <input type="text" name="task_name" class="form-control" id="task" placeholder="Add a To-Do Entry...">
                            </div>
                            <div class="col-auto">
                              <!--<button id="addbtn" name="submit" type="button" onclick="submit()" class="btn btn-primary mb-3">Add +</button>-->
                                <input id="addbtn" type="submit" class="btn btn-primary mb-3"  value="Add +">
                            </div>
                          </form>
                          <br>
                          <div id="list_view">
                          
                          
                          <ol class="list-group" id="myli">
                            @if (count($tasks)>0)
                            @foreach ($tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="ms-2 me-auto">
                                <div id="mytask">{{$task->task_name}}</div>
                                <p id="date">Added {{date('l j F, Y',strtotime($task->created))}}</p>
                              </div>
                              <span>  <input class="form-check-input"  type="checkbox" value="" onclick="done({{$task->task_id}})" id="done"> </span>
                              <span><i class="bi bi-star-fill p-1" task_id="{{$task->task_id}}" priority=0 onclick="prior({{$task->task_id}})" id="prior"></i></span>
                              <span><i class="bi bi-pencil-square p-1" edit_task_id="{{$task->task_id}}" onclick="editTask({{$task->task_id}})" data-bs-toggle="modal" data-bs-target="#editModal" id="edit"></i></span>
                              <span><i class="bi bi-trash-fill p-1" task_id="{{$task->task_id}}" onclick="deleteTask({{$task->task_id}})" id="del" data-bs-toggle="modal" data-bs-target="#deleteModal"></i></span>

                            </li>
                            @endforeach
                            @else
                            <h3 id="empty">List is Empty</h3>  
                          @endif
                          </ol>
                          
                          </div>
                          <p id="error" style="color:red"></p>
                    </div>
                    <div class="col-md-4">
                      <ul id="test">
                          
                      </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
      
      <!-- The Modal Delete-->
      <div class="modal" id="deleteModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-center">Delete Your To-Do Item?</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" id="close" aria-label="Close"></button>
            </div>
              <p class="text-center p-2" id="date">You will be unable to recover your data once it has been deleted.</p>
              <div class="modal-footer">
              <button type="button" class="btn btn-danger" style="background-color:darkgrey; border:none" data-bs-dismiss="modal">Cancel</button>
              
              <button type="button" id="confDelete" onclick="confirm()" class="btn btn-danger">Delete</button></a>

            </div>
      
          </div>
        </div>
      </div>
      <!-- The Modal Edit-->
      <div class="modal" id="editModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-center">Edit Your To-Do Item</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              
            </div>
            <div class="text-center">
              <p class="text-center p-2" id="date">You can edit your to-do item below:</p>
              <form id="edit_task_form"  action="" onsubmit="updateTask()" name="taskform" method="post" class="row g-3">
                @csrf
                <div class="col-auto">
                  <input type="text" name="edit_task" class="form-control" id="edit_task" placeholder="tasks">
                </div>
              </form>
            </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-danger" style="background-color:darkgrey; border:none" data-bs-dismiss="modal">Cancel</button>
              <button type="button" id="confEdit" style="background-color: #52EC7B; border:none" onclick="updateTask()" class="btn btn-danger">Edit</button>

            </div>
      
          </div>
        </div>
      </div>
      

    <script>
        var btn = document.getElementById('addbtn');
        
        var del = document.getElementById('del');
        
        function submitfunc(e){
            e.preventDefault();
            var list_view = document.getElementById('list_view');
            var task_name = document.getElementById('task').value;
            var xhr = new XMLHttpRequest();
            var mytask = 'task_name='+task_name;
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var myli = document.getElementById('myli');
            var empty = document.getElementById('empty');
            if(task_name==""){
              document.getElementById('error').innerText = "Please Enter Task First";
            }
            else{
            //var csrfvalue = document.getElementByTagName("meta")[0].content;
            document.getElementById('error').innerText = "";
            xhr.open('POST','/',true);
            xhr.setRequestHeader('X-CSRF-Token',csrf);
            xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            xhr.send(mytask);
            xhr.onreadystatechange = function() {
              
              //console.log("this ==> ", this)
              if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                myli.innerHTML = "";
                response.forEach(element => {
                  
                  console.log(element);
                  myli.innerHTML += `
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                      <div class="ms-2 me-auto">
                                        <div id="mytask">${element.task_name}</div>
                                        <p id="date">Added ${moment(`${element.created}`).format('dddd D MMMM, YYYY')}</p>
                                      </div>
                                      <span><i class="bi bi-star-fill p-1" task_id="${element.task_id}" onclick="prior()" id="prior"></i></span>
                                      <span><i class="bi bi-pencil-square p-1" edit_task_id="${element.task_id}" onclick="editTask(${element.task_id})" data-bs-toggle="modal" data-bs-target="#editModal" id="edit"></i></span>
                                      <span><i class="bi bi-trash-fill p-1" task_id="${element.task_id}" onclick="deleteTask(${element.task_id})" id="del" data-bs-toggle="modal" data-bs-target="#deleteModal"></i></span>
                                      
                            </li>
                            `;

                });
              }
            };
            }         
        }
        

        function deleteTask(id){
          var task_id = document.getElementById('del').getAttribute('task_id');
          var confDelete = document.getElementById('confDelete');
          confDelete.setAttribute('task_id',id);
        }

        function confirm(){
          var taskid = document.getElementById('confDelete').getAttribute('task_id');
          var delob = new XMLHttpRequest();
          var csrf = document.querySelector('meta[name="csrf-token"]').content;
          var close = document.getElementById('deleteModal');

          delob.open('POST','/{task_id}',true);
          delob.setRequestHeader('X-CSRF-Token',csrf);
          delob.setRequestHeader('Content-type','application/x-www-form-urlencoded');
          delob.send("task_id="+taskid);
          delob.onreadystatechange = function(){
            close.click();
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                if(response.length >0){
                myli.innerHTML = "";
                response.forEach(element => {
                  
                    console.log(element);
                    myli.innerHTML+= `
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="ms-2 me-auto">
                                <div>${element.task_name}</div>
                                <p id="date" id="mytask">Added ${moment(`${element.created}`).format('dddd D MMMM, YYYY')}</p>
                              </div>
                              <span><i class="bi bi-star-fill p-1" task_id="${element.task_id}" onclick="prior()" id="prior"></i></span>
                              <span><i class="bi bi-pencil-square p-1" edit_task_id="${element.task_id}" onclick="editTask(${element.task_id})" data-bs-toggle="modal" data-bs-target="#editModal" id="edit"></i></span>
                              <span><i class="bi bi-trash-fill p-1" task_id="${element.task_id}" onclick="deleteTask(${element.task_id})" id="del" data-bs-toggle="modal" data-bs-target="#deleteModal"></i></span>
                              
                    </li>
                    `;
                    
                }); }
                else{
                  myli.innerHTML = "<h3>List is Empty</h3>";
                }
              }
          }
        }

    function editTask(id) {
    //var task_id = document.getElementById('edit').getAttribute('edit_task_id');
    var confEdit = document.getElementById('confEdit');
    confEdit.setAttribute('confEdit', id);
    console.log(id);
    console.log(confEdit);
    }

  function updateTask() {
    var task_id = document.getElementById('confEdit').getAttribute('confEdit');
    var newTask = document.querySelector('#edit_task').value;
    if(newTask==""){
      alert("Enter Task First");
    }
    else{
    newTask = document.querySelector('#mytask').innerText
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var close = document.getElementById('editModal');
    var editob = new XMLHttpRequest();
    editob.open('POST', `/${task_id}/${newTask}`, true);
    editob.setRequestHeader('X-CSRF-Token', csrf);
    editob.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    editob.send("task_id=" + task_id, "newTask=" + newTask);

    editob.onreadystatechange = function() {
      close.click();
      //console.log('clicked');
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          myli.innerHTML = "";
          response.forEach(element => {

            console.log(element);
            myli.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div id="mytask">${element.task_name}</div>
                            <p id="date">Added ${moment(`${element.created}`).format('dddd D MMMM, YYYY')}</p>
                          </div>
                          <span><i class="bi bi-star-fill p-1" task_id="${element.task_id}" onclick="prior()" id="prior"></i></span>
                          <span><i class="bi bi-pencil-square p-1" edit_task_id="${element.task_id}" onclick="editTask(${element.task_id})" data-bs-toggle="modal" data-bs-target="#editModal" id="edit"></i></span>
                          <span><i class="bi bi-trash-fill p-1" task_id="${element.task_id}" onclick="deleteTask(${element.task_id})" id="del" data-bs-toggle="modal" data-bs-target="#deleteModal"></i></span>
                          
                </li>
                `;

          });
        }
      }
    }
    }
  
        
    function prior(task_id){
    var star = document.querySelector('#prior');
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var pr = new XMLHttpRequest();
    console.log(star);
    if(star.getAttribute('priority')==0){
      star.setAttribute('priority',1) 
      star.style.color="green";
      var p = 1;
      pr.open('POST', `/${task_id}/priority/${p}`, true);
      pr.setRequestHeader('X-CSRF-Token', csrf);
      pr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      pr.send("task_id=" + task_id, "priority=" + p);
      pr.onreadystatechange = function() {
        //console.log('clicked');
          
    
      }
    }else if(star.getAttribute('priority')==1){
      star.setAttribute('priority',0);
      star.style.color="grey";
      var p = 0;
      pr.open('POST', `/${task_id}/priority/${p}`, true);
      pr.setRequestHeader('X-CSRF-Token', csrf);
      pr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      pr.send("task_id=" + task_id, "priority=" + p);
      pr.onreadystatechange = function() {
        //console.log('clicked');
          
    
      }
    }
    console.log(star);
    
  }

  function done(task_id){
    var done = document.querySelector('#done');
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var checkob = new XMLHttpRequest();
    if(done.checked){
    var tick = "complete";
    console.log(done.checked);
    checkob.open('POST', `/${task_id}/status/${tick}`, true);
    checkob.setRequestHeader('X-CSRF-Token', csrf);
    checkob.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    checkob.send("task_id=" + task_id, "status=" + tick);
    checkob.onreadystatechange = function() {
      //console.log('clicked');
        
   
    }}
    else{
    var tick = "incomplete";
    checkob.open('POST', `/${task_id}/status/${tick}`, true);
    checkob.setRequestHeader('X-CSRF-Token', csrf);
    checkob.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    checkob.send("task_id=" + task_id, "status=" + tick);
    //done.removeAttributeNode("checked");
    }
    console.log(done);
  
  }

    </script>
@endsection