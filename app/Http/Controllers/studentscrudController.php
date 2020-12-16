<?php

namespace App\Http\Controllers;

use App\Http\Resources\student_crudResource;
use Illuminate\Http\Request;
use App\Models\students_crud;
use Illuminate\Support\Facades\DB;

class studentscrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //show view
    public function index()
    {
        return view('students_crud');
    }
    //load data
    public function loaddata()
{
    $data = students_crud::all();
    $output = '';
    foreach ($data as $item){
        $output .= " <tr>
                            <td>{$item->id}</td>
                            <td>{$item->name}</td>
                            <td>{$item->rollno}</td>
                            <td>{$item->deportment}</td>
                            <td>
                            <button class='btn btn-info btn-sm' id='edit_btn' data-id='{$item->id}'>Edit</button>
                            <button class='btn btn-danger btn-sm' id='delete_btn' data-id='{$item->id}'>X</button></td>
                        </tr>";
    }
    return ($output);
}
    //store record
    public function store(Request $request)
    {
         students_crud::create([
            'name' =>$request->name,
            'rollno' =>$request->rollno,
            'deportment' =>$request->deportment,
        ]);
    }
    //edit record
    public function edit(Request $request)
    {
        $data = students_crud::find($request->id);
        return response()->json(['data'=>$data]);
    }
    //update record
    public function update(Request $request)
    {
        $id = $request->id;
        students_crud::find($id)->update([
            'name' => $request->name,
            'rollno' => $request->rollno,
            'deportment' => $request->deportment,
        ]);
    }
    //delete 1 record
    public function delete(Request $request)
    {
        $d_id = $request->id;
        students_crud::where('id',$d_id)->delete();
    }
    //delete all record
    public function delete_all()
    {
        DB::table('students_cruds')->delete();
    }
}
