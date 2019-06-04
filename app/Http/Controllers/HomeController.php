<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\models\Project;
use App\models\Request as MoneyRequest;

use Auth;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $user =  Auth::user();
        $role = $user->role->slug;
        switch ($role) {
            case 'admin':
                return redirect(route('admin.home'));
                break;  
            case 'accountant':
                return redirect(route('accountant.home'));
                break; 
            case 'project_manager':
                return redirect(route('project_manager.home'));
                break;  
            case 'course_member':
                return redirect(route('course_member.home'));
                break;          
            default:
                return redirect(route('project_manager.home'));
                break;
        }
    }

    public function admin_home(Request $request){
        config(['site.c_page' => 'home']);
        $return = array();
        $return['total_users'] = User::all()->count();
        $return['total_managers'] = User::where('role_id', 3)->count();
        $return['total_projects'] = Project::all()->count();
        $return['completed_projects'] = Project::where('progress', 100)->count();
        $return['total_requests'] = MoneyRequest::all()->count();
        $return['approved_requests'] = MoneyRequest::where('status', 2)->count();
        $return['total_money'] = Project::all()->sum('money');
        $return['total_requested_money'] = MoneyRequest::all()->sum('amount');
        $return['total_approved_money'] = MoneyRequest::where('status', 2)->sum('amount');

        return view('admin.home', compact('return'));
    }

    public function accountant_home(Request $request){
        config(['site.c_page' => 'home']);        
        $return['total_requests'] = MoneyRequest::all()->count();
        $return['approved_requests'] = MoneyRequest::where('status', 2)->count();
        $return['total_money'] = Project::all()->sum('money');
        $return['total_requested_money'] = MoneyRequest::all()->sum('amount');
        $return['total_approved_money'] = MoneyRequest::where('status', 2)->sum('amount');

        return view('accountant.home', compact('return'));
    }

    public function manager_home(Request $request){
        config(['site.c_page' => 'home']);
        $user = Auth::user();
        $return['total_projects'] = $user->projects()->count();
        $return['completed_projects'] = $user->projects()->where('progress', 100)->count();
        $return['total_requests'] = $user->requests()->count();
        $return['approved_requests'] = $user->requests()->where('status', 2)->count();
        $return['total_money'] = $user->projects()->sum('limit');
        $return['total_requested_money'] = $user->requests()->sum('amount');
        $return['total_approved_money'] = $user->requests()->where('status', 2)->sum('amount');

        return view('manager.home', compact('return'));
    }

    public function member_home(Request $request){
        config(['site.c_page' => 'home']);
        $user = Auth::user();
        $courses = $user->courses;

        return view('member.home', compact('courses'));
    }

    public function profile(Request $request){
        config(['site.c_page' => 'profile']);
        $user = Auth::user();
        
        return view('profile', compact('user'));
    }

    public function save_profile(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'picture' => 'required|file',
        ]);

        $user = Auth::user();
        $user->name = $request->get("name");
        $user->email = $request->get("email");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        if($request->has("picture")){
            $picture = request()->file('picture');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/profile_pictures'), $imageName);
            $user->picture = 'images/profile_pictures/'.$imageName;
        }
        $user->update();
        return back()->with("success", "Updated User Successfully.");
    }

}
