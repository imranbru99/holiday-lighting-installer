@extends('layouts.app')
@section('title', 'Holiday Lighting Services')
@section('meta_description', 'Roofline C9, permanent LED, commercial displays, wreaths, tree wraps, and takedown storage from LuminaRidge Holiday Lighting in Denver and the Front Range.')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">End-to-end holiday lighting for Colorado homes, HOAs, and retail — measured, installed, maintained, stored.</p>
        <div class="grid-3">
            @foreach([
                ['roofline-c9','Roofline C9 & Classic','https://images.unsplash.com/photo-1543589077-47d81606c1bf?auto=format&fit=crop&w=1200&q=80'],
                ['permanent-led','Permanent LED Track','https://images.unsplash.com/photo-1512389142860-9c449e58a543?auto=format&fit=crop&w=1200&q=80'],
                ['commercial-displays','Commercial Displays','https://images.unsplash.com/photo-1482514194978-3ed8cc9bc132?auto=format&fit=crop&w=1200&q=80'],
                ['wreaths-garland','Wreaths & Garland','https://images.unsplash.com/photo-1576919228236-a097c6a17f44?auto=format&fit=crop&w=1200&q=80'],
                ['tree-wraps','Tree & Landscape Wraps','https://images.unsplash.com/photo-1513885535751-8b9238bd345a?auto=format&fit=crop&w=1200&q=80'],
                ['takedown-storage','Takedown & Storage','https://images.unsplash.com/photo-1513201099705-a9746e1e201f?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection