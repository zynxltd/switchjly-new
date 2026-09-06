@extends('layouts.app')

@section('title', 'Brillia Energy — Compare UK energy deals and save')
@section('meta_description', 'Compare energy deals from leading UK suppliers in under a minute. Brillia Energy is 100% free — find lower bills with no hassle.')
@section('canonical', route('home'))

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('company.trading_name'),
            'legalName' => config('company.legal_name'),
            'url' => route('home'),
            'logo' => asset('images/logo-energy-wordmark-1.svg'),
            'email' => config('company.support_email'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '11 Brendon Close',
                'addressLocality' => 'Grantham',
                'addressRegion' => 'Lincolnshire',
                'postalCode' => 'NG31 8FU',
                'addressCountry' => 'GB',
            ],
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <x-hero />
    <x-suppliers />
    <x-features />
    <x-testimonials />
    <x-faqs />
    <x-cta />
@endsection

@section('chatbot')
    <x-chatbot />
@endsection
