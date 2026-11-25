<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LuminaRidge Holiday Lighting') — Denver & Front Range</title>
    <meta name="description" content="@yield('meta_description', 'LuminaRidge Holiday Lighting designs, installs, and stores premium roofline C9, permanent LED, and commercial displays across Denver and the Colorado Front Range.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #08111f;
            --gold: #d4a017;
            --gold-deep: #b8880f;
            --teal: #2a9b9f;
            --teal-deep: #1f7a7d;
            --mist: #8fa4b8;
            --surface: #eef2f6;
            --panel: #f6f8fb;
            --white: #ffffff;
            --font-display: "Syne", sans-serif;
            --font-body: "Karla", sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--ink);
            background:
                radial-gradient(1100px 520px at 88% -8%, rgba(212,160,23,.16), transparent 52%),
                radial-gradient(800px 480px at -5% 25%, rgba(42,155,159,.14), transparent 48%),
                linear-gradient(180deg, #f9fafc 0%, var(--surface) 42%, #dde5ee 100%);
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin-inline: auto; }
        .site-header {
            position: sticky; top: 0; z-index: 40;
            backdrop-filter: blur(14px);
            background: rgba(8,17,31,.9);
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: .95rem 0; gap: 1rem;
        }
        .brand {
            font-family: var(--font-display);
            letter-spacing: .02em;
            font-size: 1.28rem;
            color: #fff;
        }
        .brand span { color: var(--gold); }
        .nav-links { display: flex; flex-wrap: wrap; gap: .9rem 1.1rem; align-items: center; }
        .nav-links a { color: rgba(255,255,255,.84); font-size: .92rem; font-weight: 500; }
        .nav-links a:hover { color: #fff; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: .4rem; padding: .75rem 1.25rem; border-radius: .4rem;
            font-weight: 700; border: 0; cursor: pointer;
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
            font-family: var(--font-body);
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: var(--gold); color: var(--ink); box-shadow: 0 10px 26px rgba(212,160,23,.32); }
        .btn-primary:hover { background: var(--gold-deep); color: #fff; }
        .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.3); }
        .btn-dark { background: var(--ink); color: #fff; }
        .hero {
            min-height: calc(100vh - 66px);
            display: grid;
            align-items: end;
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                linear-gradient(108deg, rgba(8,17,31,.92) 0%, rgba(8,17,31,.5) 50%, rgba(8,17,31,.2) 100%),
                url('https://images.unsplash.com/photo-1467810563316-b5476525c0f9?auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
        }
        .hero-inner { padding: 5.5rem 0 4rem; max-width: 660px; animation: rise .85s ease both; }
        .hero h1 {
            font-family: var(--font-display);
            font-size: clamp(2.5rem, 6.5vw, 4.2rem);
            line-height: 1.02;
            margin: 0 0 1rem;
            letter-spacing: -.02em;
        }
        .hero p { font-size: 1.1rem; line-height: 1.65; color: rgba(255,255,255,.9); margin: 0 0 1.5rem; max-width: 36rem; }
        .hero-ctas { display: flex; flex-wrap: wrap; gap: .75rem; }
        .section { padding: 4.5rem 0; }
        .section h2 {
            font-family: var(--font-display);
            font-size: clamp(1.85rem, 4vw, 2.65rem);
            letter-spacing: -.02em;
            margin: 0 0 .75rem;
        }
        .lede { color: var(--mist); max-width: 42rem; line-height: 1.65; margin: 0 0 2rem; }
        .grid-3 { display: grid; gap: 1.25rem; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-2 { display: grid; gap: 1.5rem; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .service-tile {
            position: relative; overflow: hidden; min-height: 260px; color: #fff;
            border-radius: .35rem;
            isolation: isolate;
        }
        .service-tile img {
            position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2;
            transition: transform .6s ease;
        }
        .service-tile:hover img { transform: scale(1.05); }
        .service-tile::after {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background: linear-gradient(180deg, rgba(8,17,31,.12), rgba(8,17,31,.9));
        }
        .service-tile .pad { position: absolute; left: 0; right: 0; bottom: 0; padding: 1.25rem; }
        .service-tile h3 { margin: 0 0 .35rem; font-family: var(--font-display); font-size: 1.15rem; }
        .service-tile p { margin: 0; color: rgba(255,255,255,.88); font-size: .92rem; }
        .panel {
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(8,17,31,.06);
            border-radius: .35rem;
            padding: 1.4rem;
        }
        .panel h3 { margin: 0 0 .5rem; font-family: var(--font-display); }
        .dash-preview {
            display: grid; gap: 1rem; grid-template-columns: 1.2fr .8fr;
            background: var(--ink); color: #fff; padding: 1.5rem; border-radius: .35rem; overflow: hidden;
        }
        .metric { padding: 1rem; background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08); border-radius: .25rem; }
        .metric strong { display: block; font-size: 1.65rem; color: var(--gold); font-family: var(--font-display); }
        .bars { display: flex; align-items: end; gap: .45rem; height: 140px; margin-top: 1rem; }
        .bars span {
            flex: 1; border-radius: 3px 3px 0 0;
            background: linear-gradient(180deg, var(--gold), var(--teal));
            animation: grow .9s ease both;
        }
        form.stack { display: grid; gap: .85rem; }
        label { font-weight: 600; font-size: .9rem; }
        input, textarea, select {
            width: 100%; padding: .8rem .9rem; border: 1px solid rgba(8,17,31,.12);
            background: #fff; font: inherit; border-radius: .3rem;
        }
        .flash {
            background: rgba(42,155,159,.12); border: 1px solid rgba(42,155,159,.35);
            color: #146569; padding: .9rem 1rem; margin-bottom: 1rem; border-radius: .3rem;
        }
        .site-footer {
            background: var(--ink); color: rgba(255,255,255,.8); padding: 2.5rem 0;
            margin-top: 2rem;
        }
        .site-footer .brand { margin-bottom: .5rem; }
        .wa-float {
            position: fixed; right: 1.1rem; bottom: 1.1rem; z-index: 50;
            width: 56px; height: 56px; border-radius: 999px;
            display: grid; place-items: center;
            background: #25d366; color: #fff; font-weight: 800; font-size: .85rem;
            box-shadow: 0 12px 28px rgba(0,0,0,.28);
            animation: pulse 2.4s ease infinite;
        }
        .chat-widget {
            position: fixed; left: 1.1rem; bottom: 1.1rem; z-index: 50; width: min(360px, calc(100vw - 2rem));
        }
        .chat-toggle {
            background: var(--ink); color: #fff; border: 0; padding: .8rem 1rem;
            font-weight: 700; cursor: pointer; width: 100%; border-radius: .35rem .35rem 0 0;
        }
        .chat-panel {
            display: none; background: #fff; border: 1px solid rgba(8,17,31,.1);
            box-shadow: 0 18px 40px rgba(8,17,31,.2); overflow: hidden; border-radius: .35rem .35rem 0 0;
        }
        .chat-panel.open { display: block; animation: rise .25s ease; }
        .chat-log { height: 240px; overflow: auto; padding: .9rem; background: var(--panel); }
        .bubble { margin: .4rem 0; padding: .65rem .75rem; border-radius: .4rem; max-width: 90%; font-size: .9rem; line-height: 1.45; }
        .bubble.bot { background: #fff; border: 1px solid rgba(8,17,31,.08); }
        .bubble.user { background: var(--ink); color: #fff; margin-left: auto; }
        .chat-form { display: flex; gap: .4rem; padding: .65rem; }
        .chat-form input { flex: 1; }
        @keyframes rise { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleY(.2); transform-origin: bottom; } to { transform: scaleY(1); } }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @media (max-width: 900px) {
            .grid-3, .grid-2, .dash-preview { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .hero { min-height: 78vh; }
        }
    </style>
    @stack('head')
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">Lumina<span>Ridge</span></a>
        <nav class="nav-links">
            <a href="{{ route('services') }}">Services</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('knowledge') }}">Knowledge</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a class="btn btn-primary" href="{{ route('contact') }}">Free Estimate</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="wrap">
        <div class="brand">Lumina<span>Ridge</span> Holiday Lighting</div>
        <p>Denver · Boulder · Colorado Springs · Front Range holiday lighting install, permanent LED, and seasonal storage.</p>
        <p style="margin-top:1rem;font-size:.9rem;">(303) 555-0194 · hello@luminaridge.com · <a href="/admin" style="color:var(--gold)">Admin ERP</a></p>
    </div>
</footer>

<a class="wa-float" href="https://wa.me/13035550194" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>

<div class="chat-widget" id="lr-chat">
    <div class="chat-panel" id="chat-panel">
        <div class="chat-log" id="chat-log">
            <div class="bubble bot">Hi — ask LuminaRidge about roofline C9 installs, permanent LED, pricing per linear foot, or scheduling a Front Range site visit.</div>
        </div>
        <form class="chat-form" id="chat-form">
            <input type="text" id="chat-input" placeholder="Ask about holiday lighting…" required maxlength="2000">
            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
    <button class="chat-toggle" type="button" id="chat-toggle">AI Lighting Assistant</button>
</div>

<script>
(() => {
    const panel = document.getElementById('chat-panel');
    const toggle = document.getElementById('chat-toggle');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const log = document.getElementById('chat-log');
    const sessionId = 'lr-' + Math.random().toString(36).slice(2);
    toggle.addEventListener('click', () => panel.classList.toggle('open'));
    const add = (text, who) => {
        const el = document.createElement('div');
        el.className = 'bubble ' + who;
        el.textContent = text;
        log.appendChild(el);
        log.scrollTop = log.scrollHeight;
    };
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        add(message, 'user');
        input.value = '';
        try {
            const res = await fetch(@json(route('ai.chat')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message, session_id: sessionId }),
            });
            const data = await res.json();
            add(data.reply || 'Something went wrong.', 'bot');
        } catch (err) {
            add('Network error — please try again or call (303) 555-0194.', 'bot');
        }
    });
})();
</script>
@stack('scripts')
</body>
</html>