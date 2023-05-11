<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.products.index',compact('products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();
        $category = Category::findOrFail($validatedData['category_id']);
        $product = $category->products()->create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['slug']),
            'small_description' => $validatedData['small_description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'status' => $request->status == true ? '1':'0',
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
        ]);
        //return $product->id;

        if($request->hasFile('image')){
            $uploadPath = 'uploads/products/';

            $i =1;

            foreach($request->file('image') as $imageFile){
                $extention = $imageFile->getClientOriginalExtension();
                $filename = time().$i.'.'.$extention;
                $imageFile->move($uploadPath,$filename);
                $finalImagePathName = $uploadPath.$filename;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName,

                ]);

            }
        }
        return redirect('/admin/products')->with('message','Product Added Succesfully');
    }

    public function edit(int $product_id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($product_id);
      return view( 'admin.products.edit', compact('categories','product'));
    }

    public function update(ProductFormRequest $request, int $product_id)
    {
        $validatedAData = $request->validated();
        $product = Category::findOrFail($validatedAData['category_id'])->products()->where('id', $product_id)->first();
        if($product)
        {
$product->update([
    'category_id' => $validatedAData['category_id'],
    'name' => $validatedAData['name'],
    'slug' => Str::slug($validatedAData['slug']),
    'small_description' => $validatedAData['small_description'],
    'description' => $validatedAData['description'],
    'original_price' => $validatedAData['original_price'],
    'selling_price' => $validatedAData['selling_price'],
    'quantity' => $validatedAData['quantity'],
    'status' => $request->status == true ? '1':'0',
    'meta_title' => $validatedAData['meta_title'],
    'meta_keyword' => $validatedAData['meta_keyword'],
            ]);

            if($request->hasFile('image')){
                $uploadPath = 'uploads/products/';

                $i =1;

                foreach($request->file('image') as $imageFile){
                    $extention = $imageFile->getClientOriginalExtension();
                    $filename = time().$i.'.'.$extention;
                    $imageFile->move($uploadPath,$filename);
                    $finalImagePathName = $uploadPath.$filename;

                    $product->productImages()->create([
                        'product_id' => $product->id,
                        'image' => $finalImagePathName,

                    ]);

                }
            }
            return redirect('/admin/products')->with('message','Product Updated Successfully');

        }
else
{
    return redirect('admin/products')->with('message', 'No such product found');
}

    }

    public function destroyImage(int $product_image_id): \Illuminate\Http\RedirectResponse
    {
        $productImage= ProductImage::findOrFail($product_image_id);
        if(File::exists($productImage->image))
            File::delete($productImage->image);
        $productImage->delete();
        return redirect()->back()->with('message', 'Product image deleted.');

    }

     public function destroy(int $product_id): \Illuminate\Http\RedirectResponse
     {
        $product=Product::findOrFail($product_id);
        if($product->productImages())
        {
            foreach($product->productImages as $image)
            {
                if(File::exists($image->image))
                {
                    File::delete($image->image);
                }
            }
        }
        $product->delete();
        return redirect()->back()->with('message','Product deleted with all its images.');
     }
}




