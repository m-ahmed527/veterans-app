<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(123);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->sanitizedRequest($request);
            // dd($data);
            DB::beginTransaction();
            $product = auth()->user()->products()->create($data);
            DB::commit();
            return responseSuccess('Product created successfully', $product->load('category'));
        } catch (\Exception $e) {
            DB::rollBack();
            return responseError($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    protected function sanitizedRequest(Request $request, $product = null): array
    {


        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'image' => 'sometimes|required|array',
            'image.*' => 'sometimes|required|image', // Allow multiple images
        ], [
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category does not exist',
            'status.boolean' => 'Status must be 1 or 0',
        ]);


        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'company' => $request->company,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
        ];
        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $key => $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                // $image->move(public_path('vendor/products/images'), $imageName);
                $images[] = asset('vendor/products/images') . '/' . $imageName;
            }
            $data['image'] = $images;
        }
        return $data;
    }
}
