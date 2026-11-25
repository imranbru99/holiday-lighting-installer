@extends('layouts.app')
@section('title', 'Blog')
@section('meta_description', 'Holiday lighting tips for Denver and the Colorado Front Range — roofline C9, permanent LED, and commercial displays from LuminaRidge.')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Blog</h2>
        <p class="lede">Field notes on roofline installs, controllers, Colorado weather, and commercial display care — written by the LuminaRidge crew.</p>
        <div class="grid-3">
            @foreach($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    @if($post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="" style="width:100%;height:160px;object-fit:cover;margin-bottom:.8rem;border-radius:.25rem;">
                    @endif
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @endforeach
        </div>
        <div style="margin-top:2rem">{{ $posts->links() }}</div>
    </div>
</section>
@endsection