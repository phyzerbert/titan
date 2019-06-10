<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Models\Project;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Company;
use App\Models\Notification;
use App\Models\Request as MoneyRequest;
use App\User;
use Auth;

class ProjectController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        config(['site.c_page' => 'projects']);
        $managers = User::where('role_id', 3)->get();
        $companies = Company::all();
        $user = Auth::user();

        if($user->role->slug == 'admin' || $user->role->slug == 'accountant'){
            $mod = new Project();
        }else if($user->role->slug == 'project_manager'){
            $mod =  $user->projects();
        }
        $period = $company_id = '';
        if($request->get('company_id') != ''){
            $company_id = $request->get('company_id');
            $mod = $mod->where('company_id', $company_id);
        }
        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }

        $data = $mod->where('id', '>', 0)->orderBy('created_at', 'desc')->paginate(10);

        return view('project.index', compact('data', 'managers', 'companies', 'company_id', 'period'));
        
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'user_id'=>'required',
            'due_to'=>'required',
        ]);
        $data = $request->all();
        Project::create($data);
        $content = 'Project '.$data['name']." is created.";
        Notification::create([
            'type' => 'create_project',
            'content' => $content,
        ]);
        foreach (User::all() as $item) {
            Mail::to($item->email)->send(new SendMailable($content));
        }
        return back()->with('success', 'Created Successfully');
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'due_to'=>'required',
        ]);
        $project = Project::find($request->get('id'));
        $project->name = $request->get("name");
        $project->description = $request->get("description");
        $project->user_id = $request->get("user_id");
        $project->company_id = $request->get("company_id");
        $project->due_to = $request->get("due_to");
        $project->limit = $request->get("limit");

        $project->update();
        return back()->with("success", "Updated Successfully.");
    }

    public function report(Request $request){
        $project = Project::find($request->get('id'));
        $project->progress = $request->get('progress');
        $project->save();
        return back()->with('success', 'Successfully Set.');
    }

    public function delete($id){
        $item = Project::find($id);
        $item->delete();
        return back()->with("success", "Deleted Successfully!");
    }

    public function detail(Request $request, $id){
        config(['site.c_page' => 'projects']);
        $project = Project::find($id);
        $courses = $project->courses;
        $courses_array = $project->courses()->pluck('id')->toArray();
        $project_user_array = CourseUser::whereIn('course_id', $courses_array)->distinct()->pluck('user_id')->toArray();
        $project_members = User::whereIn('id', $project_user_array)->get();
        $project_members_count = User::whereIn('id', $project_user_array)->count();

        return view('project.detail', compact('project', 'courses', 'project_members', 'project_members_count'));
    }

    public function create_course(Request $request){
        $projects = Auth::user()->projects;
        $members = User::where('role_id', 4)->get();
        return view('project.create_course', compact('projects', 'members'));
    }

    public function get_courses(Request $request){
        $courses = Course::where('project_id', $request->get('project_id'))->get();
        return response()->json($courses);
    }

    public function save_course(Request $request){
        $request->validate([
            'name' => 'required|string',
            'project_id' => 'required',
            'due_to' => 'required|date',
            'status' => 'required',
        ]);
        $data = $request->all();
        if($data['status'] == 4){
            $data['progress'] =100;
        }
        // dump($data);die;
        $course = Course::create($data);
        if(isset($data['members']) && count($data['members'])){
            foreach ($data['members'] as $item) {
                CourseUser::create([
                    'course_id' => $course->id,
                    'user_id' => $item,
                ]);
            }
        }
        $project = Project::find($data['project_id']);
        $content = Auth::user()->name.' created new course for '.$project->name.".";
        Notification::create([
            'type' => 'new_course',
            'content' => $content,
            'link' => $course->id,
        ]);

        foreach (User::all() as $item) {
            Mail::to($item->email)->send(new SendMailable($content));
        }

        return redirect(route('project.detail', $request->get('project_id')))->with('success', 'Created successfully');        
    }

    public function detail_course($id){
        $course =  Course::find($id);
        $members = User::where('role_id', 4)->get();
        return view('project.course_detail', compact('course', 'members'));
    }

    public function edit_course(Request $request){
        $request->validate([
            'name' => 'required',
            'due_to' => 'required',
            'progress' => 'required',
        ]);
        $data = $request->all();
        $course = Course::find($data['id']);
        if ($data['progress'] == 100) {
            $content = 'Course '.$course->name.' is completed at '.date('Y-m-d H:i');
            Notification::create([
                'type' => 'completed',
                'content' => $content,
                'link' => $data['id'],
            ]);
            foreach (User::all() as $item) {
                Mail::to($item->email)->send(new SendMailable($content));
            }
            $data['status'] = 4;
        }
        $course->update($data);
        
        return back()->with('success', 'Updated Successfully');
    }

    public function delete_course($id){
        $course =  Course::find($id);
        $course->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function add_member(Request $request){
        $request->validate([
            'course_id' => 'required',
            'members' => 'required',
        ]);
        $members = $request->get('members');
        $course_id = $request->get('course_id');
        foreach ($members as $item) {
            $exist_member = CourseUser::where('course_id', $course_id)->where('user_id', $item)->first();
            if($exist_member) continue;
            CourseUser::create([
                'course_id' => $course_id,
                'user_id' => $item,
            ]);
        }
        return back()->with('success', 'Deleted Successfully');
    }

    public function requests(Request $request){
        config(['site.c_page' => 'requests']);
        $user = Auth::user();
        
        if($user->role->slug == 'admin' || $user->role->slug == 'accountant'){
            $projects = Project::all();
            $data = MoneyRequest::orderBy('created_at', 'desc')->paginate(10);
        }else if($user->role->slug == 'project_manager'){
            $projects = $user->projects;
            $project_array = $user->projects()->pluck('id')->toArray();
            $course_array =Course::whereIn('project_id', $project_array)->pluck('id')->toArray();
            $data = MoneyRequest::whereIn('course_id', $course_array)->orderBy('created_at', 'desc')->paginate(10);
        }else if($user->role->slug == 'course_member'){
            $course_array = $user->courses->pluck('id')->toArray();
            $project_array = $user->courses->pluck('project_id')->toArray();
            $projects = Project::whereIn('id', $project_array)->get();
            $data = MoneyRequest::whereIn('course_id', $course_array)->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('project.request', compact('data', 'projects'));
    }

    public function create_request(Request $request){
        $request->validate([
            'title' => 'required|string',
            'project_id' => 'required',
            'course_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);
        $project =  Project::find($request->get('project_id'));
        $consumed_money = $project->requests->sum('amount');
        $course = Course::find($request->get('course_id'));
        
        $item = new MoneyRequest();
        $item->title = $request->get('title');
        $item->user_id = Auth::user()->id;
        $item->project_id = $request->get('project_id');
        $item->course_id = $request->get('course_id');
        $item->description = $request->get('description');
        $item->amount = $request->get('amount');
        $item->note = $request->get('note');
        // dump($consumed_money + $request->get('amount')); die;
        if(($consumed_money + intval($request->get('amount'))) > intval($project->limit)){
            $item->exceed = 1;
            $content = Auth::user()->name.' requested exceed money for '.$course->name.".";
            Notification::create([
                'type' => 'exceed_limit',
                'content' => $content,
            ]);
            foreach (User::all() as $item) {
                Mail::to($item->email)->send(new SendMailable($content));
            }
        }
        if($request->file('attachment') != null){
            $image = request()->file('attachment');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploaded/request_attachments'), $imageName);
            $item->attachment = 'uploaded/request_attachments/'.$imageName;
        }
        $item->save();
        
        $content = Auth::user()->name.' requested money for '.$course->name.".";
        Notification::create([
            'type' => 'new_request',
            'content' => $content,
        ]);
        foreach (User::all() as $item) {
            Mail::to($item->email)->send(new SendMailable($content));
        }
        return back()->with('success', 'Requested Successfully');
    }

    public function response_to_request(Request $request){
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);
        $item = MoneyRequest::find($request->get('id'));
        $item->status = $request->get('status');
        $item->save();
        return back()->with('success', 'Responsed Successfully');
    }

    public function delete_request($id){
        $item =  MoneyRequest::find($id);
        $item->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
