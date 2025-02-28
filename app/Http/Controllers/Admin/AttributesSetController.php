<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\AttributesSet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AttributesSetController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:attributes_sets']);
        \config_set('theme.cdata', [
            'title' => 'All Attributes',
            'model' => 'AttributesSet',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Attributes',
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
        $collection = new AttributesSet();

        $collection = $collection->where(function ($collection) use ($request) {
            $collection->where('title', 'LIKE', "%{$request->search}%");
        });
        $collection = $collection->paginate(20)->withQueryString();

        return \view('pages.admin.attributes-sets.index', \compact('collection'));
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
            'title' => ['required', 'string', 'unique:attributes_sets,title'],
        ]);

        // dd($data);
        AttributesSet::create($data);

        // flash message
        Session::flash('success', 'New Attribute Added.');
        return \redirect()->route('admin.attributes-sets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\AttributesSet  $attributesSet
     * @return \Illuminate\Http\Response
     */
    public function show(AttributesSet $attributesSet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\AttributesSet  $attributesSet
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributesSet $attributesSet)
    {
        \config_set('theme.cdata', [
            'title' => 'Update Attribute',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Attributes',
                    'link' => route('admin.attributes-sets.index')
                ],
                [
                    'name' => 'Update Attribute',
                    'link' => false
                ],
            ],
        ]);

        return \view('pages.admin.attributes-sets.update', ['data'=>$attributesSet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\AttributesSet  $attributesSet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributesSet $attributesSet)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'unique:attributes_sets,title,'.$attributesSet->id.',id'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        // dd($data);
        $attributesSet->update($data);

        // flash message
        Session::flash('success', 'Attribute Updated Successfully.');
        return \redirect()->route('admin.attributes-sets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\AttributesSet  $attributesSet
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributesSet $attributesSet)
    {

        if($attributesSet->attributeValues()->count() == 0){
            $attributesSet->delete();

            Session::flash('success', 'Attribute Deleted.');
        }else{
            Session::flash('error', 'This attribute has values.');
        }

        return \redirect()->route('admin.attributes-sets.index');
    }
}
