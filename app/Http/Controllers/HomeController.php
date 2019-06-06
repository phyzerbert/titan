<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\User;
use App\Models\Project;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Request as MoneyRequest;

use Auth;
use Hash;
use DB;

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

        $return['week_money'] = $this->getWeekData('sum(amount)');
        $return['month_money'] = $this->getMonthData('sum(amount)');
        $return['year_money'] = $this->getYearData('sum(amount)');
        $return['today_money'] = $this->getTodayData('sum(amount)');

                
        // ******** Start Chart *********
        $mod = new MoneyRequest();
        $period = $daily_money = '';
        if($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
        }
        if(isset($from) && isset($to)){
            $chart_start = Carbon::createFromFormat('Y-m-d', $from);
            $chart_end = Carbon::createFromFormat('Y-m-d', $to);
        }else{
            $chart_start = Carbon::now()->startOfMonth();
            $chart_end = Carbon::now()->endOfMonth();
        }
        
        $key_array = $money_array = array();
        for ($dt=$chart_start; $dt < $chart_end; $dt->addDay()) {
            $key = $dt->format('Y-m-d');
            $key1 = $dt->format('M/d');
            array_push($key_array, $key1);
            $daily_money = $mod->where('status', 2)->whereDate('created_at', $key)->sum('amount');
            array_push($money_array, $daily_money);
        }
        // ********** End Chart ***********
        $recent_courses = Course::orderBy('created_at', 'desc')->limit(5)->get();
        $recent_notifications = Notification::orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.home', compact('return', 'key_array', 'money_array', 'period', 'recent_courses', 'recent_notifications'));
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

        $return['week_money'] = $this->getWeekData('sum(amount)', "and user_id = $user->id");
        $return['month_money'] = $this->getMonthData('sum(amount)', "and user_id = $user->id");
        $return['year_money'] = $this->getYearData('sum(amount)', "and user_id = $user->id");
        $return['today_money'] = $this->getTodayData('sum(amount)', "and user_id = $user->id");
        
        // ******** Start Chart *********
        $mod = $user->requests();
        $period = $daily_money = '';
        if($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
        }
        if(isset($from) && isset($to)){
            $chart_start = Carbon::createFromFormat('Y-m-d', $from);
            $chart_end = Carbon::createFromFormat('Y-m-d', $to);
        }else{
            $chart_start = Carbon::now()->startOfMonth();
            $chart_end = Carbon::now()->endOfMonth();
        }
        
        $key_array = $money_array = array();
        for ($dt=$chart_start; $dt < $chart_end; $dt->addDay()) {
            $key = $dt->format('Y-m-d');
            $key1 = $dt->format('M/d');
            array_push($key_array, $key1);
            $daily_money = $mod->whereDate('created_at', $key)->sum('amount');
            // dump($daily_money);
            array_push($money_array, $daily_money);
        }
        // ********** End Chart ***********
        $user_projects = $user->projects()->pluck('id')->toArray();
        $recent_courses = Course::whereIn('id', $user_projects)->orderBy('created_at', 'desc')->limit(5)->get();
        $recent_notifications = Notification::orderBy('created_at', 'desc')->limit(5)->get();
        return view('manager.home', compact('return', 'key_array', 'money_array', 'period', 'recent_courses', 'recent_notifications'));
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

    // **************************************************************************88

    public function getTodayData($select, $where = ''){
        $sql = "select ".$select." as sum_count from requests where status = 2 and TO_DAYS(created_at) = TO_DAYS(now()) ".$where;
        $result = DB::select($sql);
        $return = ($result[0]->sum_count)?$result[0]->sum_count:"0";        
        return $return;
    }

    public function getWeekData($select, $where = ''){ 
        $sql = "select ".$select." as sum_count from requests where status = 2 and YEARWEEK(DATE_FORMAT(created_at,'%Y-%m-%d')) = YEARWEEK(now()) ".$where;
        $result = DB::select($sql);
        $return = ($result[0]->sum_count)?$result[0]->sum_count:"0";
        return $return;
    }

    public function getMonthData($select, $where = ''){
        $sql = "select ".$select." as sum_count from requests where status = 2 and DATE_FORMAT(created_at,'%Y%m') = DATE_FORMAT( CURDATE( ) ,'%Y%m' ) ".$where;
        $result = DB::select($sql);
        $return = ($result[0]->sum_count)?$result[0]->sum_count:"0";
        return $return;
    }

    public function getYearData($select, $where = ''){
        $sql = "select ".$select." as sum_count from requests where status = 2 and DATE_FORMAT(created_at,'%Y') = DATE_FORMAT( CURDATE( ) ,'%Y' ) ".$where;
        $result = DB::select($sql);
        $return = ($result[0]->sum_count)?$result[0]->sum_count:"0";
        return $return;
    }

}
