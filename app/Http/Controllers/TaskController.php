<?php
namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class TaskController extends Controller
{
    public function taskView()
    {
    	$todoTask = Task::where('status',0)
		                    ->orderBy('order')
							->get();
    	$inProgressTask = Task::where('status',1)
		                    ->orderBy('order')
							->get();
    	$completeTask = Task::where('status',2)
		                    ->orderBy('order')
							->get();
		// dd($todoTask,$completeTask);
    	return view('task',compact('todoTask', 'inProgressTask', 'completeTask'));
    }
	public function taskSave(Request $request){
		$task = new Task;
		$task->title = $request->add_task;
		$task->order = 1;
		$task->status = 0;
		// Task::insert([
		// 	'title'=> $request->add_task,
		// 	'order'=> 1,
		// 	'status'=> 0
		// ]);
		$task->save();

		return redirect('/');
	}
    public function updateTasks(Request $request)
    {
    	$input = $request->all();
        
		if(!empty($input['todo']))
    	{
			foreach ($input['todo'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'status'=> 0,
							'order'=>$key
						]);
			}
		}
        
		if(!empty($input['inProgress']))
    	{
			foreach ($input['inProgress'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'status'=> 1,
							'order'=>$key
						]);
			}
		}
		if(!empty($input['accept']))
    	{
			foreach ($input['accept'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'status'=> 2,
							'order'=>$key
						]);
			}
		}
    	return response()->json(['status'=>'success']);
    }
	public function register(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
		   
		]);
  
		if ($validator->fails()) {
			$response['type'] = 'User Registration';
			$response['message'] = 'Error';
			$response['attribute'] = $validator->messages();
			return $this->response($response,400);
		  }else{
			  $user = User::create([
				  'name' => $request->name,
				  'email' => $request->email,
				  'password' => bcrypt($request->password)
			  ]);
			  $token = $user->createToken('task_token')->accessToken;
			  $data['token'] = $token;
			  $response['type'] = 'User Registration';
			  $response['message'] = 'Success';
			  $response['attribute'] = $data;
			  return $this->response($response,200);
		  }
  
    }
	
	public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
  
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('task_token')->accessToken;
			$value['token'] = $token;
			$response['type'] = 'User Login';
			$response['message'] = 'Success';
			$response['attribute'] = $value;
			return $this->response($response,200);

        } else {
            $response['type'] = 'User Login';
			$response['message'] = 'Error';
			$response['attribute'] = "Unauthorized";
			return $this->response($response,401);
        }
    }
	public function taskData() 
    {
 
     $allTask = Task::get();
      
	 $data['type'] = 'All Task';
	 $data['message'] = 'Success';
	 $data['attribute'] = $allTask;
	 return $this->response($data,200);
	}
	public function response($data,$status){
		return response()->json([$data],$status);
	}
}