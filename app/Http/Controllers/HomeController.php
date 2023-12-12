<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;



class HomeController extends Controller
{
    public function index()
    {
        $homes = Task::latest()->get(); // Assuming 'Student' is your Eloquent model for students

        return view('create', [
            'homes' => $homes, // Pass the 'students' variable to the view
        ]);
    }
    //    api  get data
    public function test()
    {
        try {
            $tasks = Task::latest()->get();

            return $tasks;
        } catch (\Exception $e) {
            // Log the exception or handle it in a way that makes sense for your application
            return response()->json(['error' => 'Error fetching tasks'], 500);
        }
    }




    public function store(Request $request)
    {
        $request->validate([
            'p_id' => 'required',
            'tittle' => 'required',
            'description' => 'required',

            'complete' => 'required',

        ]);



        Task::create([
            'p_id' => $request->p_id,
            'tittle' => $request->tittle,
            'description' => $request->description,
            'complete' => $request->complete,

        ]);

        return back()->with('success', 'Data created successfully');
    }

    public function apistore(Request $request)
    {
        try {
            $request->validate([
                'p_id' => 'required',
                'tittle' => 'required',
                'description' => 'required',
                'complete' => 'required',
            ]);

            Task::create([
                'p_id' => $request->p_id,
                'tittle' => $request->tittle,
                'description' => $request->description,
                'complete' => $request->complete,
            ]);

            return response()->json(['success' => 'Data created successfully'], 200);
        } catch (QueryException $e) {
            // Log the exception or handle it in a way that makes sense for your application
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Log the exception or handle it in a way that makes sense for your application
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $home = Task::find($id);
        return view('edit', compact('home'));
    }





    public function update(Request $request)
    {
        $home = Task::find($request->data_id);

        $home->update([
            'p_id' => $request->p_id,
            'tittle' => $request->tittle,
            'description' => $request->description,
        ]);

        return redirect('/')->with('success', 'Update successfully');
    }



    public function destroy(Request $request)

    {
        Task::destroy($request->data_id);

        return back()->with('success', 'Deleted successfully');
    }
}
