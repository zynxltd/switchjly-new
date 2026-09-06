<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Guide;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->guides() as $index => $guide) {
            Guide::query()->updateOrCreate(
                ['slug' => $guide['slug']],
                [
                    ...$guide,
                    'is_published' => true,
                    'sort_order' => $index,
                    'published_at' => now(),
                ],
            );
        }

        foreach ($this->faqs() as $index => $faq) {
            Faq::query()->updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'is_published' => true,
                    'sort_order' => $index,
                ],
            );
        }

        foreach ($this->testimonials() as $index => $item) {
            Testimonial::query()->updateOrCreate(
                ['name' => $item['name'], 'quote' => $item['quote']],
                [
                    ...$item,
                    'is_published' => true,
                    'sort_order' => $index,
                ],
            );
        }

        $settings = [
            'promo_enabled' => '1',
            'promo_label' => 'Free comparison:',
            'promo_message' => 'Check today’s UK energy deals and see what you could save —',
            'promo_cta' => 'Compare now',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::setValue($key, $value);
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function guides(): array
    {
        return [
            [
                'slug' => 'how-to-switch-energy-supplier',
                'title' => 'How to switch energy supplier in the UK (2026 guide)',
                'description' => 'A clear step-by-step guide to switching gas and electricity suppliers in the UK — timings, what to check, and how to avoid exit-fee surprises.',
                'body' => [
                    [
                        'h2' => 'Why switch energy supplier?',
                        'p' => [
                            'Switching is one of the simplest ways UK households cut annual energy costs. Comparison sites like Brillia surface live tariffs so you can see savings before you commit.',
                            'Your supply is not interrupted during a switch. The new supplier coordinates the changeover — typically around five working days for a straightforward dual-fuel switch.',
                        ],
                    ],
                    [
                        'h2' => 'What you need before you compare',
                        'p' => [
                            'Have your postcode, current supplier, and either a recent bill or a rough annual usage (kWh) ready. An estimate is fine if you do not have exact figures.',
                            'Also note how you pay (Direct Debit, prepayment, or on receipt) — payment method affects the deals you are shown.',
                        ],
                    ],
                    [
                        'h2' => 'Steps to switch',
                        'p' => [
                            '1. Compare deals using your details. 2. Check fixed vs variable rates, exit fees, and contract length. 3. Choose a tariff and follow the supplier’s switch flow. 4. Keep confirmation emails for your records.',
                            'If you are still in a fixed contract, check exit fees before switching — sometimes waiting until the fixed term ends saves more overall.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'energy-tariffs-explained',
                'title' => 'Energy tariffs explained: fixed, variable and tracker',
                'description' => 'Understand fixed, standard variable and tracker energy tariffs in plain English — and which type may suit your household.',
                'body' => [
                    [
                        'h2' => 'Fixed tariffs',
                        'p' => [
                            'Fixed tariffs lock your unit rates (and often standing charges) for a set period, commonly 12 months. They protect you if prices rise, but you may miss cheaper deals if the market falls.',
                            'Always check exit fees and whether the “fixed” price includes standing charges.',
                        ],
                    ],
                    [
                        'h2' => 'Standard variable tariffs (SVT)',
                        'p' => [
                            'SVTs can change with the market and supplier pricing. Many households end up on an SVT when a fixed deal ends. They are flexible but often more expensive than a competitive fixed deal.',
                        ],
                    ],
                    [
                        'h2' => 'Tracker tariffs',
                        'p' => [
                            'Trackers follow a published index or wholesale benchmark. Rates move up and down under defined rules. They can be cheaper in falling markets but need more attention than a simple fixed deal.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'save-on-energy-bills',
                'title' => 'How to save on energy bills without sacrificing comfort',
                'description' => 'Practical ways to lower UK energy bills: smarter switching, usage habits, and what actually moves the needle on annual costs.',
                'body' => [
                    [
                        'h2' => 'Start with a better tariff',
                        'p' => [
                            'The biggest saving for many homes is simply not overpaying for the same energy. Comparing dual-fuel and electricity-only deals once or twice a year keeps you off expensive default tariffs.',
                        ],
                    ],
                    [
                        'h2' => 'Usage habits that help',
                        'p' => [
                            'Lowering the thermostat by 1°C, washing at 30°C, and turning off standby devices add up — but they work best alongside a competitive unit rate.',
                            'If you have a smart meter, review half-hourly or daily usage patterns to spot peaks you can shift.',
                        ],
                    ],
                    [
                        'h2' => 'When to compare again',
                        'p' => [
                            'Recompare when your fixed deal ends, when you move home, or when your usage changes significantly (for example, working from home or installing a heat pump / EV charger).',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return list<array{question: string, answer: string}>
     */
    protected function faqs(): array
    {
        return [
            [
                'question' => 'How does Brillia work?',
                'answer' => 'Enter a few details about your home and current tariff. We compare live deals from leading UK suppliers and show what you could save — usually in under a minute.',
            ],
            [
                'question' => 'Is Brillia really free?',
                'answer' => 'Yes — 100% free. We never charge you to compare or switch. There are no hidden fees.',
            ],
            [
                'question' => 'Will I have to switch supplier?',
                'answer' => 'Only if you choose to. We show your options clearly so you can stick with your current deal or switch when you’re ready — no pressure.',
            ],
            [
                'question' => 'How does Brillia make money?',
                'answer' => 'If you switch, we may earn a commission from the supplier. It never affects the price you pay.',
            ],
            [
                'question' => 'Is my data safe with Brillia?',
                'answer' => 'Yes. We only use your details to find matching deals and never sell your data. Your information is encrypted and handled securely.',
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function testimonials(): array
    {
        return [
            ['quote' => 'Switched in 5 minutes and saved £276 a year!', 'name' => 'Sarah T.', 'place' => 'Manchester', 'avatar' => 'sarah', 'rating' => 5],
            ['quote' => "Finally, a comparison site that's simple and actually shows the best deals.", 'name' => 'James L.', 'place' => 'Bristol', 'avatar' => 'james', 'rating' => 5],
            ['quote' => 'Great experience from start to finish. Lower bills, happy days!', 'name' => 'Emily R.', 'place' => 'Leeds', 'avatar' => 'emily', 'rating' => 5],
            ['quote' => 'Clear deals, no jargon. I finally understand my tariff.', 'name' => 'Priya N.', 'place' => 'London', 'avatar' => 'sarah', 'rating' => 5],
            ['quote' => 'Saved over £300 and the whole process was painless.', 'name' => 'Tom H.', 'place' => 'Birmingham', 'avatar' => 'james', 'rating' => 5],
        ];
    }
}
