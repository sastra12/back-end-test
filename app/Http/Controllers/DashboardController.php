<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DataTables;

class DashboardController extends Controller
{
    public function data(Request $request)
    {
        $query = Employee::with('department');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        // Cek apakah ada permintaan start_date dan end_date di request
        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();
            // Filter data berdasarkan tanggal bergabung
            $query->whereBetween('date_of_joining', [$start_date, $end_date]);
        }

        // Ambil data karyawan dengan departemen terkait
        $employees = $query->get();
        return Datatables::of($employees)
            ->addIndexColumn()
            ->addColumn('department_name', function ($employees) {
                return $employees->department->name;
            })
            ->addColumn('date_of_birth', function ($employees) {
                return date("d M Y", strtotime($employees->date_of_birth));
            })
            ->addColumn('date_of_joining', function ($employees) {
                return date("d M Y", strtotime($employees->date_of_joining));
            })
            ->addColumn('action', function ($employees) {
                return '
                <button onclick="editForm(`' . route('edit-employee', $employees->employee_id) . '`)" class="btn btn-sm btn-info">Edit</button>
                <button onclick="deleteData(`' . route('delete-employee', $employees->employee_id) . '`)" class="btn btn-sm btn-danger">Delete</button>
            ';
            })
            ->toJson();
    }

    public function index()
    {
        $departments = Department::all();
        return view('dashboard.index', ['departments' => $departments]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => ['required', 'string', 'regex:/^(?:\+62|62|0)(?:\d{8,15}|\d{1,4}[\s\-]\d{1,4}[\s\-]\d{1,4}[\s\-]\d{1,4})$/'],
            'address' => 'required',
            'date_of_birth' => 'required',
            'date_of_joining' => 'required',
            'gender' => 'required',
            'department' => 'required',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'status' => 'Failed updated',
                'errors' => $validated->messages()
            ]);
        } else {
            $data = new Employee();
            $data->name = $request->input('name');
            $data->phone_number = $request->input('phone_number');
            $data->date_of_birth = $request->input('date_of_birth');
            $data->date_of_joining = $request->input('date_of_joining');
            $data->address = $request->input('address');
            $data->gender = $request->input('gender');
            $data->department_id = $request->input('department');
            $data->save();
            return response()->json([
                'status' => 'Success',
                'message' => 'Success Added Data'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Employee::with('department')->find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => ['required', 'string', 'regex:/^(?:\+62|62|0)(?:\d{8,15}|\d{1,4}[\s\-]\d{1,4}[\s\-]\d{1,4}[\s\-]\d{1,4})$/'],
            'address' => 'required',
            'date_of_birth' => 'required',
            'date_of_joining' => 'required',
            'gender' => 'required',
            'department' => 'required',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'status' => 'Failed updated',
                'errors' => $validated->messages()
            ]);
        } else {
            $data = Employee::find($id);
            $data->name = $request->input('name');
            $data->phone_number = $request->input('phone_number');
            $data->date_of_birth = $request->input('date_of_birth');
            $data->date_of_joining = $request->input('date_of_joining');
            $data->address = $request->input('address');
            $data->gender = $request->input('gender');
            $data->department_id = $request->input('department');
            $data->save();
            return response()->json([
                'status' => 'Success',
                'message' => 'Success Updated Data'
            ]);
        }
    }

    public function delete($id)
    {
        $data = Employee::find($id);
        $data->delete();
    }
}
