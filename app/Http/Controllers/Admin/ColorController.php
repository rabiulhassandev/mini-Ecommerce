<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:colors']);
        \config_set('theme.cdata', [
            'title' => 'All Colors',
            'model' => 'Color',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Colors',
                    'link' => false
                ],
            ],
            // 'add' => \route('admin.color.create')
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = new Color();

        $collection = $collection->where('status', true);

        $collection = $collection->where(function ($collection) use ($request) {
            $collection->where('name', 'LIKE', "%{$request->search}%");
            $collection->orWhere('color_code', 'LIKE', "%{$request->search}%");
        });
        $collection = $collection->paginate(20)->withQueryString();

        return \view('pages.admin.colors.index', \compact('collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:colors,name,'.false.',status'],
            'color_code' => ['required', 'string', 'unique:colors,color_code,'.false.',status'],
        ]);

        // dd($data);
        Color::create($data);

        // flash message
        Session::flash('success', 'New Color Added.');
        return \redirect()->route('admin.colors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        \config_set('theme.cdata', [
            'title' => 'Update Color',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Colors',
                    'link' => route('admin.colors.index')
                ],
                [
                    'name' => 'Update Color',
                    'link' => false
                ],
            ],
            'add' => \route('admin.colors.index')
        ]);

        return \view('pages.admin.colors.update', ['data'=>$color]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:colors,name,'.$color->id.',id'],
            'color_code' => ['required', 'string', 'unique:colors,color_code,'.$color->id.',id'],
        ]);

        // dd($data);
        $color->update($data);

        // flash message
        Session::flash('success', 'Color Updated Successfully');
        return \redirect()->route('admin.colors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        $color->update(['status' => false]);

        // flash message
        Session::flash('success', 'Color Removed Successfully');
        return \redirect()->route('admin.colors.index');
    }
}
