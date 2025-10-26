<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    public function show(): View
    {
        $company = auth()->user()->company;
        return view('company.show', compact('company'));
    }

    public function create(): View
    {
        return view('company.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'tone_of_voice' => 'required|string|max:255',
            'keywords' => 'nullable|string',
        ]);

        $keywords = $request->keywords 
            ? array_map('trim', explode(',', $request->keywords))
            : null;

        Company::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'industry' => $request->industry,
            'tone_of_voice' => $request->tone_of_voice,
            'keywords' => $keywords,
        ]);

        return redirect()->route('company.show')
            ->with('success', 'Company profile created successfully!');
    }

    public function edit(): View
    {
        $company = auth()->user()->company;
        
        if (!$company) {
            return redirect()->route('company.create');
        }

        return view('company.edit', compact('company'));
    }

    public function update(Request $request): RedirectResponse
    {
        $company = auth()->user()->company;
        
        if (!$company) {
            return redirect()->route('company.create');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'tone_of_voice' => 'required|string|max:255',
            'keywords' => 'nullable|string',
        ]);

        $keywords = $request->keywords 
            ? array_map('trim', explode(',', $request->keywords))
            : null;

        $company->update([
            'name' => $request->name,
            'industry' => $request->industry,
            'tone_of_voice' => $request->tone_of_voice,
            'keywords' => $keywords,
        ]);

        return redirect()->route('company.show')
            ->with('success', 'Company profile updated successfully!');
    }
}
