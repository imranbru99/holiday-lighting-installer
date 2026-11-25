<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! LuminaRidge will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        $img = fn (string $id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=1600&q=80";

        return [
            'roofline-c9' => [
                'title' => 'Roofline C9 & Classic Roofline',
                'summary' => 'Evenly spaced C9 bulbs along eaves, gables, and dormers with professional clips and GFCI power management.',
                'body' => 'LuminaRidge measures every roofline segment, maps outlet locations, and installs commercial-grade C9 strings with shingle-safe clips. We balance warm white, multicolor, or custom palettes so your home reads clearly from the street without overpowering neighbors. Each job includes labeled circuits and a takedown plan.',
                'image' => $img('1543589077-47d81606c1bf'),
            ],
            'permanent-led' => [
                'title' => 'Permanent LED Track Systems',
                'summary' => 'Year-round architectural LED channels with app-controlled scenes for holidays and everyday accent.',
                'body' => 'Permanent track installs hide discreetly under soffits and along roof edges. We specify controller hardware, segment lengths, and waterproof connections for Colorado freeze-thaw cycles. After install you can run classic white, patriotic, or full holiday shows from your phone — no ladders every November.',
                'image' => $img('1512389142860-9c449e58a543'),
            ],
            'commercial-displays' => [
                'title' => 'Commercial & Retail Displays',
                'summary' => 'Walkable storefront trees, pole mounts, and plaza lighting engineered for foot traffic and snow load.',
                'body' => 'From downtown Denver storefronts to Front Range retail centers, we design displays that meet code, survive mountain weather, and photograph well for social campaigns. Our crew handles lift rental coordination, after-hours install windows, and maintenance agreements.',
                'image' => $img('1482514194978-3ed8cc9bc132'),
            ],
            'wreaths-garland' => [
                'title' => 'Wreaths, Garland & Entry Features',
                'summary' => 'Pre-lit wreaths, column wraps, and porch garland with unified timer programming.',
                'body' => 'We size wreaths to doors and windows, wrap columns with commercial garland, and tie every entry feature into the same controller schedule as your roofline. Materials are UV-rated and stored in labeled totes when the season ends.',
                'image' => $img('1576919228236-a097c6a17f44'),
            ],
            'tree-wraps' => [
                'title' => 'Tree & Landscape Wraps',
                'summary' => 'Trunk wraps, canopy net lights, and path accents for yards and HOA common areas.',
                'body' => 'Large cottonwoods and spruce get trunk-first lighting plans that avoid bark damage. We use balanced spacing, low-heat LED, and protected taps so timers stay reliable through wet snow. HOA packages include common-area maps and approval-ready renderings.',
                'image' => $img('1513885535751-8b9238bd345a'),
            ],
            'takedown-storage' => [
                'title' => 'Takedown & Seasonal Storage',
                'summary' => 'January takedown, tested packing, and climate-aware storage with priority reinstall booking.',
                'body' => 'When the season ends, LuminaRidge removes displays carefully, tests each string, and stores gear in our warehouse with your property labeled. Priority customers get first pick of install windows the following year — no tangled attic bins required.',
                'image' => $img('1513201099705-a9746e1e201f'),
            ],
        ];
    }
}