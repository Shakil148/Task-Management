<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center pb-3 pt-1">Task Management</h2>
                <form method="Post" action="{{route('task_save')}}" class="form-inline b-2 p-2">
                    @csrf
                    <div class="form-group col-sm-3 mb-2">
                        <input type="text" autocomplete="off" required name="add_task" class="form-control border-dark" id="add_task"
                            placeholder="Write Your Task">
                    </div>
                    <button type="submit" class="btn btn-light border-dark mb-2">Add</button>
                </form>
                <div class="row bg-dark justify-content-center">
                    <div class="col-md-3 p-0 white m-4">
                        <h4 class="text-center red">To Do</h4>
                        <ul class="list-group connectedSortable m-3" id="todo-item-drop">
                            @if(!empty($todoTask) && $todoTask->count())
                            @foreach($todoTask as $key => $value)
                            <li class="list-group-item grey border-dark border-top m-2 text-capitalize text-center" item-id="{{ $value->id }}">{{ $value->title }}</li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-3 p-0 white m-4">
                        <h4 class="text-center red">In Progress</h4>
                        <ul class="list-group connectedSortable m-3" id="inprogress-item-drop">
                            @if(!empty($inProgressTask) && $inProgressTask->count())
                            @foreach($inProgressTask as $key => $value)
                            <li class="list-group-item grey border-dark border-top m-2 text-capitalize text-center" item-id="{{ $value->id }}">{{ $value->title }}</li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-3 p-0 white m-4 complete-item">
                        <h4 class="text-center red">Done</h4>
                        <ul class="list-group connectedSortable m-3" id="complete-item-drop">
                            @if(!empty($completeTask) && $completeTask->count())
                            @foreach($completeTask as $key => $value)
                            <li class="list-group-item grey border-dark border-top m-2 text-capitalize text-center" item-id="{{ $value->id }}">{{ $value->title }}</li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="update_url" value="{{ route('update.tasks') }}">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
</body>

</html>