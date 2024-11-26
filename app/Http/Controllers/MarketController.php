<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\UnitImage;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        $clients = client::latest()->get();
        return view('frontend.market', compact('clients'));
    }

    public function create()
    {
        // إنشاء نموذج فارغ للعميل
        $client = new Client();
        
        return view('frontend.market.create', compact('client'));
    }

    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validated = $request->validate([
                'name_clint' => 'required|string|max:255',
                'email_clint' => 'nullable|email',
                'phone_clint' => 'required|string|max:20',
                'type_unite' => 'required|string',
                'price_unite' => 'required|numeric',
                'status_unite' => 'required|string',
                'unit_images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // إنشاء العميل
            $client = new Client();
            $client->name_clint = $request->name_clint;
            $client->email_clint = $request->email_clint;
            $client->phone_clint = $request->phone_clint;
            $client->type_unite = $request->type_unite;
            $client->price_unite = $request->price_unite;
            $client->status_unite = $request->status_unite;
            $client->save();

            // معالجة الصور
            if ($request->hasFile('unit_images')) {
                foreach($request->file('unit_images') as $image) {
                    $path = $image->store('unit-images', 'public');
                    
                    UnitImage::create([
                        'client_id' => $client->id,
                        'image_path' => $path
                    ]);
                }
            }

            // إرجاع رسالة النجاح
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $client = client::findOrFail($id);
        return view('frontend.market.show', compact('client'));
    }

    public function edit($id)
    {
        $client = client::findOrFail($id);
        return view('frontend.market.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = client::findOrFail($id);

        $validated = $request->validate([
            'name_clint' => 'required|string|max:255',
            'email_clint' => 'required|email|unique:clients,email_clint,' . $id,
            'phone_clint' => 'required|string|max:20',
            'type_unite' => 'required|string',
            'price_unite' => 'required|numeric',
            'status_unite' => 'required|string',
            'image_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        try {
            // معالجة ملف PDF الجديد إذا تم تحميله
            if ($request->hasFile('image_pdf')) {
                // حذف الملف القديم إذا وجد
                if ($client->image_pdf) {
                    \Storage::disk('public')->delete($client->image_pdf);
                }
                
                $pdfPath = $request->file('image_pdf')->store('client_documents', 'public');
                $validated['image_pdf'] = $pdfPath;
            }

            $client->update($validated);

            return redirect()->route('frontend.market')
                           ->with('success', 'تم تحديث بيانات العميل بنجاح');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحديث بيانات العميل: ' . $e->getMessage())
                        ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $client = client::findOrFail($id);
            
            // حذف ملف PDF إذا وجد
            if ($client->image_pdf) {
                \Storage::disk('public')->delete($client->image_pdf);
            }

            $client->delete();

            return redirect()->route('frontend.market')
                           ->with('success', 'تم حذف العميل بنجاح');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء حذف العميل: ' . $e->getMessage());
        }
    }
}
