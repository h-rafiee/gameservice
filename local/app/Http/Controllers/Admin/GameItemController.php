<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GameItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        $game = \App\Game::find($id);
        $items = \App\GameItem::where('game_id',$id)->paginate(20);
        return view('admin.item.index',compact(['game','items']))->with('i', ($request->input('page', 1) - 1) * 20);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $game = \App\Game::find($id);
        return view('admin.item.create',compact('game'));
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

            'title' => 'required',
            'price' => 'required',

        ]);

        $input = $request->all();
        $helper = new \App\Helpers\Helper();
        $input['slug'] = $helper->generateRandomString(10);
        while(\App\GameItem::where('slug',$input['slug'])->count()>0){
            $input['slug'] = $helper->generateRandomString(10);
        }
        $request->replace($input);

        $path = '';

        if($request->hasFile('logo')){
            $path = $request->logo->store('images', 'uploads');
        }

        \App\GameItem::create([
            'game_id'=>$request->game_id,
            'slug'=>$request->slug,
            'title'=>$request->title,
            'description'=>$request->description,
            'price'=>$request->price,
            'free_item' => ($request->price == 0)?1:0,
            'logo'=>$path,
        ]);

        return redirect('admin/items/game/'.$request->game_id)

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
        $item = \App\GameItem::find($id);
        return view('admin.item.edit',compact('item'));
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

            'title' => 'required',
            'price' => 'required',

        ]);

        $path = '';
        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'price'=>$request->price,
            'free_item' => ($request->price == 0)?1:0,
        ];
        if($request->hasFile('logo')){
            $path = $request->logo->store('images', 'uploads');
            $data['logo']=$path;
        }

        \App\GameItem::find($id)->update($data);

        return redirect('admin/items/game/'.\App\GameItem::find($id)->game_id)

            ->with('success','Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\GameItem::find($id)->delete();

        return redirect()->back()

            ->with('success','Item deleted successfully');
    }
}
