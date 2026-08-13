<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة قبل الحفظ لضمان سلامة قاعدة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'project_type' => 'required|string',
            'dimensions' => 'nullable|string|max:100',
            'details' => 'nullable|string|max:1000',
        ]);

        // حفظ الطلب في قاعدة البيانات
        Quote::create($validated);

        // إعادة التوجيه مع رسالة تأكيد نجاح العملية
        return redirect()->back()->with('success', 'تم استلام طلبك بنجاح! سيتواصل معك المهندس المختص بالورشة قريباً لدراسة التفاصيل.');
    }
}