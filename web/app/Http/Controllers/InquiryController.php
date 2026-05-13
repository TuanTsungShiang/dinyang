<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:100'],
            'phone'        => ['required', 'string', 'max:50'],
            'email'        => ['required', 'email', 'max:255'],
            'message'      => ['required', 'string'],
            'attachment'   => ['nullable', 'file', 'max:10240',
                               'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'],
        ]);

        $inquiry = Inquiry::create([
            'company_name'      => $validated['company_name'],
            'contact_name'      => $validated['contact_name'],
            'phone'             => $validated['phone'],
            'email'             => $validated['email'],
            'message'           => $validated['message'],
            'source'            => 'website',
            'status'            => 'new',
            'ip_address'        => $request->ip(),
            'user_agent'        => $request->userAgent(),
            'privacy_agreed_at' => now(),
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('inquiry-attachments', 'public');
            $inquiry->attachments()->create([
                'path'          => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'size_bytes'    => $file->getSize(),
            ]);
        }

        return redirect()->back()
            ->with('inquiry_success', '詢價單已送出，我們將在 1 個工作日內與您聯繫！');
    }
}
