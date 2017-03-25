<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = \App\Game::orderBy('id','DESC')->paginate(20);
        return view('admin.game.index',compact('items'))->with('i', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::all();
        return view('admin.game.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id'=>'required',
            'package_name' => 'required|unique:games',
            'title'=>'required',

        ]);

        $path = '';

        if($request->hasFile('logo')){
            $path = $request->logo->store('images', 'uploads');
        }
        $helper = new \App\Helpers\Helper();
        $api = str_random(4).$helper->generateRandomString(6);
        while(\App\Game::where('api_key',$api)->count()>0){
            $api = str_random(4).$helper->generateRandomString(6);
        }

        \App\Game::create([
            'category_id' => $request->category_id,
            'package_name' => $request->package_name,
            'title'=>$request->title,
            'logo'=>$path,
            'api_key'=>$api
        ]);

        return redirect()->route('games.index')

            ->with('success','Item created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = \App\Game::find($id);
        $categories = \App\Category::all();
        return view('admin.game.edit',['item'=>$item,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id'=>'required',
            'package_name' => 'required|unique:games,package_name,'.$id,
            'title'=>'required',

        ]);

        $data = [
            'category_id' => $request->category_id,
            'package_name' => $request->package_name,
            'title'=>$request->title,
        ];


        if($request->hasFile('logo')){
            $path = $request->logo->store('images', 'uploads');
            $data['logo'] = $path;
        }

        \App\Game::find($id)->update($data);

        return redirect()->route('games.index')

            ->with('success','Item created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Game::find($id)->delete();
        return redirect()->route('games.index')

            ->with('success','Item deleted successfully');
    }
}
