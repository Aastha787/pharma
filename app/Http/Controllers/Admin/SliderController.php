<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\SliderFormRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.slider.index');
    }

        public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.slider.create');
    }
    public function store(SliderFormRequest $request ): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validated();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() .'.'. $ext;
            $file->move('uploads/slider/',$filename);
            $validatedData['image']="uploads/slider/$filename";
        }

        Slider::create([
            'title'=> $validatedData['title'],
            'description'=> $validatedData['description'],
            'image'=>$validatedData['image'],

        ]);

        return redirect('admin/sliders')->with('message','Slider added succesfully');

    }


}
