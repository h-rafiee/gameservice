<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameLeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        $game = \App\Game::find($id);
        $items = \App\GameLeaderboard::where('game_id',$id)->paginate(20);
        return view('admin.leaderboards.index',compact(['game','items']))->with('i', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $game = \App\Game::find($id);
        return view('admin.leaderboards.create',compact('game'));
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

        ]);
        $input = $request->all();
        $helper = new \App\Helpers\Helper();
        $input['slug'] = $helper->generateRandomString(10);
        while(\App\GameAchievement::where('slug',$input['slug'])->count()>0){
            $input['slug'] = $helper->generateRandomString(10);
        }
        $request->replace($input);

        $path = '';

        if($request->hasFile('logo')){
            $path = $request->logo->store('images', 'uploads');
        }

        \App\GameLeaderboard::create([
            'game_id'=>$request->game_id,
            'slug'=>$request->slug,
            'title'=>$request->title,
            'description'=>$request->description,
            'priority'=>$request->priority,
            'logo'=>$path,
        ]);

        return redirect('admin/leaderboards/game/'.$request->game_id)

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
        $item = \App\GameLeaderboard::find($id);
        return view('admin.leaderboards.edit',compact('item'));
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

        ]);
        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'priority'=>$request->priority,
        ];
        $path = '';

        if($request->hasFile('logo')){
            $path = $request->logo->store('images', 'uploads');
            $data['logo'] = $path;
        }

        \App\GameLeaderboard::find($id)->update($data);

        return redirect('admin/achievements/game/'.\App\GameLeaderboard::find($id)->game_id)

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
        \App\GameAchievement::find($id)->delete();

        return redirect()->back()

            ->with('success','Item deleted successfully');
    }
}
