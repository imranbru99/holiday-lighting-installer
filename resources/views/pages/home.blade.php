@extends('layouts.app')

@section('title', 'LuminaRidge Holiday Lighting')
@section('meta_description', 'Premium roofline C9, permanent LED, and commercial holiday displays installed across Denver and the Colorado Front Range by LuminaRidge.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>Mountain-ready<br>holiday lighting</h1>
        <p>Roofline C9, permanent LED track, commercial displays, and full-season takedown storage — installed by crews who know Front Range snow, wind, and HOA deadlines.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a design visit</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">View services</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Lighting services</h2>
        <p class="lede">Residential rooflines, permanent architectural LED, retail plazas, and takedown storage — each scope measured in linear feet and mapped to your controller plan.</p>
        <div class="grid-3">
            @foreach([
                ['roofline-c9','Roofline C9','Classic and custom roofline installs with GFCI-safe power.', 'https://images.unsplash.com/photo-1543589077-47d81606c1bf?auto=format&fit=crop&w=1200&q=80'],
                ['permanent-led','Permanent LED','Year-round track lighting with app scenes.', 'https://images.unsplash.com/photo-1512389142860-9c449e58a543?auto=format&fit=crop&w=1200&q=80'],
                ['commercial-displays','Commercial Displays','Storefront trees, poles, and plaza features.', 'https://images.unsplash.com/photo-1482514194978-3ed8cc9bc132?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why LuminaRidge</h2>
        <p class="lede">Denver crews that engineer every clip, circuit, and controller for altitude, ice, and long install seasons — not one-week pop-up strings.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Measured rooflines</h3>
                <p>Every quote starts with linear-foot measurements, outlet mapping, and load planning — no guesswork on material counts.</p>
            </div>
            <div class="panel">
                <h3>Permanent + seasonal</h3>
                <p>Mix C9 seasons with permanent LED track on the same property when it makes sense — one controller map, one support line.</p>
            </div>
            <div class="panel">
                <h3>ERP-run operations</h3>
                <p>Jobs, inventory, invoices, and takedown windows live in one admin stack so nothing slips between Halloween and New Year.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the LuminaRidge ERP used to schedule crews, track bulbs and controllers, and close seasonal invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>38</strong> Active jobs</div>
                    <div class="metric"><strong>$142k</strong> Pipeline</div>
                    <div class="metric"><strong>22</strong> Design visits</div>
                </div>
                <div class="bars">
                    <span style="height:45%"></span><span style="height:70%"></span><span style="height:55%"></span>
                    <span style="height:85%"></span><span style="height:60%"></span><span style="height:92%"></span>
                    <span style="height:68%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Jobs & install windows</li>
                    <li>Bulbs, clips & controller inventory</li>
                    <li>Invoices & payments</li>
                    <li>AI content + field troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the crew</h2>
        <p class="lede">Guides for homeowners, property managers, and retail tenants across the Front Range.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection