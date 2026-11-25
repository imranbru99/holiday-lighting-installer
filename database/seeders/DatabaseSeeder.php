<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(303) 555-0100',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@luminaridge.com'],
            [
                'name' => 'Avery Chen',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(303) 555-0101',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'crew@luminaridge.com'],
            [
                'name' => 'Jordan Miles',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(303) 555-0102',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'LuminaRidge Holiday Lighting',
            'company_phone' => '(303) 555-0194',
            'company_email' => 'hello@luminaridge.com',
            'whatsapp' => '13035550194',
            'service_area' => 'Denver, Boulder, Colorado Springs & Front Range',
            'tax_rate' => '8.31',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => 'Commercial C9 LED Warm White (25-pack)', 'sku' => 'BULB-C9-WW25', 'category' => 'bulbs', 'unit_cost' => 42, 'unit_price' => 78, 'stock_qty' => 120, 'unit' => 'pack'],
            ['name' => 'C9 LED Multicolor (25-pack)', 'sku' => 'BULB-C9-MC25', 'category' => 'bulbs', 'unit_cost' => 45, 'unit_price' => 82, 'stock_qty' => 96, 'unit' => 'pack'],
            ['name' => 'Shingle-Safe Alligator Clip (100)', 'sku' => 'HW-CLIP-100', 'category' => 'hardware', 'unit_cost' => 28, 'unit_price' => 52, 'stock_qty' => 85, 'unit' => 'box'],
            ['name' => 'Ridge-Line Reacher Pole Kit', 'sku' => 'HW-POLE-RG', 'category' => 'hardware', 'unit_cost' => 95, 'unit_price' => 165, 'stock_qty' => 14, 'unit' => 'kit'],
            ['name' => 'Permanent LED Track 40ft Spool', 'sku' => 'PERM-TRK-40', 'category' => 'permanent', 'unit_cost' => 180, 'unit_price' => 320, 'stock_qty' => 48, 'unit' => 'spool'],
            ['name' => 'Soffit Channel Hidden Track 20ft', 'sku' => 'PERM-CH-20', 'category' => 'permanent', 'unit_cost' => 88, 'unit_price' => 155, 'stock_qty' => 36, 'unit' => 'each'],
            ['name' => 'Smart Scene Controller Hub', 'sku' => 'CTL-HUB-SM', 'category' => 'controller', 'unit_cost' => 65, 'unit_price' => 128, 'stock_qty' => 22, 'unit' => 'each'],
            ['name' => 'Outdoor 4-Channel Timer Pro', 'sku' => 'CTL-TMR-4', 'category' => 'controller', 'unit_cost' => 38, 'unit_price' => 72, 'stock_qty' => 34, 'unit' => 'each'],
            ['name' => 'Pre-Lit Garland 9ft Commercial', 'sku' => 'ACC-GAR-9', 'category' => 'accent', 'unit_cost' => 24, 'unit_price' => 48, 'stock_qty' => 64, 'unit' => 'each'],
            ['name' => '36in Lit Wreath Deluxe', 'sku' => 'ACC-WR-36', 'category' => 'accent', 'unit_cost' => 32, 'unit_price' => 68, 'stock_qty' => 40, 'unit' => 'each'],
            ['name' => 'Outdoor SPT-1 Power Cord 50ft', 'sku' => 'PWR-SPT50', 'category' => 'power', 'unit_cost' => 18, 'unit_price' => 35, 'stock_qty' => 72, 'unit' => 'each'],
            ['name' => 'In-line GFCI Tap Adapter', 'sku' => 'PWR-GFCI-1', 'category' => 'power', 'unit_cost' => 22, 'unit_price' => 42, 'stock_qty' => 55, 'unit' => 'each'],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['is_active' => true]);
        }

        $customers = collect([
            ['name' => 'Micah Sullivan', 'email' => 'micah@example.com', 'phone' => '(303) 555-2201', 'company' => null, 'city' => 'Denver', 'state' => 'CO', 'zip' => '80206', 'address' => '1842 Dahlia St'],
            ['name' => 'Riley Thornton', 'email' => 'riley@peaksretail.com', 'phone' => '(720) 555-2210', 'company' => 'Peaks Retail Plaza', 'city' => 'Boulder', 'state' => 'CO', 'zip' => '80301', 'address' => '900 Pearl St'],
            ['name' => 'Sam Ortega', 'email' => 'ops@frontgatehoa.com', 'phone' => '(303) 555-2299', 'company' => 'FrontGate HOA', 'city' => 'Highlands Ranch', 'state' => 'CO', 'zip' => '80126', 'address' => '4100 RidgeGate Pkwy'],
            ['name' => 'Jordan Ellis', 'email' => 'jordan.ellis@example.com', 'phone' => '(719) 555-2188', 'company' => null, 'city' => 'Colorado Springs', 'state' => 'CO', 'zip' => '80903', 'address' => '55 Nevada Ave'],
            ['name' => 'Morgan Tate', 'email' => 'morgan@milehighbistro.com', 'phone' => '(303) 555-2177', 'company' => 'Mile High Bistro', 'city' => 'Denver', 'state' => 'CO', 'zip' => '80202', 'address' => '2200 Larimer St'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = [
            ['customer' => 0, 'title' => 'Cherry Creek roofline C9', 'service_type' => 'roofline-c9', 'status' => 'scheduled', 'sq_ft' => 186, 'quoted_amount' => 2790],
            ['customer' => 1, 'title' => 'Pearl Street plaza display', 'service_type' => 'commercial-displays', 'status' => 'in_progress', 'sq_ft' => 420, 'quoted_amount' => 16800],
            ['customer' => 2, 'title' => 'HOA entry permanent LED', 'service_type' => 'permanent-led', 'status' => 'quoted', 'sq_ft' => 310, 'quoted_amount' => 12400],
            ['customer' => 3, 'title' => 'Old North End tree wraps', 'service_type' => 'tree-wraps', 'status' => 'completed', 'sq_ft' => 145, 'quoted_amount' => 2175, 'final_amount' => 2250],
            ['customer' => 4, 'title' => 'Larimer storefront + garland', 'service_type' => 'wreaths-garland', 'status' => 'invoiced', 'sq_ft' => 88, 'quoted_amount' => 3520, 'final_amount' => 3480],
            ['customer' => 0, 'title' => 'Post-season takedown & storage', 'service_type' => 'takedown-storage', 'status' => 'quoted', 'sq_ft' => 186, 'quoted_amount' => 465],
        ];

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'JOB-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo job for LuminaRidge ERP — linear feet stored in sq_ft.',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.0831, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * 1.0831, 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * 1.0831, 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'card',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Roofline measure — Sullivan'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'measure',
                'starts_at' => now()->addDays(2)->setTime(10, 0),
                'ends_at' => now()->addDays(2)->setTime(11, 0),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Plaza install night 1'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projectModels[1]->id,
                'type' => 'install',
                'starts_at' => now()->addDays(9)->setTime(18, 0),
                'ends_at' => now()->addDays(9)->setTime(23, 0),
                'status' => 'confirmed',
                'location' => $customers[1]->address,
            ]
        );

        $posts = [
            [
                'title' => 'Why Front Range Rooflines Need Mapped GFCI Circuits',
                'excerpt' => 'Ice, altitude, and long SPT runs make power planning the first step on every LuminaRidge job.',
                'cover' => 'https://images.unsplash.com/photo-1545558014-8692077e9b5c?auto=format&fit=crop&w=1400&q=80',
                'body' => "Denver homeowners often assume any outdoor outlet can feed a full roofline. In practice, long SPT-1 runs, shared kitchen circuits, and tripped GFCIs after freeze-thaw cycles kill whole east-facing strings.\n\nLuminaRidge maps every tap before bulbs go up: outlet location, amperage, run length, and which zones share a timer. That blueprint follows the job into our ERP so January takedown crews reconnect the same way.",
            ],
            [
                'title' => 'Permanent LED vs Seasonal C9: What Colorado Homes Should Mix',
                'excerpt' => 'Track lighting for year-round curb appeal plus C9 for classic holiday punch — when each makes sense.',
                'cover' => 'https://images.unsplash.com/photo-1512389142860-9c449e58a543?auto=format&fit=crop&w=1400&q=80',
                'body' => "Permanent LED under soffits gives you warm architectural light in October and full holiday scenes in December without rental lifts. Seasonal C9 still wins for traditional roofline punch and neighborhoods that expect classic multicolor.\n\nWe often spec permanent LED on rear elevations and high soffits while keeping C9 on the street-facing roofline. One controller map ties both together so timers stay predictable.",
            ],
            [
                'title' => 'Commercial Plaza Timers After Colorado Snow Events',
                'excerpt' => 'Retail displays need reboot plans when wet snow shorts plugs or timers drift.',
                'cover' => 'https://images.unsplash.com/photo-1482514194978-3ed8cc9bc132?auto=format&fit=crop&w=1400&q=80',
                'body' => "Plaza displays run longer hours than residential jobs. After heavy snow, facility teams need a quick checklist: GFCI resets, inline fuse checks, channel reassignment on smart hubs, and photo documentation for corporate.\n\nLuminaRidge commercial contracts include storm-check visits and labeled spares in on-site lockers so employees are not hunting attic stock.",
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = [
            ['category' => 'issues', 'title' => 'Half the roofline went dark', 'body' => "1. Check the GFCI outlet — reset if tripped after moisture.\n2. Walk the SPT run for a blown inline fuse.\n3. Note which timer channel failed and compare to the controller map in ERP.\n4. Swap the first dead bulb in the dark segment — bad bulbs can take down a series string."],
            ['category' => 'issues', 'title' => 'Wind tore clips off west fascia', 'body' => "Front Range chinook winds can peel clips when spacing is too wide. Document damage photos, reinstall with closer clip spacing on the windward side, and add cable cinches at gable transitions."],
            ['category' => 'guides', 'title' => 'Residential install week timeline', 'body' => "Day -7: Design visit + linear-foot measure.\nDay -5: HOA palette approval if required.\nDay 0: Install roofline C9 or permanent segment.\nDay +1: Entry wreaths/garland + timer programming.\nDay +30: Storm-check visit optional.\nJanuary: Takedown & storage route scheduled."],
            ['category' => 'guides', 'title' => 'How to store client light sets', 'body' => "Label totes by property and zone (A/B/C). Test each string before packing. Coil SPT without sharp bends. Record counts in ERP inventory so reinstall pulls match last season."],
            ['category' => 'admin', 'title' => 'Admin ERP quick start', 'body' => "Login at /admin with admin@example.com / password.\n1. Add customers in CRM.\n2. Create a Job/Project with service type and linear feet.\n3. Schedule appointments for measure/install.\n4. Convert completed jobs to invoices and record payments.\n5. Use AI Studio for blog drafts and troubleshooting suggestions.\n6. Update company Settings for phone, WhatsApp, and tax rate."],
            ['category' => 'admin', 'title' => 'Roles: Admin, Manager, Staff', 'body' => "Admin: full ERP + settings + users.\nManager: jobs, inventory, invoices, scheduling.\nStaff: field-facing records and appointment updates.\nAssign roles on the Users resource."],
            ['category' => 'troubleshoot', 'title' => 'Job running over material estimate', 'body' => "Compare quoted linear feet to field measure. Log extra clips, cords, or bulbs on job notes, add a change-order invoice line, and decrement inventory SKUs."],
            ['category' => 'troubleshoot', 'title' => 'Chatbot giving demo answers only', 'body' => "Demo mode is expected without API keys. Add OPENAI_API_KEY or GEMINI_API_KEY to .env, then clear config cache. The public chatbot and AI Studio will prefer live models when keys are present."],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}