<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;

class AffiliateAttribution
{
    /**
     * @return array{affiliate_id: int|null, referral_code: string|null}
     */
    public static function fromRequest(Request $request): array
    {
        $affiliateId = $request->session()->get('affiliate_id');
        $code = $request->session()->get('affiliate_ref')
            ?: $request->cookie('brillia_ref')
            ?: $request->cookie('switchly_ref');

        if ($code && ! $affiliateId) {
            $affiliate = User::query()
                ->where('role', User::ROLE_AFFILIATE)
                ->where('referral_code', strtoupper((string) $code))
                ->first();

            if ($affiliate) {
                $affiliateId = $affiliate->id;
                $code = $affiliate->referral_code;
                $request->session()->put('affiliate_id', $affiliateId);
                $request->session()->put('affiliate_ref', $code);
            }
        }

        return [
            'affiliate_id' => $affiliateId ? (int) $affiliateId : null,
            'referral_code' => $code ? strtoupper((string) $code) : null,
        ];
    }
}
