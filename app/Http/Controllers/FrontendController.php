<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $unites = Unite::with('images')
            ->latest()
            ->paginate(9);

        return view('frontend.home', compact('unites'));
    }

    public function search(Request $request)
    {
        $query = Unite::query();

        // البحث حسب الموقع
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // البحث حسب نطاق السعر
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '1': // أقل من مليون
                    $query->where('price', '<', 1000000);
                    break;
                case '2': // 1-2 مليون
                    $query->whereBetween('price', [1000000, 2000000]);
                    break;
                case '3': // أكثر من 2 مليون
                    $query->where('price', '>', 2000000);
                    break;
            }
        }

        // الترتيب
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $unites = $query->with('images')
            ->where('status', 'متاح')
            ->paginate(12);

        return view('frontend.search', compact('unites'));
    }

    public function show(Unite $unite)
    {
        // جلب الوحدات المشابهة (نفس الموقع أو نطاق السعر)
        $similarUnites = Unite::where('id', '!=', $unite->id)
            ->where(function($query) use ($unite) {
                $query->where('location', $unite->location)
                      ->orWhereBetween('price', [$unite->price * 0.8, $unite->price * 1.2]);
            })
            ->where('status', 'متاح')
            ->with('images')
            ->take(3)
            ->get();

        return view('frontend.units.show', compact('unite', 'similarUnites'));
    }
}
