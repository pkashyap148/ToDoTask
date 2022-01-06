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
                              <input type="text" name="task_name" class="form-control" id="task" placeholder="Add a To-Do Entry..." required>
                            </div>
                            <div class="col-auto">
                              <!--<button id="addbtn" name="submit" type="button" onclick="submit()" class="btn btn-primary mb-3">Add +</button>-->
                                <input id="addbtn" type="submit" class="btn btn-primary mb-3"  value="Add +">
                            </div>
                          </form>
                          <br>
                          
                          @if (count($tasks)>0)
                          <div id="list_view">
                          <ol class="list-group">
                            @foreach ($tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="ms-2 me-auto">
                                <div>{{$task->task_name}}</div>
                                <p id="date">Added {{date('l j F, Y',strtotime($task->created))}}</p>
                              </div>
                              <span><i class="bi bi-pencil-square p-1" data-bs-toggle="modal" data-bs-target="#editModal" id="edit"></i></span>
                              <span><i class="bi bi-trash-fill p-1" data_task_id="{{$task->task_id}}" id="del" data-bs-toggle="modal" data-bs-target="#deleteModal"></i></span>
                              
                            </li>
                            @endforeach
                          </ol>
                          </div>
                          @else
                            <h3>List is Empty</h3>  
                          @endif
                    </div>
                    <div class="col-md-4">
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
            </div>
              <p class="text-center p-2" id="date">You will be unable to recover your data once it has been deleted.</p>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" style="background-color:darkgrey; border:none" data-bs-dismiss="modal">Cancel</button>
              
              <button type="button" id="confDelete" class="btn btn-danger">Delete</button></a>

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
              <form id="edit_task_form"  action="" name="taskform" method="post" class="row g-3">
                @csrf
                <div class="col-auto">
                  <input type="text" name="edit_task" class="form-control" id="edit_task" placeholder="tasks" required>
                </div>
              </form>
            </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-danger" style="background-color:darkgrey; border:none" data-bs-dismiss="modal">Cancel</button>
              <button type="button" id="confDelete" style="background-color: #52EC7B; border:none" class="btn btn-danger">Edit</button>

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
            //var csrfvalue = document.getElementByTagName("meta")[0].content;
            xhr.open('POST','/',true);
            xhr.setRequestHeader('X-CSRF-Token',csrf);
            xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            xhr.send(mytask);
            xhr.onload =(res)=>{
                console.log(res);
            }
            
        }

        /*$(document).ready(function(){
            $("#task_form").submit(function(e){
                e.preventDefault();

                $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
               $.post('/',{task_name:task_name},function(data){
                  if(data.success==true){
                      console.log(data);
                  }
              })
            })
        })*/

        var confDelete = document.getElementById('confDelete');
        confDelete.addEventListener('click',()=>{
            console.log("Delete");
        })
    </script>
@endsection