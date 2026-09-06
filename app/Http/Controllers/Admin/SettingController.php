<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.cms.settings.edit', [
            'promo_enabled' => SiteSetting::bool('promo_enabled', true),
            'promo_label' => SiteSetting::getValue('promo_label', 'Free comparison:'),
            'promo_message' => SiteSetting::getValue('promo_message', 'Check today’s UK energy deals and see what you could save —'),
            'promo_cta' => SiteSetting::getValue('promo_cta', 'Compare now'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'promo_label' => ['required', 'string', 'max:80'],
            'promo_message' => ['required', 'string', 'max:240'],
            'promo_cta' => ['required', 'string', 'max:40'],
        ]);

        SiteSetting::setValue('promo_enabled', $request->boolean('promo_enabled') ? '1' : '0');
        SiteSetting::setValue('promo_label', $data['promo_label']);
        SiteSetting::setValue('promo_message', $data['promo_message']);
        SiteSetting::setValue('promo_cta', $data['promo_cta']);

        return redirect()->route('admin.cms.settings.edit')->with('status', 'Site settings saved.');
    }
}
