<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:sliders']);
        \config_set('theme.cdata', [
            'title' => 'All Sliders',
            'model' => 'Slider',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Sliders',
                    'link' => false
                ],
            ],
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = new Slider();

        $collection = $collection->where(function ($collection) use ($request) {
            $collection->where('title', 'LIKE', "%{$request->search}%");
        });
        $collection = $collection->paginate(20)->withQueryString();

        return \view('pages.admin.sliders.index', \compact('collection'));
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
            'title' => ['required', 'string'],
            'order' => ['required', 'integer', 'min:1'],
            'image' => ['required', 'mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=970,height=400'],
        ]);

        $data['image'] = upload_image($request, 'image', 'sliders');

        // dd($data);
        Slider::create($data);

        // flash message
        Session::flash('success', 'New Slider Added.');
        return \redirect()->route('admin.sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        \config_set('theme.cdata', [
            'title' => 'Update Slider',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Bands',
                    'link' => route('admin.sliders.index')
                ],
                [
                    'name' => 'Update Slider',
                    'link' => false
                ],
            ],
            'add' => \route('admin.sliders.index')
        ]);

        return \view('pages.admin.sliders.update', ['data'=>$slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'order' => ['required', 'integer', 'min:1'],
            'image' => ['mimes:png,jpg,jpeg,svg,gif', 'max:2024', 'dimensions:width=970,height=400'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        $data['image'] = upload_image($request, 'image', 'sliders', $slider->image);

        // dd($data);
        $slider->update($data);

        // flash message
        Session::flash('success', 'Slider Updated Successfully.');
        return \redirect()->route('admin.sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        // delete image from folder
        deleteFile($slider->image);

        // delete record from db
        $slider->delete();

        // flash message
        Session::flash('success', 'Slider Deleted Successfully.');
        return \redirect()->route('admin.sliders.index');
    }
}
