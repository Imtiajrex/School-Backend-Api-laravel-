<?php

namespace App\Http\Controllers\API\Payments;

use AccountBalance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseMessage;
use App\Models\Accounts;
use App\Models\PaymentCategory;
use App\Models\Students;
use App\Models\StudentsPayment;
use App\Models\StudentsPaymentAccount;
use App\Models\StudentsPaymentInfo;
use App\Models\StudentsPaymentReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsPaymentController extends Controller
{
    public function index(Request $request)
    {
        $permission = "View Payment";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "student_id" => "required",
            ]);
            $student_id = Students::where("student_id", $request->student_id)->first();
            $student_id = $student_id != null ? $student_id->id : null;
            $students_payment =  StudentsPayment::where("student_id", $student_id);
            if ($request->from && $request->to) {
                $from = $request->from;
                $to = $request->to;
                $students_payment =  $students_payment->whereBetween("date", [$from, $to]);
            }
            return $students_payment->get();
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function store(Request $request)
    {
        $permission = "Add Payment";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "date" => "required|date",
                "student_id" => "required|numeric",
                "session_id" => "required|numeric",
                "payments" => "required"
            ]);
            $date = $request->date;
            $student_id = $request->student_id;
            $payments = $request->payments;
            $session_id = $request->session_id;



            if (Students::find($student_id) == null)
                return ResponseMessage::fail("Student Not Found!");

            $receipt_id = StudentsPaymentReceipt::max('id') + 1;


            $data_array = $this->paymentArrayConverter($payments, $receipt_id, $student_id, $session_id, $date);
            $data_to_add = $data_array[0];
            $account_arr = $data_array[1];


            if (StudentsPayment::insert($data_to_add)) {
                $student_payments = StudentsPayment::where("group_id", $receipt_id);
                $payment_ids_query = $student_payments->get();
                $receipt = [];
                $index = 0;
                $total_income = 0;
                foreach ($payment_ids_query as $payment_id) {
                    $account_arr[$index]['payment_id'] = $payment_id['id'];

                    $total_income += $account_arr[$index]["amount"];
                    array_push($receipt, ["id" => $receipt_id, 'student_id' => $student_id, 'payment_id' => $payment_id['id'], "date" => $date]);
                    ++$index;
                }
                Accounts::insert($account_arr);
                $account_balance = DB::table("account_balance")->where("id", 1)->first();
                $total_income += $account_balance->cash;
                DB::table("account_balance")->where("id", 1)->update(["cash"=>$total_income]);
                if (StudentsPaymentReceipt::insert($receipt)) {

                    if (!$this->insertDueAdvance($payment_ids_query))
                        return ResponseMessage::fail("Failed To Enter Due Balance");

                    return response()->json(["message" => "Inserted A Payment Record!", "receipt_id" => $receipt_id]);
                } else {
                    return ResponseMessage::success("Failed To Create Receipt!");
                }
            } else {
                return ResponseMessage::fail("Payment Record Insertion Failed!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }
    public function update($id, Request $request)
    {

        $permission = "Add Payment";
        $user = $request->user();
        if ($user->can($permission)) {
            $request->validate([
                "date" => "required|date",
                "payment_amount" => "required|numeric",
                "paid_amount" => "required|numeric"
            ]);
            $date = $request->date;
            if ($request->payment_info)
                $payment_info = $request->payment_info;
            $payment_amount = $request->payment_amount;
            $paid_amount = $request->paid_amount;
            $payment = StudentsPayment::find($id);
            if ($payment != null) {
                $student_id = $payment->student_id;
                if ($request->payment_info)
                    $payment->payment_info = $payment_info;
                $payment->payment_amount = $payment_amount;
                $payment->paid_amount = $paid_amount;
                if ($payment->save()) {
                    $due = StudentsPaymentAccount::where("payment_id", $id)->first();
                    Accounts::where("entry_category", "like", "%Student Payment%")->where("payment_id", $id)->update(["entry_category" => "Student Payment[Edited]"]);
                    if ($due != null) {
                        if ($payment_amount > $paid_amount)
                            $due->amount = $payment_amount - $paid_amount;
                        else
                            $due->delete();
                    } else {
                        if ($payment_amount > $paid_amount)
                            StudentsPaymentAccount::insert(["student_id" => $student_id, "payment_id" => $id, "amount" => $payment_amount - $paid_amount, "status" => "DUE"]);
                    }
                    return ResponseMessage::success("Payment Record Updated!");
                } else {
                    return  ResponseMessage::fail("Failed  To Update Payment Record!");
                }
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function destroy($id, Request $request)
    {
        $permission = "Delete Payment Record";
        $user = $request->user();
        if ($user->can($permission)) {
            if (StudentsPayment::find($id) != null) {
                if (StudentsPayment::destroy($id)) {
                    Accounts::where("entry_category", "like", "%Student Payment%")->where("payment_id", $id)->update(["entry_category" => "Student Payment[Deleted]"]);
                    return ResponseMessage::success("Payment Record Deleted!");
                }
            } else {
                return ResponseMessage::fail("Payment Record Doesn't Exist!");
            }
        } else {
            ResponseMessage::unauthorized($permission);
        }
    }

    public function insertDueAdvance($payments)
    {
        $due_arr = [];
        foreach ($payments as $payment) {
            $calc_amount = 0;
            $payment_amount = $payment->payment_amount;
            $paid_amount = $payment->paid_amount;

            if ($payment_amount !== $paid_amount) {
                $calc_amount = $payment_amount - $paid_amount;
            }

            if ($calc_amount != 0)
                array_push($due_arr, ["student_id" => $payment->student_id, "payment_id" => $payment->id, "amount" => $calc_amount, "status" => "DUE"]);
        }
        if (count($due_arr) > 0) {

            if (!StudentsPaymentAccount::insert($due_arr))
                return false;
        }

        return true;
    }

    public function paymentArrayConverter($payments, $receipt_id, $student_id, $session_id, $date)
    {
        $payment_arr = [];
        $accounts_arr = [];
        $student = Students::find($student_id);
        $student_name = $student->student_name;
        foreach ($payments as $payment) {
            $payment_category = $payment["payment_category"];
            $payment_info = $payment["payment_info"];
            $payment_amount = $payment["payment_amount"];
            $paid_amount = $payment["paid_amount"];
            $payment_info = $payment_info == null ? '' : $payment_info;
            array_push($payment_arr, ["session_id" => $session_id, "student_id" => $student_id, "date" => $date, "payment_category" => $payment_category, "payment_info" => $payment_info, "payment_amount" => $payment_amount, "paid_amount" => $paid_amount, "group_id" => $receipt_id]);
            array_push($accounts_arr, ["balance_form" => "Cash", "entry_type" => "Credit", "entry_category" => "Student Payment", "entry_info" => "Receipt ID: " . $receipt_id . "\nStudent ID: " . $student_id . "\nStudent Name: " . $student_name . "\nPayment Info: " . $payment_category . " - " . $payment_info, "amount" => $paid_amount, "date" => $date]);
        }
        return [$payment_arr, $accounts_arr];
    }
}
