<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 


use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function list()
    {
        return response()->json(About::all());
    }

    public function create(Request $request)
    {
        $about = About::create($request->all());
        return response()->json($about);
    }

    public function show($id)
    {
        return response()->json(About::find($id));
    }

    public function update(Request $request, $id)
    {
        $about = About::find($id);
        $about->update($request->all());

        return response()->json($about);
    }

    public function destroy($id)
    {
        About::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}