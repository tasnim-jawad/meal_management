<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Department;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    public function all()
    {
        $paginate = (int) request()->paginate ?? 10;
        $orderBy = request()->orderBy ?? 'department_id';
        $orderByType = request()->orderByType ?? 'ASC';

        $status = 1;
        if (request()->has('status')) {
            $status = request()->status;
        }
        // dd($status);

        $query = Batch::where('status', $status)->orderBy($orderBy, $orderByType);
        // $query = User::latest()->get();

        if (request()->has('search_key')) {
            $key = request()->search_key;
            $query->where(function ($q) use ($key) {
                return $q->where('id', '%' . $key . '%')
                ->orWhere('department_id', '%' . $key . '%')
                ->orWhere('batch_name', '%' . $key . '%');
            });
        }

        $datas = $query->with('department')->paginate($paginate);
        // return response()->json($datas);
        // dd($datas);
        return view('admin.batch.index',compact('datas'));
    }

    public function department_wise($department_id){
        $batches = Batch::where('department_id',$department_id)->get()->all();
        return response([
            'status' => 'success',
            'data' => $batches
        ],200);
    }

    public function show($id)
    {

        $select = ["*"];
        if (request()->has('select_all') && request()->select_all) {
            $select = "*";
        }
        $data = Batch::where('id', $id)
            ->select($select)
            ->first();
        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json([
                'err_message' => 'data not found',
                'errors' => [
                    'user' => [],
                ],
            ], 404);
        }
    }
    public function create(){
        $departments = Department::get()->all();
        return view('admin.batch.create',compact('departments'));
    }


    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'department_id' => ['required'],
            'batch_name' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = new Batch();
        $data->department_id = request()->department_id;
        $data->batch_name = request()->batch_name;

        $data->creator = auth()->id();
        $data->status = request()->status;
        $data->save();

        return redirect('batch/all');
    }
    public function edit($id){
        $batch = Batch::where('id', $id)->get()->first();
        $departments = Department::get()->all();
        // dd($department);
        return view('admin.batch.edit',compact('batch','departments'));
    }

    public function update()
    {
        // dd(request()->all());
        // dd();
        $data = Batch::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['data not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }

        $validator = Validator::make(request()->all(), [
            'department_id' => ['required'],
            'batch_name' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }


        $data->department_id = request()->department_id;
        $data->batch_name = request()->batch_name;

        $data->creator = auth()->id();
        $data->status = request()->status;
        $data->save();

        Toastr::success('Batch succesfully updated', 'Success');

        return redirect('/batch/all');
    }

    public function soft_delete()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:batches,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Batch::find(request()->id);
        $data->status = 0;
        $data->save();

        return redirect('/batch/all');
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:batches,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Batch::find(request()->id);
        $data->delete();

        return redirect('/batch/all');
    }

    public function restore()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:batches,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Batch::find(request()->id);
        $data->status = 1;
        $data->save();

        return redirect('/batch/all');
    }
}
