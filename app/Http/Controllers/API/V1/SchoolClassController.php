<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseMessage;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $permission = "View Class";
        $user = $request->user();
        if ($user->can($permission)) {
            return SchoolClass::all();
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function store(Request $request)
    {
        $permission = "Create Class";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "name" => "required"
            ]);
            if (SchoolClass::where("name", $request->name)->first() == null) {
                $school_class = new SchoolClass;
                $school_class->name = $request->name;
                if ($school_class->save()) {
                    return ResponseMessage::success("Class Created!");
                } else {
                    return ResponseMessage::fail("Class Creation Failed!");
                }
            } else {
                return ResponseMessage::fail("Class Exists!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function update($id, Request $request)
    {
        $permission = "Update Class";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "name" => "required"
            ]);
            $school_class = SchoolClass::find($id);
            $school_class->name = $request->name;
            if ($school_class->save()) {
                return ResponseMessage::success("Class Updated!");
            } else {
                return ResponseMessage::fail("Couldn't Update Class!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function destroy($id, Request $request)
    {
        $permission = "Delete Class";
        $user = $request->user();
        if ($user->can($permission)) {
            if (SchoolClass::find($id) != null) {
                if (SchoolClass::destroy($id)) {
                    return ResponseMessage::success("Class Deleted!");
                }
            } else {
                return ResponseMessage::fail("Class Doesn't Exist!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }
}
