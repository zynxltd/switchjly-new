@extends('layouts.app')

@section('title', 'Brillia Energy — Compare UK energy deals and save')
@section('meta_description', 'Compare energy deals from leading UK suppliers in under a minute. Brillia Energy is 100% free — find lower bills with no hassle.')

@section('content')
    <x-hero />
    <x-suppliers />
    <x-features />
    <x-testimonials />
    <x-faqs />
    <x-cta />
@endsection
