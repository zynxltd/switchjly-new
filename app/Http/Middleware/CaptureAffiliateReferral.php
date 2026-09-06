<?php

namespace App\Http\Middleware;

use App\Models\AffiliateClick;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CaptureAffiliateReferral
{
    public function handle(Request $request, Closure $next): Response
    {
        $code = strtoupper(trim((string) $request->query('ref', '')));

        if ($code === '') {
            return $next($request);
        }

        try {
            $affiliate = User::query()
                ->where('role', User::ROLE_AFFILIATE)
                ->where('referral_code', $code)
                ->first();
        } catch (Throwable $e) {
            Log::warning('Affiliate referral lookup skipped — database unavailable.', [
                'message' => $e->getMessage(),
            ]);

            return $next($request);
        }

        if (! $affiliate) {
            return $next($request);
        }

        $alreadyTracked = $request->session()->get('affiliate_ref') === $code
            && $request->session()->get('affiliate_id') === $affiliate->id;

        $request->session()->put('affiliate_ref', $code);
        $request->session()->put('affiliate_id', $affiliate->id);

        cookie()->queue(cookie(
            'brillia_ref',
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
            try {
                AffiliateClick::query()->create([
                    'affiliate_id' => $affiliate->id,
                    'referral_code' => $code,
                    'ip_address' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'landing_path' => '/'.ltrim($request->path(), '/'),
                ]);
            } catch (Throwable $e) {
                Log::warning('Affiliate click tracking skipped — database unavailable.', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return $next($request);
    }
}
