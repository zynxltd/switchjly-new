<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;

class GuideController extends Controller
{
    /** @return array<string, array{title: string, description: string, updated: string, body: list<array{h2: string, p: list<string>}>}> */
    public static function articles(): array
    {
        return [
            'how-to-switch-energy-supplier' => [
                'title' => 'How to switch energy supplier in the UK (2026 guide)',
                'description' => 'A clear step-by-step guide to switching gas and electricity suppliers in the UK — timings, what to check, and how to avoid exit-fee surprises.',
                'updated' => '2026-09-06',
                'body' => [
                    [
                        'h2' => 'Why switch energy supplier?',
                        'p' => [
                            'Switching is one of the simplest ways UK households cut annual energy costs. Comparison sites like Switchly surface live tariffs so you can see savings before you commit.',
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
            'energy-tariffs-explained' => [
                'title' => 'Energy tariffs explained: fixed, variable and tracker',
                'description' => 'Understand fixed, standard variable and tracker energy tariffs in plain English — and which type may suit your household.',
                'updated' => '2026-09-06',
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
            'save-on-energy-bills' => [
                'title' => 'How to save on energy bills without sacrificing comfort',
                'description' => 'Practical ways to lower UK energy bills: smarter switching, usage habits, and what actually moves the needle on annual costs.',
                'updated' => '2026-09-06',
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

    public function index(): View
    {
        return view('guides.index', [
            'guides' => self::articles(),
        ]);
    }

    public function show(string $slug): View|Response
    {
        $guides = self::articles();

        if (! isset($guides[$slug])) {
            abort(404);
        }

        return view('guides.show', [
            'slug' => $slug,
            'guide' => $guides[$slug],
            'related' => collect($guides)->except($slug)->take(2),
        ]);
    }
}
