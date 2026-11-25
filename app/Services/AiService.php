<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'cost price linear foot roofline estimate',
            'a' => 'Most residential roofline C9 installs on the Front Range run about $8–$18 per linear foot installed, depending on height, clip type, and controller setup. Permanent LED track is quoted per foot of channel plus hardware. Request a free design visit for an exact measurement.',
        ],
        [
            'q' => 'permanent led app controller scenes',
            'a' => 'LuminaRidge installs permanent LED track with rated controllers and app profiles for holidays, game days, and everyday warm white. We document segment maps so you can add scenes without re-climbing the roof.',
        ],
        [
            'q' => 'c9 roofline bulbs color warm white',
            'a' => 'We offer warm white, cool white, and custom multicolor C9 sets with commercial SPT wiring and shingle-safe clips. Bulbs are LED-rated for long seasons and swapped under our maintenance plan if one segment fails.',
        ],
        [
            'q' => 'takedown storage january packing',
            'a' => 'Our takedown & storage service removes displays after the season, tests strings, labels totes by property, and stores gear in our warehouse. Storage customers get priority booking when installs reopen in fall.',
        ],
        [
            'q' => 'commercial retail plaza tree pole',
            'a' => 'Commercial packages include pole mounts, walkable tree lighting, plaza timers, and after-hours install windows. We coordinate lifts and provide maps for facility managers and photographers.',
        ],
        [
            'q' => 'hoa approval timeline schedule install',
            'a' => 'We provide roofline sketches and color palettes for HOA boards. Typical residential installs book 2–4 weeks out in peak season; early-bird lists open in September for storage clients.',
        ],
        [
            'q' => 'gfci outlet power load breaker',
            'a' => 'Every design maps GFCI outlets, run lengths, and amperage per circuit. We avoid overloaded chains and use outdoor-rated taps — critical when Colorado freeze-thaw trips breakers.',
        ],
        [
            'q' => 'schedule appointment quote contact denver',
            'a' => 'Call or text (303) 555-0194, use the contact form, or WhatsApp 13035550194. Design visits for Denver, Boulder, Colorado Springs, and surrounding Front Range communities are usually available within 2–3 business days.',
        ],
        [
            'q' => 'tree wrap trunk net lights landscape',
            'a' => 'Tree wraps use trunk-first spacing and low-heat LED to protect bark. Large specimens may need net lights or uplighting — we measure circumferences and specify the safest attachment method.',
        ],
        [
            'q' => 'wreath garland porch columns entry',
            'a' => 'Pre-lit wreaths, garland, and column wraps tie into the same timer schedule as your roofline. We size wreaths to doors and bundle entry features for a unified curb appeal.',
        ],
    ];

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for a Denver holiday lighting company about: {$prompt}",
            'description' => "Write a compelling product/service description for holiday lighting installation: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a holiday lighting SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this holiday lighting operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching LuminaRidge Holiday Lighting. We install roofline C9, permanent LED, commercial displays, wreaths, tree wraps, and offer takedown storage across Denver and the Front Range. Ask about pricing per linear foot, controllers, scheduling, or maintenance — or call (303) 555-0194 for a free design visit.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the LuminaRidge Holiday Lighting assistant for a Denver / Colorado Front Range holiday lighting installer. Be concise, practical, and focused on roofline C9, permanent LED, commercial displays, and seasonal storage. Never invent illegal claims.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "You are LuminaRidge Holiday Lighting assistant (Denver holiday lighting). Answer briefly:\n{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}