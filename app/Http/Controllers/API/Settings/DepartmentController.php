<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseMessage;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Session;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $permission = "View Department";
        $user = $request->user();
        if ($user->can($permission)) {
            return Department::all();
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function store(Request $request)
    {
        $permission = "Create Department";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "session_id" => 'required|numeric',
                "name" => "required|string"
            ]);
            if (Department::where(["session_id" => $request->session_id, "name" => $request->name])->first() == null) {
                $department = new Department;
                if (Session::find($request->session_id)) {
                    $department->session_id = $request->session_id;
                    $department->class_id = $request->class_id;
                    $department->name = $request->name;
                    if ($department->save()) {
                        return ResponseMessage::success("Department Created!");
                    } else {
                        return ResponseMessage::fail("Department Creation Failed!");
                    }
                } else {
                    return ResponseMessage::fail("Session does not exist!");
                }
            } else {
                return ResponseMessage::fail("Department Exists!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function update($id, Request $request)
    {
        $permission = "Update Department";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "session_id" => 'required|numeric',
                "name" => "required|string"
            ]);
            $department = Department::find($id);
            if ($department != null) {
                if (Session::find($request->session_id)) {
                    $department->session_id = $request->session_id;
                    $department->class_id = $request->class_id;
                    $department->name = $request->name;
                    if ($department->save()) {
                        return ResponseMessage::success("Department Updated!");
                    } else {
                        return ResponseMessage::fail("Couldn't Update Department!");
                    }
                } else {
                    return ResponseMessage::fail("Session does not exist!");
                }
            } else {
                return ResponseMessage::fail("Department Doesn't Exist!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function destroy($id, Request $request)
    {
        $permission = "Delete Department";
        $user = $request->user();
        if ($user->can($permission)) {
            if (Department::find($id) != null) {
                if (Department::destroy($id)) {
                    return ResponseMessage::success("Department Deleted!");
                }
            } else {
                return ResponseMessage::fail("Department Doesn't Exist!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }
}
