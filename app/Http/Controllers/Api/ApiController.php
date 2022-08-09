<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
class ApiController extends Controller
{
    //CREATE EMPLOYEE API - POST
    public function createEmployee(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'phone_no' => 'required',
            'gender' => 'required',
            'age' => 'required',
        ]);

        //create instance of Employee model
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->save();

        //send response 
        return response()->json([
            'status' => 200,
            'message' => 'Employee Created Successfully'
        ]);
        
    }

    //EMPLOYEE LIST API - GET
    public function listEmployees()
    {
        $employee = Employee::get();
        return response()->json([
            'status' => 200,
            'message' => 'Listing Employees',
            'employee_data' => $employee 
        ]);
    }

    //SINGLE EMPLOYEE API - GET
    public function getSingleEmployee($id)
    {
        if(Employee::where('id', $id)->exists())
        {
            $employee_details = Employee::where('id', $id)->first();
            return response()->json([
                'status' => 200,
                'single_employee_data' => $employee_details,
            ]);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Employee Not Found',
            ]);
        }
    }

    //UPDATE EMPLOYEE API - PUT
    public function updateEmployee(Request $request, $id)
    {
        if(Employee::where('id', $id)->exists())
        {
            $request->validate([
                'email' => 'email',
            ]);

            $employee = Employee::find($id);
            $employee->name = !empty($request->name)? $request->name:$employee->name;
            $employee->email = !empty($request->email)? $request->email:$employee->email;
            $employee->phone_no =!empty($request->phone_no)? $request->phone_no:$employee->phone_no;
            $employee->gender = !empty($request->gender)? $request->gender:$employee->gender;
            $employee->age = !empty($request->age)? $request->age:$employee->age;
            $employee->save();

            return response()->json([
                'status' => 200,
                'message' => 'Employee Updated Successfully',
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Employee Not Found',
            ]);
        }
            
    }

    //DELETE EMPLOYEE API - DELETE
    public function deleteEmployee($id)
    {
        if(Employee::where('id', $id)->exists())
        {
            $employee = Employee::find($id);
            $employee->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Employee Deleted Successfully',
            ]);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Employee Not Found',
            ]);
        }
    }
}
