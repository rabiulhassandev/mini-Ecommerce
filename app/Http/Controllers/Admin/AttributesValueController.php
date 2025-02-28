<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\AttributesSet;
use App\Models\Admin\AttributesValue;
use Illuminate\Support\Facades\Session;

class AttributesValueController extends Controller
{
    /**
     * Middleware
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:attributes_values']);
        \config_set('theme.cdata', [
            'title' => 'All Attributes Values',
            'model' => 'AttributesValue',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Attributes Values',
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
        $collection = new AttributesValue();

        $collection = $collection->where(function ($collection) use ($request) {
            $collection->where('value', 'LIKE', "%{$request->search}%");
        });
        $collection = $collection->paginate(20)->withQueryString();

        $attributes = AttributesSet::where('status', true)->get();

        return \view('pages.admin.attributes-values.index', ['attributes' => $attributes, 'collection' => $collection]);
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
            'value' => ['required', 'string'],
            'attribute_id' => ['required', 'integer', 'in:' . \collect(AttributesSet::all())->pluck('id')->implode(',')],
        ]);

        // dd($data);
        AttributesValue::create($data);

        // flash message
        Session::flash('success', 'New Attribute Value Added.');
        return \redirect()->route('admin.attributes-values.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\AttributesValue  $attributesValue
     * @return \Illuminate\Http\Response
     */
    public function show(AttributesValue $attributesValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\AttributesValue  $attributesValue
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributesValue $attributesValue)
    {
        \config_set('theme.cdata', [
            'title' => 'Update Attribute Value',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard')
                ],
                [
                    'name' => 'All Bands',
                    'link' => route('admin.attributes-values.index')
                ],
                [
                    'name' => 'Update Attribute Value',
                    'link' => false
                ],
            ],
        ]);

        $attributes = AttributesSet::where('status', true)->get();

        return \view('pages.admin.attributes-values.update', ['data'=>$attributesValue, 'attributes'=>$attributes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\AttributesValue  $attributesValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributesValue $attributesValue)
    {
        $data = $request->validate([
            'value' => ['required', 'string'],
            'attribute_id' => ['required', 'integer', 'in:' . \collect(AttributesSet::all())->pluck('id')->implode(',')],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        // dd($data);
        $attributesValue->update($data);

        // flash message
        Session::flash('success', 'Attribute Value Updated.');
        return \redirect()->route('admin.attributes-values.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\AttributesValue  $attributesValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributesValue $attributesValue)
    {
        $attributesValue->delete();

        // flash message
        Session::flash('success', 'Attribute Value Deleted.');
        return \redirect()->route('admin.attributes-values.index');
    }
}
