<?php

namespace App\Support;

class GuideArticles
{
    /**
     * @return array<string, array{
     *     title: string,
     *     description: string,
     *     published: string,
     *     updated: string,
     *     body: list<array{h2: string, p?: list<string>, ul?: list<string>}>,
     *     faqs: list<array{q: string, a: string}>
     * }>
     */
    public static function all(): array
    {
        $compare = e(route('compare.details'));
        $how = e(route('how-it-works'));
        $guides = e(route('guides.index'));
        $contact = e(route('contact'));
        $home = e(route('home'));
        $tariffs = e(route('guides.show', 'energy-tariffs-explained'));
        $switch = e(route('guides.show', 'how-to-switch-energy-supplier'));
        $save = e(route('guides.show', 'save-on-energy-bills'));
        $faqs = e(url('/#faqs'));
        $product = e(config('company.product_name'));
        $brand = e(config('company.trading_name'));
        $legal = e(config('company.legal_name'));

        return [
            'how-to-switch-energy-supplier' => [
                'title' => 'How to switch energy supplier in the UK (2026 guide)',
                'description' => 'A practical 2026 guide to switching UK gas and electricity: what you need, how long it takes, exit fees, and how to compare deals safely with Brillia.',
                'published' => '2026-09-06',
                'updated' => '2026-09-06',
                'body' => [
                    [
                        'h2' => 'Why switching still matters in 2026',
                        'p' => [
                            'For most UK households, the quickest way to cut an energy bill is not a new boiler or a lifestyle overhaul — it is stopping an overpriced default tariff. When a fixed deal ends, many people roll onto a standard variable tariff (SVT) that costs more than a competitive fixed or tracker deal available the same week.',
                            "{$product} exists to make that check simple. We are a free comparison service operated by {$legal} trading as {$brand}. We do not supply gas or electricity ourselves. When you switch, you contract with a licensed UK supplier regulated by Ofgem. That distinction matters for trust: we help you compare; the supplier handles your meter, billing and supply.",
                            'Switching should not interrupt your gas or electricity. The change is largely administrative. Industry processes typically complete a straightforward dual-fuel switch in around five working days, though timings can vary if there are meter issues, debt flags or incomplete details.',
                            "This guide walks through what to prepare, how to compare fairly, what to check before you click apply, and what happens after you choose a deal. For a shorter overview of our funnel, see <a href=\"{$how}\">how Brillia works</a>. When you are ready, you can <a href=\"{$compare}\">compare live deals</a> with your postcode in under a minute.",
                        ],
                    ],
                    [
                        'h2' => 'What you need before you compare',
                        'p' => [
                            'You do not need a perfect spreadsheet of usage. An estimate is enough to start, and you can refine later. The more accurate your inputs, the more useful the estimated annual cost and savings figures will be.',
                        ],
                        'ul' => [
                            'Your postcode — regional network charges mean deals vary by area.',
                            'Current supplier name and, if you know it, your tariff name.',
                            'How you pay: Monthly Direct Debit, prepayment, or pay on receipt.',
                            'Fuel type: dual fuel, electricity only, or gas only.',
                            'Annual usage in kWh if you have a bill; otherwise a typical-home estimate is fine.',
                            'Whether you are in a fixed term and any exit fee that might apply.',
                        ],
                        'p_after' => [
                            "If you are unsure about usage, many dual-fuel homes sit roughly in the low thousands of kWh for electricity and around the mid–high thousands for gas each year, but your bill is always better than a national average. Our <a href=\"{$faqs}\">FAQs</a> cover common questions about data and switching.",
                        ],
                    ],
                    [
                        'h2' => 'Step-by-step: how to switch with Brillia',
                        'p' => [
                            "<strong>1. Start with your postcode.</strong> Enter it on the homepage or the <a href=\"{$compare}\">compare</a> flow. This filters tariffs that are available for your region.",
                            '<strong>2. Confirm supplier, tariff and payment method.</strong> Matching how you actually pay matters — the cheapest Direct Debit deal is not useful if you are on a prepayment meter.',
                            '<strong>3. Add usage and fuel type.</strong> Dual fuel is common, but you can compare electricity-only or gas-only if that matches your situation.',
                            '<strong>4. Review results by estimated annual cost.</strong> On the deals page, sort by cheapest (lowest estimated annual cost), biggest saving, top rated or green. Cards show estimated annual cost plus potential savings versus your current setup — estimates, not guarantees.',
                            '<strong>5. Open a deal and complete the short application.</strong> After View Deal you will see a short handoff, then a form to confirm details. The licensed supplier then progresses the switch.',
                            '<strong>6. Keep confirmations.</strong> Save emails from Brillia and the supplier. Note any cooling-off period on the supplier’s terms (often around 14 days).',
                        ],
                    ],
                    [
                        'h2' => 'Fixed, variable or tracker — pick with eyes open',
                        'p' => [
                            'Tariff type changes how much risk and flexibility you take. Fixed deals lock unit rates for a set period (often 12 months) and can include exit fees if you leave early. SVTs can move when the supplier updates prices. Trackers follow a published index or formula.',
                            "We explain the trade-offs in depth in <a href=\"{$tariffs}\">Energy tariffs explained: fixed, variable and tracker</a>. In short: if you want bill certainty for a year, start with competitive fixed deals that match your payment method. If you are near the end of a fixed term, compare before you roll onto an SVT.",
                            'Green electricity options are available on many deals. Use the green filter on results if renewable electricity is a priority, then read the deal details for what is included.',
                        ],
                    ],
                    [
                        'h2' => 'Exit fees, debt and other blockers',
                        'p' => [
                            'Exit fees on fixed contracts can wipe out a paper saving if you leave mid-term. Always weigh the remaining months of your current deal against the saving on a new one. Sometimes waiting until the fixed term ends is cheaper overall.',
                            'If you owe your current supplier, switching may still be possible, but debt rules can apply — especially on prepayment. Clear or discuss arrears if a switch is blocked. Comparing on Brillia does not run a credit check; some suppliers may check credit when you apply.',
                            'Tenants can usually switch if they are responsible for the bills — check your tenancy. The person named on the application should match who pays. If you are moving house, tell both suppliers your move date and compare using the new postcode once you have it.',
                        ],
                    ],
                    [
                        'h2' => 'What happens after you pick a deal',
                        'p' => [
                            'Your new supplier coordinates the switch. Supply should continue as normal. You may receive welcome packs, Direct Debit setup details, and a start date. Final bills from your old supplier usually follow once meter readings or smart data are settled.',
                            "If you change your mind during cooling-off, contact the new supplier promptly. For help choosing between deals or understanding a quote, use <a href=\"{$contact}\">Contact</a> — our UK team usually replies within one working day.",
                            "Want lower bills beyond the switch itself? Pair a better tariff with practical usage tips in <a href=\"{$save}\">How to save on energy bills without sacrificing comfort</a>.",
                        ],
                    ],
                    [
                        'h2' => 'How Brillia makes money (and what that means for you)',
                        'p' => [
                            "{$product} is free to use. If you switch, we may earn a commission from the supplier. That never changes the price you pay for the tariff shown. We do not sell your personal data. Details are used to find deals and, if you choose, to complete a switch application.",
                            "Browse more advice on our <a href=\"{$guides}\">guides hub</a>, or start from the <a href=\"{$home}\">homepage</a> when you are ready to compare.",
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'q' => 'Will my power or gas stop during a switch?',
                        'a' => 'No. A switch is an administrative change between licensed suppliers. Your supply should continue as normal while the switch completes.',
                    ],
                    [
                        'q' => 'How long does a UK energy switch take?',
                        'a' => 'Comparing usually takes under a minute. Most straightforward switches complete in about five working days, though complex cases can take longer.',
                    ],
                    [
                        'q' => 'Do I have to switch after comparing?',
                        'a' => 'No. You can compare freely and stay with your current supplier if nothing looks better.',
                    ],
                    [
                        'q' => 'Is Brillia an energy supplier?',
                        'a' => 'No. Brillia Energy is a free comparison service. When you switch, you sign up with a licensed UK supplier.',
                    ],
                ],
            ],

            'energy-tariffs-explained' => [
                'title' => 'Energy tariffs explained: fixed, variable and tracker',
                'description' => 'Plain-English guide to UK fixed, standard variable (SVT) and tracker energy tariffs — standing charges, unit rates, exit fees, and how to choose with Brillia.',
                'published' => '2026-09-06',
                'updated' => '2026-09-06',
                'body' => [
                    [
                        'h2' => 'The building blocks of every energy bill',
                        'p' => [
                            'Before comparing tariff types, it helps to know what you are paying for. Most UK domestic bills combine a daily standing charge and a unit rate charged in pence per kilowatt-hour (p/kWh). Standing charges cover fixed costs of keeping you connected; unit rates cover the energy you use.',
                            "That is why the lowest unit rate is not always the cheapest deal for your home. High standing charges can outweigh a headline unit price, especially for lower-usage households. When you <a href=\"{$compare}\">compare on Brillia</a>, we estimate annual cost from the details you enter so you can rank deals by what you are likely to pay overall — not just one line of marketing copy.",
                            "{$product} is a free comparison site from {$legal} (trading as {$brand}). We are not a supplier. Licensed suppliers are regulated by Ofgem. Understanding tariff structures helps you ask better questions and avoid rolling onto an expensive default when a fixed deal ends.",
                        ],
                    ],
                    [
                        'h2' => 'Fixed tariffs: certainty for a set period',
                        'p' => [
                            'A fixed tariff locks your unit rates (and often the standing charge terms) for a defined period — commonly 12 months. Households choose fixed deals when they want predictable bills and protection if wholesale prices rise.',
                            'The trade-off is flexibility. If the market falls, you may sit on a rate that is no longer competitive until the term ends. Many fixed deals charge an exit fee if you leave early. Always check the fee amount and remaining months before switching mid-contract.',
                            'Fixed does not always mean every line on the bill is frozen forever — read whether standing charges are fixed, and whether there are conditions such as Direct Debit or paperless billing. Deal cards and full details on Brillia surface the key terms so you can compare like for like.',
                            "If you are actively mid-switch or preparing to leave a fixed deal, our step-by-step <a href=\"{$switch}\">how to switch energy supplier</a> guide covers timings, documents and cooling-off.",
                        ],
                    ],
                    [
                        'h2' => 'Standard variable tariffs (SVT)',
                        'p' => [
                            'An SVT can change when the supplier updates prices. Many customers land on an SVT automatically when a fixed deal expires. SVTs are flexible — often easier to leave without an exit fee — but they are frequently more expensive than a carefully chosen fixed deal at the same moment in time.',
                            'Treat an SVT as a holding pattern, not a long-term plan, unless you have a specific reason to stay flexible. Set a reminder near the end of any fixed term and recompare before the roll-over date. That single habit saves many households more than tweaking thermostat settings alone.',
                            'Payment method still matters on SVTs. Monthly Direct Debit usually unlocks the most competitive pricing. Prepayment and pay-on-receipt options exist but can cost more. Match the deal to how you actually pay.',
                        ],
                    ],
                    [
                        'h2' => 'Tracker and index-linked tariffs',
                        'p' => [
                            'Tracker tariffs follow a published index, wholesale benchmark or formula. Prices can move up or down under defined rules. They can look attractive in falling markets, but they need more attention than a simple fixed deal.',
                            'Before choosing a tracker, read how often it updates, whether there are caps or floors, and what fees apply. If you prefer set-and-forget budgeting, a competitive fixed tariff is usually simpler. If you are comfortable monitoring the market, a transparent tracker can be part of a deliberate strategy.',
                            'Time-of-use, Economy 7 and EV tariffs are related but different: they price energy cheaper at certain times of day. They work best if you can shift usage (overnight charging, delayed appliances). Confirm your meter type before switching to one.',
                        ],
                    ],
                    [
                        'h2' => 'Green tariffs and what “100% renewable” means',
                        'p' => [
                            'Many deals offer 100% renewable electricity, sometimes with green gas options. Marketing language varies. Use Brillia’s green energy filter on results, then read the deal details for what is included and any certification claims the supplier makes.',
                            'Green pricing is not automatically more expensive than brown power on every deal — compare estimated annual cost the same way you would for any other tariff. If sustainability is a priority, filter first, then sort by cost so you are not paying a large premium for a similar product.',
                        ],
                    ],
                    [
                        'h2' => 'Dual fuel vs single fuel',
                        'p' => [
                            'Dual fuel means gas and electricity with one supplier — often simpler paperwork and one Direct Debit. Electricity-only or gas-only comparisons make sense if you heat with electricity only, use communal heating, or have a separate arrangement for one fuel.',
                            'When you compare on Brillia, pick the fuel type that matches what you intend to switch. Mixing assumptions (for example, entering dual-fuel usage but only planning to move electricity) will distort estimated savings.',
                        ],
                    ],
                    [
                        'h2' => 'Standing charges, unit rates and “cheapest” claims',
                        'p' => [
                            'Marketing often highlights a low unit rate. For low-usage homes, standing charges can dominate. For high-usage homes, unit rates matter more. Estimated annual cost folds both together for the usage you enter.',
                            'Exit fees, warm-home discounts eligibility, and payment method premiums can still change the real-world outcome. Treat comparison results as a shortlist, then read the deal page before you apply.',
                            "Ofgem licensing means suppliers must follow industry rules, but products still differ. If something looks too good to be true, check the term length, exit fee and payment requirements — or <a href=\"{$contact}\">ask us</a> before you proceed.",
                        ],
                    ],
                    [
                        'h2' => 'How to choose a tariff type in practice',
                        'p' => [
                            'Start with how you pay and your risk tolerance. Want certainty for a year? Shortlist fixed deals with acceptable exit fees. Coming off a fixed soon? Compare before SVT roll-over. Happy to watch the market? Consider trackers with clear rules.',
                            "Then look at estimated annual cost for your usage, not just unit rates. Check standing charges, exit fees, contract length and any smart-meter requirements. Our deals results let you sort by cheapest, biggest saving, top rated or green — see <a href=\"{$how}\">how Brillia works</a> for the full flow.",
                            "For habits that reduce kWh after you have a better tariff, read <a href=\"{$save}\">how to save on energy bills</a>. More guides live on the <a href=\"{$guides}\">guides</a> page, and you can always <a href=\"{$contact}\">contact us</a> with a specific tariff question.",
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'q' => 'Is a fixed energy tariff always cheaper?',
                        'a' => 'Not always. Fixed deals often beat an expensive SVT, but you should compare estimated annual cost for your usage and check exit fees before leaving a fixed early.',
                    ],
                    [
                        'q' => 'What is an SVT?',
                        'a' => 'A standard variable tariff can change when the supplier updates prices. Many people move onto an SVT when a fixed deal ends.',
                    ],
                    [
                        'q' => 'Do tracker tariffs have exit fees?',
                        'a' => 'It depends on the product. Always read the deal terms for fees, update frequency and any caps before you switch.',
                    ],
                    [
                        'q' => 'Should I only look at the unit rate?',
                        'a' => 'No. Standing charges, exit fees and your usage profile all affect what you pay. Estimated annual cost is a better comparison starting point.',
                    ],
                ],
            ],

            'save-on-energy-bills' => [
                'title' => 'How to save on energy bills without sacrificing comfort',
                'description' => 'Practical UK ways to cut energy bills in 2026: better tariffs, heating habits, smart meters, and when to recompare with Brillia — without freezing at home.',
                'published' => '2026-09-06',
                'updated' => '2026-09-06',
                'body' => [
                    [
                        'h2' => 'Comfort first: savings that do not mean cold rooms',
                        'p' => [
                            'Cutting energy costs should not mean sitting in a coat indoors. The biggest lever for most UK homes is still the unit price and standing charge you pay — then habits that reduce waste without removing comfort. This guide prioritises high-impact steps first.',
                            "{$product} helps with the tariff side: free comparison of live UK deals, operated by {$legal} trading as {$brand}. We are not your supplier. Once you are on a competitive rate, small usage changes compound. Start by <a href=\"{$compare}\">comparing deals for your postcode</a>, then use the habits below.",
                        ],
                    ],
                    [
                        'h2' => '1. Stop overpaying for the same kilowatt-hours',
                        'p' => [
                            'If you are on an expired fixed deal or an uncompetitive SVT, you may be paying more for identical gas and electricity. Switching or re-signing to a better tariff often saves more than a month of careful thermostat tweaks.',
                            "Use Brillia to rank by estimated annual cost, check fixed versus variable terms, and watch exit fees if you are mid-contract. Our <a href=\"{$tariffs}\">tariffs explained</a> guide covers fixed, SVT and tracker products. The <a href=\"{$switch}\">switching guide</a> covers the process end to end.",
                            'Recompare when your fixed ends, when you move, when you install a heat pump or EV charger, or when your household usage changes (for example, more home working). A twice-yearly check is a healthy default.',
                        ],
                    ],
                    [
                        'h2' => '2. Heat smarter, not colder',
                        'p' => [
                            'Heating dominates many winter bills. Lowering the thermostat by about 1°C can reduce consumption meaningfully, but comfort matters — focus on zoning and timing rather than heroic cold.',
                        ],
                        'ul' => [
                            'Heat the rooms you use; close doors to unused spaces where practical.',
                            'Use thermostatic radiator valves (TRVs) to avoid cooking empty rooms.',
                            'Bleed radiators and keep boiler pressure in the recommended range.',
                            'Draw curtains at dusk; avoid blocking radiators with furniture.',
                            'If you have a programmer or smart thermostat, schedule heating around real occupancy — not all-day defaults.',
                        ],
                        'p_after' => [
                            'Insulation upgrades (loft, draught-proofing, hot-water cylinder jackets) are comfort-positive: warmer rooms for the same boiler output. They are longer projects than a tariff switch, but they stack well with a competitive unit rate.',
                        ],
                    ],
                    [
                        'h2' => '3. Electricity habits that add up',
                        'p' => [
                            'Wash at 30°C when suitable, run full loads, and use eco cycles. Air-dry when you can. Switch devices off standby if they draw continuous power. LED lighting remains one of the easiest swaps.',
                            'If you are on Economy 7, an EV tariff or another time-of-use product, shift flexible loads (dishwasher, washing machine, EV charging) into cheaper windows. Wrong meter or wrong habits can erase the point of those tariffs.',
                            'Cooking and gadgets matter less than heating for most homes, but they are still worth a pass — especially for flats where electricity is a larger share of the bill.',
                        ],
                    ],
                    [
                        'h2' => '4. Use your smart meter as a feedback tool',
                        'p' => [
                            'A smart meter is not a tariff by itself, but in-home displays and supplier apps can show daily or half-hourly patterns. Look for peaks you can shift and for overnight baseload that suggests always-on devices.',
                            'Some tariffs require a smart meter. If a deal needs one, it usually says so in the details — your new supplier can often arrange installation. Comparing on Brillia does not require a smart meter up front.',
                        ],
                    ],
                    [
                        'h2' => '5. Support schemes and vulnerable customers',
                        'p' => [
                            'Schemes such as the Warm Home Discount depend on supplier and eligibility. They do not always transfer automatically when you switch. After moving supplier, check their support pages or ask directly. Priority Services Register support is also supplier-specific.',
                            "If you are unsure whether a switch could affect a discount you rely on, <a href=\"{$contact}\">contact us</a> or speak to the supplier before you apply. Our <a href=\"{$faqs}\">homepage FAQs</a> cover data use and how Brillia is funded.",
                        ],
                    ],
                    [
                        'h2' => '6. Prepayment, Direct Debit and bill shocks',
                        'p' => [
                            'Monthly Direct Debit usually unlocks the widest choice of competitive deals. Prepayment can offer budgeting control but may mean higher unit prices on some products — compare specifically with prepayment selected so you are not shown irrelevant Direct Debit-only tariffs.',
                            'If your Direct Debit is set too low for winter usage, you can build debt even on a fair unit rate. Review statements seasonally and ask the supplier to reassess. A cheaper tariff still helps; accurate payments keep you out of arrears.',
                            'Pay-on-receipt deals exist but are less common among the cheapest headlines. Always match payment method in the comparison so estimated savings reflect reality.',
                        ],
                    ],
                    [
                        'h2' => '7. When DIY savings are not enough',
                        'p' => [
                            'If your home is hard to heat, you may need fabric improvements or professional advice beyond a tariff change. Local authority or national scheme pages can point to grants for insulation or boiler upgrades where available. Those projects sit alongside — not instead of — a competitive supply contract.',
                            'Business energy is out of scope for Brillia’s home comparison. For domestic homes, start with the tariff, then habits, then fabric. That order usually delivers the best comfort-per-pound outcome.',
                        ],
                    ],
                    [
                        'h2' => 'A simple monthly rhythm',
                        'p' => [
                            'Once a month: glance at your Direct Debit balance or prepayment top-ups versus the season. Once or twice a year: recompare tariffs. After any big home change: update usage assumptions and compare again.',
                            "Browse the <a href=\"{$guides}\">guides hub</a> for switching and tariff deep-dives, learn <a href=\"{$how}\">how Brillia works</a>, or return to the <a href=\"{$home}\">homepage</a> to start a free comparison. Comfortable homes and competitive rates are not opposites — they work best together.",
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'q' => 'What saves more: switching or turning the heating down?',
                        'a' => 'For many homes on an expensive default tariff, switching (or re-signing) to a competitive deal saves more than small thermostat changes. Do both when you can.',
                    ],
                    [
                        'q' => 'Do I need a smart meter to save money?',
                        'a' => 'No. A better tariff helps with or without a smart meter. Smart data can help you spot waste once you are on a fair rate.',
                    ],
                    [
                        'q' => 'How often should I compare energy deals?',
                        'a' => 'At least when a fixed term ends, and ideally once or twice a year. Also recompare after moving home or big usage changes.',
                    ],
                    [
                        'q' => 'Will Brillia charge me to compare?',
                        'a' => 'No. Brillia Energy is free. If you switch, we may earn a commission from the supplier — it does not change the price you pay.',
                    ],
                ],
            ],
        ];
    }

    /**
     * @param  array{body: list<array{h2: string, p?: list<string>, p_after?: list<string>, ul?: list<string>}>}  $guide
     */
    public static function plainText(array $guide): string
    {
        $chunks = [];

        foreach ($guide['body'] as $section) {
            $chunks[] = $section['h2'];

            foreach (['p', 'p_after'] as $key) {
                foreach ($section[$key] ?? [] as $paragraph) {
                    $chunks[] = html_entity_decode(strip_tags($paragraph), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }

            foreach ($section['ul'] ?? [] as $item) {
                $chunks[] = html_entity_decode(strip_tags($item), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }

        foreach ($guide['faqs'] ?? [] as $faq) {
            $chunks[] = $faq['q'];
            $chunks[] = $faq['a'];
        }

        return implode(' ', $chunks);
    }

    /**
     * @param  array{body: list<array<string, mixed>>, faqs?: list<array{q: string, a: string}>}  $guide
     */
    public static function wordCount(array $guide): int
    {
        return str_word_count(self::plainText($guide));
    }

    /**
     * @param  array{body: list<array<string, mixed>>, faqs?: list<array{q: string, a: string}>}  $guide
     */
    public static function readingMinutes(array $guide): int
    {
        return max(1, (int) ceil(self::wordCount($guide) / 200));
    }
}
