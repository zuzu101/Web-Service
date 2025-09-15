<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\ContactSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactSection = ContactSection::getActive();
        return view('back.cms.contact-section.index', compact('contactSection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $contactSection = ContactSection::getActive();
        return view('back.cms.contact-section.edit', compact('contactSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maps_embed_url' => 'required|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $contactSection = ContactSection::getActive();
        
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $contactSection->update($data);

        return redirect()->route('admin.cms.contact-section.index')
            ->with('success', 'Contact Section berhasil diupdate!');
    }
}
