<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseMessage;
use App\Models\Gpa;
use Illuminate\Http\Request;

class GpaController extends Controller
{
    public function index(Request $request)
    {
        $permission = "View Gpa";
        $user = $request->user();
        if ($user->can($permission)) {
            return Gpa::all();
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function store(Request $request)
    {
        $permission = "Create Gpa";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "session_id" => 'required',
                "name" => "required"
            ]);
            if (Gpa::where(["name" => $request->name])->first() == null) {
                $Gpa = new Gpa;
                $Gpa->session_id = $request->session_id;
                $Gpa->name = $request->name;
                if ($Gpa->save()) {
                    return ResponseMessage::success("Gpa Created!");
                } else {
                    return ResponseMessage::fail("Gpa Creation Failed!");
                }
            } else {
                return ResponseMessage::fail("Gpa Exists!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function update($id, Request $request)
    {
        $permission = "Update Gpa";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "session_id" => 'required',
                "name" => "required"
            ]);
            $Gpa = Gpa::find($id);
            $Gpa->session_id = $request->session_id;
            $Gpa->name = $request->name;
            if ($Gpa->save()) {
                return ResponseMessage::success("Gpa Updated!");
            } else {
                return ResponseMessage::fail("Couldn't Update Gpa!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function destroy($id, Request $request)
    {
        $permission = "Delete Gpa";
        $user = $request->user();
        if ($user->can($permission)) {
            if (Gpa::find($id) != null) {
                if (Gpa::destroy($id)) {
                    return ResponseMessage::success("Gpa Deleted!");
                }
            } else {
                return ResponseMessage::fail("Gpa Doesn't Exist!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }
}
