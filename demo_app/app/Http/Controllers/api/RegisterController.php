<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{
    // student registration api
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'reading_class' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'confirmation' => 'required'
        ]);
        
   

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());    
        }
        


        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->store('public/images');
            $path = str_replace('public/', '', $path);
        }

        $input = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'name' => $request->fname.' '.$request->lname,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'group' => !empty($request->group) ? $request->group : '',
            'reading_class' => $request->reading_class,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $path,
            'password' => bcrypt($request->password),
            'confirmation' => $request->confirmation=='true' ? true : false
        ];
        $student = Student::create($input);
        
        if ($student) {
            $success['token'] =  $student->createToken('MyApp')->plainTextToken;
            $success['name'] =  $student->name;
            $success['email'] =  $student->email;
            $success['id'] =  $student->id;
    
            return $this->sendResponse($success, 'Student register successfully.');
        } else {
            return $this->sendError('Student registration Fail!'); 
        }
    }


    // student login api
    public function login(Request $request)

    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $student = Auth::user(); 
            $success['token'] =  $student->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $student->name;
            $success['email'] =  $student->email;
            $success['id'] =  $student->id;
            return $this->sendResponse($success, 'User login successfully.');
        } 

        else{ 
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        } 

    }

    public function studentInfo(Request $request) {
        $students = Student::where('id', '=', $request->id)->first();
        if (!empty($students)) {
            $success = $students; // Return students as JSON
            return $this->sendResponse($success);
        }else{
            return $this->sendError('No data found.');
        }
    }

    public function updateProfile(Request $request) {
        $validator = Validator::make($request->all(),[
            'edit_id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'reading_class' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        
   

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());    
        }
        
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->store('public/images');
            $path = str_replace('public/', '', $path);
        }

        $student = Student::find($request->edit_id);
        $student->fname = $request->fname;
        $student->lname = $request->lname;
        $student->name = $request->fname.' '.$request->lname;
        $student->father_name = $request->father_name;
        $student->mother_name = $request->mother_name;
        $student->dob = $request->dob;
        $student->gender = $request->gender;
        $student->group = !empty($request->group) ? $request->group : '';
        $student->reading_class = $request->reading_class;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;
        if (isset($path)) {
            $student->photo = $path;
        }
        
        if ($student->save()) {
            return $this->sendResponse($success='', 'Profile Update successfully.');
        } else {
            return $this->sendError('Profile Update Fail!'); 
        }
    }

    public function deleteProfile(Request $request){
        $student = Student::find($request->id);
        if ($student->delete()) {
            return $this->sendResponse($success='', 'Profile deleted successfully!');
        }else{
            return $this->sendError('Cannot delete at this moment. Try later!');
        }
    }
}
