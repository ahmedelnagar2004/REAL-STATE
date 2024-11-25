<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniteController extends Controller
{
    // عرض قائمة الوحدات
    public function index()
    {
        $query = Unite::query();

        if (request()->has('search') && request()->filled('search')) {
            $searchTerm = request()->search;
            $searchBy = request()->search_by ?? 'name';

            switch ($searchBy) {
                case 'name':
                    $query->where('name', 'LIKE', "%{$searchTerm}%");
                    break;
                case 'location':
                    $query->where('location', 'LIKE', "%{$searchTerm}%");
                    break;
                case 'price':
                    $searchPrice = str_replace(',', '', $searchTerm);
                    if (is_numeric($searchPrice)) {
                        $query->where('price', '=', $searchPrice);
                    }
                    break;
            }
        }

        $unites = $query->latest()->paginate(12);
        return view('unites.index', compact('unites'));
    }

    // عرض نموذج إنشاء وحدة جديدة
    public function create()
    {
        return view('unites.create');
    }

    // حفظ وحدة جديدة
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'status' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // إنشاء الوحدة
        $unite = Unite::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'status' => $request->status
        ]);

        // معالجة الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('unites', 'public');
                
                $unite->images()->create([
                    'image' => $path
                ]);
            }
        }

        return redirect()->route('unites.index')
            ->with('success', 'تم إضافة الوحدة بنجاح');
    }

    // عرض وحدة محددة
    public function show(Unite $unite)
    {
        return view('unites.show', compact('unite'));
    }

    // عرض صفحة التعديل
    public function edit(Unite $unite)
    {
        return view('unites.edit', compact('unite'));
    }

    // تحديث البيانات
    public function update(Request $request, Unite $unite)
    {
        // طباعة البيانات للتأكد من وصولها
    

        // التحقق من البيانات
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'status' => 'required'
        ]);

        // تحديث البيانات مباشرة
        $unite->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'status' => $request->status
        ]);

        // معالجة الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('unites', 'public');
                $unite->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('unites.show', $unite)
            ->with('success', 'تم تحديث الوحدة بنجاح');
    }

    // حذف وحدة
    public function destroy(Unite $unite)
    {
        // حذف الصور من التخزين
        foreach ($unite->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        // حذف الوحدة (سيتم حذف الصور تلقائياً من قاعدة البيانات بسبب cascade)
        $unite->delete();

        return redirect()->route('unites.index')
            ->with('success', 'تم حذف الوحدة بنجاح');
    }

    // حذف صورة
    public function deleteImage($id)
    {
        try {
            $image = Image::findOrFail($id);
            
            // حذف الملف من التخزين
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            
            // حذف السجل من قاعدة البيانات
            $image->delete();

            return back()->with('success', 'تم حذف الصورة بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء حذف الصورة');
        }
    }

    // إضافة صور لوحدة موجودة
    public function addImages(Request $request, Unite $unite)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('unites', 'public');
                
                $unite->images()->create([
                    'image' => $path
                ]);
            }
        }

        return back()->with('success', 'تم إضافة الصور بنجاح');
    }
}