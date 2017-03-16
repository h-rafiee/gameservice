<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = \App\User::orderBy('id','DESC')->paginate(20);
        return view('admin.user.index',compact('items'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $helper = new \App\Helpers\Helper();

        $input = $request->all();
        $input['email'] = $helper->fixEmail($input['email']);
        $request->replace($input);

        $this->validate($request, [

            'name' => 'required',
            'username'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'mobile'=>'required',
            'password'=>'required|min:3'

        ]);
        $input = $request->all();
        $input['password'] = \Hash::make($input['password']);
        $input['userID'] = $helper->generateNumber(10);
        while(\App\User::where('userID',$input['userID'])->count()>0){
            $input['userID'] = $helper->generateNumber(10);
        }
        $request->replace($input);

        \App\User::create($request->all());

        return redirect()->route('users.index')

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
        $item = \App\User::find($id);
        return view('admin.user.edit',compact('item'));

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
        $helper = new \App\Helpers\Helper();

        $input = $request->all();
        $input['email'] = $helper->fixEmail($input['email']);
        $request->replace($input);

        $this->validate($request, [

            'name' => 'required',
            'username'=>'required|unique:users,username,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'mobile'=>'required',
        ]);
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = \Hash::make($input['password']);
        }else{
            unset($input['password']);
        }
        $request->replace($input);

        \App\User::find($id)->update($request->all());

        return redirect()->route('users.index')

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
        \App\User::find($id)->delete();

        return redirect()->route('users.index')

            ->with('success','Item deleted successfully');
    }
}
