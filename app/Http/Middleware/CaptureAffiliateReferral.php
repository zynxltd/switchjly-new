<?php

namespace App\Http\Middleware;

use App\Models\AffiliateClick;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureAffiliateReferral
{
    public function handle(Request $request, Closure $next): Response
    {
        $code = strtoupper(trim((string) $request->query('ref', '')));

        if ($code === '') {
            return $next($request);
        }

        $affiliate = User::query()
            ->where('role', User::ROLE_AFFILIATE)
            ->where('referral_code', $code)
            ->first();

        if (! $affiliate) {
            return $next($request);
        }

        $alreadyTracked = $request->session()->get('affiliate_ref') === $code
            && $request->session()->get('affiliate_id') === $affiliate->id;

        $request->session()->put('affiliate_ref', $code);
        $request->session()->put('affiliate_id', $affiliate->id);

        cookie()->queue(cookie(
            'switchly_ref',
            $code,
            60 * 24 * 30,
            '/',
            null,
            false,
            true,
            false,
            'lax',
        ));

        if (! $alreadyTracked) {
            AffiliateClick::query()->create([
                'affiliate_id' => $affiliate->id,
                'referral_code' => $code,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'landing_path' => '/'.$request->path(),
            ]);
        }

        return $next($request);
    }
}
