<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Support\AffiliateCreatives;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CreativesController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('affiliate.creatives', [
            'user' => $user,
            'links' => AffiliateCreatives::links($user),
            'copyBlocks' => AffiliateCreatives::copyBlocks($user),
            'banners' => AffiliateCreatives::banners($user),
            'assets' => AffiliateCreatives::assets(),
        ]);
    }
}
