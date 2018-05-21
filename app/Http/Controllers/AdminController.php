<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use File;
use DB;
use Image;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Title;
use App\Models\Salary;

class AdminController extends Controller
{
    public function Index(){
    	$employees = [];
    	$count_deps = [];
    	$salary_graph = [];
    	$jobs = Title::select(DB::raw('count(*) as user_count, title'))
    				 ->where('to_date', '9999-01-01')
                     ->groupBy('title')
                     ->orderBy('user_count','DESC')
                     ->get();
    	$departments = Department::orderBy('dept_no', 'ASC')->get();
    	$managers = DB::table('dept_manager')->where('to_date', '9999-01-01')->orderBy('dept_no','ASC')->get();
    	foreach ($managers as $manager) {
    		$salary_graph[] = Salary::where('emp_no', $manager->emp_no)
    								->where('to_date', '9999-01-01')
						    		->first()
						    		->salary;
    	}
    	$salary = Salary::select(DB::raw('max(salary) as max, avg(salary) as avg, min(salary) as min'))->get();
	    foreach ($departments as $item) {
	        $employees[] = DB::table('dept_emp')->where('dept_no',$item->dept_no)->where('to_date', '9999-01-01')->count();
    		$count_deps[] = $item->dept_name;
	    }
    	return view('index',compact(['departments', 'managers','employees','count_deps', 'jobs', 'salary', 'salary_graph']));
    }
    public function Employees(){
    	$employees = Employee::orderBy('emp_no', 'ASC')->paginate(25);
    	return view('employees', compact(['employees']));
    }
    public function History($id){
		$departments = [];
		$salaries = [];
		$money = [];
		$date = [];
		$jobs = [];
    	$employee = Employee::where('emp_no', $id)->first();
    	if (isset($employee)) {
    		$dept_emp = DB::table('dept_emp')->where('emp_no', $employee->emp_no)->get();
    		foreach ($dept_emp as $item) {
    			$departments[] = $this->GetDepartment($item->dept_no,$item->from_date,$item->to_date);
    		}
    		$salary = Salary::where('emp_no', $employee->emp_no)->get();
    		foreach ($salary as $item) {
    			$salaries[] = $this->GetSalary($item->salary,$item->from_date,$item->to_date);
    		}
    		for ($i=0; $i < count($salaries); $i++) { 
    			$money[$i] = $salaries[$i]['salary'];
    			$date[$i] = $salaries[$i]['from_date'].' - '.$salaries[$i]['to_date'];
    		}
    		$positions = Title::where('emp_no', $employee->emp_no)->orderBy('to_date','ASC')->get();
    		foreach ($positions as $item) {
    			$jobs[] = $this->GetPosition($item->title,$item->from_date,$item->to_date);
    		}
    		return view('history', compact(['departments','employee','date','money','jobs']));
    	}else{
    		return '<h2 class="text-center">404 - Not found</h2>';
    	}
    }
    public function Managers(){
    	$db_managers = DB::table('dept_manager')->orderBy('emp_no','ASC')->get();
    	$managers = [];
    	foreach ($db_managers as $item) {
    		$managers[] = $this->GetManager($item->emp_no);
    	}
    	return view('manager', compact(['managers']));
    }
    public function Departments(){
    	$departments = Department::orderBy('dept_no', 'ASC')->get();
    	return view('department', compact(['departments', 'employees']));
    }
    public function Info($id){
    	$managers = [];
    	$employees =[];
    	$dept_manager = DB::table('dept_manager')->where('dept_no', $id)->get();
    	$dept_emp = DB::table('dept_emp')->where('dept_no',$id)->paginate(25);
   		// foreach ($dept_emp as $item) {
   		// 	$employees[] = $this->GetManager($item->emp_no);
   		// }
    	foreach ($dept_manager as $item) {
    		$managers[] = $this->GetManagerR($item->emp_no, $item->from_date, $item->to_date);
    	}
    	return view('info', compact(['managers', 'id']));
    }






    public function GetManager($emp_no){
    	$manager = Employee::where('emp_no', $emp_no)->first();
    	if ($manager!=null) {
    		$item['emp_no'] = $manager->emp_no;
    		$item['birth_date'] = $manager->birth_date;
    		$item['first_name'] = $manager->first_name;
    		$item['last_name'] = $manager->last_name;
    		$item['gender'] = $manager->gender;
    		$item['hire_date'] = $manager->hire_date;
    		$item['position'] = $this->CurrentPosition($emp_no);
    		$item['department'] = $this->CurrentDepartment($emp_no);
    		$item['salary'] = $this->CurrentSalary($emp_no);
    		return $item;
    	}else{

    	}
    }
    public function GetManagerR($emp_no, $from,$to){
    	$manager = Employee::where('emp_no', $emp_no)->first();
    	if ($manager!=null) {
    		$item['emp_no'] = $manager->emp_no;
    		$item['birth_date'] = $manager->birth_date;
    		$item['first_name'] = $manager->first_name;
    		$item['last_name'] = $manager->last_name;
    		$item['gender'] = $manager->gender;
    		$item['hire_date'] = $manager->hire_date;
    		$item['position'] = $this->CurrentPosition($emp_no);
    		$item['department'] = $this->CurrentDepartment($emp_no);
    		$item['salary'] = $this->CurrentSalary($emp_no);
    		$item['from'] = $from;
    		$item['to'] = $to;
    		if ($to == '9999-01-01') {
    			$item['current'] = 'Current Manager';
    		}else{
    			$item['current'] = null;
    		}
    		return $item;
    	}else{

    	}
    }
    public function GetDepartment($dept_no,$from,$to){
    	$department = Department::where('dept_no', $dept_no)->first();
    	if ($department!= null) {
	    	$item['dept_no'] = $department->dept_no;
	    	$item['dept_name'] = $department->dept_name;    	
	    	$item['from_date'] = $from;    	
	    	$item['to_date'] = $to;    	
	    	return $item;
    	}else{
    		return '<h2 class="text-center">404 - Not found</h2>';
    	}
    }
    public function GetSalary($salary,$from,$to){
    	$item['salary'] = $salary;    	
    	$item['from_date'] = $from;    	
    	$item['to_date'] = $to;    	
    	return $item;
    }
    public function GetPosition($title,$from,$to){
    	$item['position'] = $title;    	
    	$item['from_date'] = $from;    	
    	$item['to_date'] = $to;    	
    	return $item;
    }

    public static function CurrentPosition($emp_no){
    	$position = Title::where('emp_no', $emp_no)->where('to_date', '9999-01-01')->first();
    	if ($position!=null) {
    		return $position->title;
    	}else{
    		return 'unemployed';
    	}
    }
    public static function CurrentDepartment($emp_no){
    	$dept = DB::table('dept_emp')->where('emp_no', $emp_no)->where('to_date', '9999-01-01')->first();
    	if ($dept!=null) {
    		$dept_name = Department::where('dept_no', $dept->dept_no)->first()->dept_name;
    		return $dept_name;
    	} else{
    		return 'null';
    	}
    }
    public static function CurrentSalary($emp_no){
    	$salary = Salary::where('emp_no', $emp_no)->where('to_date', '9999-01-01')->first();
    	if ($salary!=null) {
    		return $salary->salary;
    	} else{
    		return 0;
    	}
    }
    public static function CurrentManager($dept_no){
    	$department = DB::table('dept_manager')->where('dept_no', $dept_no)->where('to_date', '9999-01-01')->first();
    	if ($department!=null) {
    		$manager = Employee::where('emp_no', $department->emp_no)->first();
    		return '<b>'.$manager->first_name.' '.$manager->last_name.'</b> ('.$department->from_date.' - '.$department->to_date.')';
    	}else{
    		return 'left';
    	}
    }
    public static function CurrentNumber($dept_no){
        $employees[] = DB::table('dept_emp')->where('dept_no',$item->dept_no)->count();
    }
}
