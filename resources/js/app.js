import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.postcodeCompareForm = () => ({
    postcode: '',
    error: '',

    validate(event) {
        const value = (this.postcode || '').trim();

        if (value === '') {
            this.error = 'Enter your UK postcode.';
            event.preventDefault();
            this.$nextTick(() => this.$refs.input?.focus());

            return;
        }

        if (!/^(GIR\s?0AA|[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2})$/i.test(value)) {
            this.error = 'Enter a valid UK postcode (e.g. SW1A 1AA).';
            event.preventDefault();
            this.$nextTick(() => this.$refs.input?.focus());

            return;
        }

        this.error = '';
        this.postcode = value.toUpperCase().replace(/\s+/g, ' ');
    },
});

Alpine.data('brilliaChat', () => ({
    open: false,
    identified: false,
    name: '',
    email: '',
    draft: '',
    sending: false,
    capturing: false,
    error: '',
    storeUrl: '/leads',
    tradingName: 'Brillia',
    productName: 'Brillia Energy',
    legalName: 'Zynx Ltd',
    companyNumber: '15822793',
    supportEmail: 'hello@brillia.test',
    contactUrl: '/contact',
    affiliatesUrl: '/affiliates',
    guidesUrl: '/guides',
    messages: [],

    init() {
        this.storeUrl = this.$el.dataset.storeUrl || '/leads';
        this.tradingName = this.$el.dataset.tradingName || this.tradingName;
        this.productName = this.$el.dataset.productName || this.productName;
        this.legalName = this.$el.dataset.legalName || this.legalName;
        this.companyNumber = this.$el.dataset.companyNumber || this.companyNumber;
        this.supportEmail = this.$el.dataset.supportEmail || this.supportEmail;
        this.contactUrl = this.$el.dataset.contactUrl || this.contactUrl;
        this.affiliatesUrl = this.$el.dataset.affiliatesUrl || this.affiliatesUrl;
        this.guidesUrl = this.$el.dataset.guidesUrl || this.guidesUrl;

        try {
            const saved = JSON.parse(sessionStorage.getItem('brillia_chat_user') || 'null');
            if (saved?.email && saved?.name) {
                this.name = saved.name;
                this.email = saved.email;
                this.identified = true;
                this.bootstrapChat();
            }
        } catch (e) {
            // ignore
        }

        window.addEventListener('brillia-chat-open', () => this.show());
    },

    bootstrapChat() {
        const first = this.name.split(' ')[0] || 'there';
        this.messages = [
            {
                role: 'bot',
                text: `Hi ${first}! I'm Brillia Assist for ${this.productName} — a free UK energy comparison site. Ask who we are, how comparing works, tariffs, fees, smart meters, savings, or switching.`,
            },
        ];
    },

    show() {
        this.open = true;
        this.error = '';
        this.$nextTick(() => this.scrollToEnd());
    },

    hide() {
        this.open = false;
    },

    scrollToEnd() {
        const el = this.$refs.thread;
        if (el) {
            el.scrollTop = el.scrollHeight;
        }
    },

    async submitDetails() {
        this.capturing = true;
        this.error = '';

        const name = this.name.trim();
        const email = this.email.trim();

        if (!name || !email) {
            this.error = 'Please enter your name and email.';
            this.capturing = false;
            return;
        }

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            const response = await fetch(this.storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    name,
                    email,
                    source: 'chat',
                }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                const firstError = data.errors
                    ? Object.values(data.errors).flat()[0]
                    : data.message || 'Something went wrong. Please try again.';
                this.error = firstError;
                return;
            }

            sessionStorage.setItem('brillia_chat_user', JSON.stringify({ name, email }));
            this.identified = true;
            this.bootstrapChat();
            this.$nextTick(() => this.scrollToEnd());
        } catch (e) {
            this.error = 'Network error. Please try again.';
        } finally {
            this.capturing = false;
        }
    },

    send() {
        if (!this.identified) {
            return;
        }

        const text = this.draft.trim();
        if (!text || this.sending) {
            return;
        }

        this.messages.push({ role: 'user', text });
        this.draft = '';
        this.sending = true;
        this.$nextTick(() => this.scrollToEnd());

        const reply = this.replyFor(text);

        setTimeout(() => {
            this.messages.push({ role: 'bot', text: reply });
            this.sending = false;
            this.$nextTick(() => this.scrollToEnd());
        }, 450 + Math.random() * 350);
    },

    replyFor(input) {
        const q = input.toLowerCase().replace(/\s+/g, ' ').trim();
        const brand = this.tradingName;
        const product = this.productName;
        const legal = this.legalName;

        const topics = [
            {
                test: /(who('?s| is| are)|what is|whats|what'?s|tell me about|about)\s+(brillia(\s+energy)?|this (site|website|company|service)|you(r company)?|zynx)|who('?s| is)\s+brillia|brillia(\s+energy)?\s*\?*$|^(brillia(\s+energy)?)$/,
                reply: `${product} is a free UK home energy comparison service. We help you compare live gas and electricity deals from leading suppliers in about a minute, then switch if you want — at no cost to you. ${brand} is a trading name of ${legal} (company number ${this.companyNumber}). We’re a comparison site, not an energy supplier.`,
            },
            {
                test: /(who (owns|runs|operates)|parent company|legal (name|entity)|company number|registered office|zynx)/,
                reply: `${product} is operated under the trading name ${brand}. The registered company is ${legal}, company number ${this.companyNumber}. For company questions or support, use Contact (${this.contactUrl}) or email ${this.supportEmail}.`,
            },
            {
                test: /(are you (an? )?(energy )?supplier|do you supply|sell (gas|electric|energy)|your (own )?tariff)/,
                reply: `No — ${product} doesn’t supply gas or electricity. We’re an independent comparison service. When you switch, you sign up with a licensed UK supplier (like Octopus, British Gas, E.ON, and others we show). They handle your account and bills.`,
            },
            {
                test: /(what (can|do) (i|you|this site)|what('?s| is) (this|the) (site|website|page) (for|do)|how can you help|what do you (offer|do))/,
                reply: `On ${product} you can: compare UK home energy deals with a postcode, filter by cheapest / green / biggest saving, read plain-English guides, browse FAQs, contact support, or join as an affiliate partner. Start with Compare or enter your postcode on the homepage.`,
            },
            {
                test: /(trust|scam|safe (site|to use)|real company)/,
                reply: `${product} is run by ${legal} (UK company ${this.companyNumber}). Comparing is free; we may earn a commission from suppliers if you switch — that doesn’t change the price you pay. Licensed suppliers are regulated by Ofgem. Questions? Contact us via ${this.contactUrl}.`,
            },
            {
                test: /(hello|hi\b|hey|good (morning|afternoon|evening)|thanks|thank you|cheers)/,
                reply: `Happy to help! Ask who ${product} is, how comparing works, tariffs, fees, savings, smart meters, Direct Debit, green energy, or what happens after you pick a deal.`,
            },
            {
                test: /(human|real person|speak to|talk to|contact|customer service|support team|phone|call)/,
                reply: `For personal help, use Contact (${this.contactUrl}) — our UK team usually replies within one working day. Email ${this.supportEmail}. I can still answer most switching and tariff questions here straight away.`,
            },
            {
                test: /(guide|guides|blog|articles?)/,
                reply: `We publish free UK energy guides (switching, tariffs, saving tips) at ${this.guidesUrl}. FAQs are also on the homepage. Ask me here if you want a quick answer.`,
            },
            {
                test: /(affiliate|partner|referral|commission (for me|partner))/,
                reply: `We have an affiliate programme for partners who send comparisons our way. See Affiliates (${this.affiliatesUrl}) or Contact us (${this.contactUrl}) to apply for a partner account.`,
            },
            {
                test: /(newsletter|subscribe|mailing list)/,
                reply: `Email updates are handled by our mailing partner when available on the site — we don’t run a built-in subscribe popup. For questions, use Contact (${this.contactUrl}).`,
            },
            {
                test: /(filter|cheapest|top rated|biggest saving|green energy filter|sort deals|annual cost)/,
                reply: `On your deals results, use Cheapest (lowest estimated annual cost), Top rated, Green energy, or Biggest saving. The Filter button also lets you narrow to green-only or fixed tariffs. Cards show estimated annual cost plus savings. Tap Edit in the summary bar if your details need changing.`,
            },
            {
                test: /(free|cost (to )?(me|us|use)|do i (have to )?pay|charge(s)? (me|us)|fee to (compare|switch|use)|pay (you|brillia)|commission)/,
                reply: `${product} is 100% free for you to compare and switch — no hidden fees. If you switch, we may earn a commission from the supplier. That never changes the price you pay.`,
            },
            {
                test: /(how (does|do).*(brillia|compare|work)|how (to|do i) (compare|switch)|switch(ing)? (work|process)|what (do|does) i (do|need)|steps? to (compare|switch))/,
                reply: `1) Enter postcode, current supplier and tariff. 2) Add usage and how you pay. 3) We show matching UK deals with estimated annual cost and savings. 4) Pick one and complete the short application. Your new supplier handles the switch — supply shouldn’t be interrupted.`,
            },
            {
                test: /(how long|how (fast|quick)|how many day|when (will|does).*(switch|complete)|takes? (to )?(switch|complete)|5 working|timeline)/,
                reply: "Comparing usually takes under a minute. Most switches complete in about 5 working days. Your energy keeps flowing as normal during the changeover.",
            },
            {
                test: /(interrupt|cut off|power cut|lights? (go|stay)|lose (gas|electric|power|supply)|supply (stop|continue)|outage)/,
                reply: "Your supply shouldn’t stop. Switching is an admin change between suppliers — gas and electricity keep running while the switch completes.",
            },
            {
                test: /(which|what).*(deal|tariff|pick|choose)|recommend|best deal|help choosing/,
                reply: "Start with the cheapest estimated annual cost that matches how you pay (e.g. Direct Debit). Check fixed vs flexible, exit fees, green electricity, and any smart-meter needs. Use the Cheapest / Biggest saving / Green filters, then open a deal for full details.",
            },
            {
                test: /(saving|save £|save money|how much.*(save|saving)|could save|guaranteed saving|are savings|saving(s)? (accurate|estimate|guaranteed)|est\.? annual)/,
                reply: "Deal cards show estimated annual cost (what Cheapest sorts by) plus how much you could save versus your current setup. Figures are estimates from the usage and tariff details you enter — not a guaranteed saving.",
            },
            {
                test: /(usage|kwh|kilowatt|estimate.*(use|usage)|annual (use|usage)|how much (do i|energy) use|typical (home|usage))/,
                reply: "An estimate is fine to start. Typical UK dual-fuel homes often use roughly 2,700–3,100 kWh electricity and around 11,500 kWh gas a year. Check a recent bill for better numbers — that improves deal accuracy.",
            },
            {
                test: /(standing charge|unit rate|unit price|p\/?kwh|pence per)/,
                reply: "Bills usually combine a daily standing charge plus a unit rate (p/kWh). Cheapest isn’t always the lowest unit rate — standing charges and exit fees matter too.",
            },
            {
                test: /(exit fee|leaving fee|leave early|break (my )?(contract|fixed))/,
                reply: "Some fixed deals charge an exit fee if you leave early. Variable/SVT deals often have none. Check each deal’s exit fee before you switch.",
            },
            {
                test: /(fixed (tariff|deal|rate|term)|what is fixed)/,
                reply: "A fixed tariff locks your unit rates (and usually standing charge terms) for a set period — often 12 months. Good for bill certainty. Watch exit fees if you might leave early.",
            },
            {
                test: /(variable|svt|standard variable|flexible tariff|what is variable)/,
                reply: "A variable or SVT (Standard Variable Tariff) can change when the supplier updates prices. More flexible than fixed, but bills can rise. Often easier to leave without an exit fee.",
            },
            {
                test: /(tracker|index[- ]linked)/,
                reply: "Tracker tariffs follow a published index or formula, so prices can move up or down. Read how often it updates and any caps or fees before you choose one.",
            },
            {
                test: /(green|renewable|100% renewable|eco|carbon|clean energy)/,
                reply: "Many deals offer 100% renewable electricity (and sometimes green gas options). Use the Green energy filter on results, then check the deal details for what’s included.",
            },
            {
                test: /(direct debit|dd\b|how (do )?i pay|payment method|pay monthly|pay on receipt)/,
                reply: "Most of the cheapest deals need Monthly Direct Debit. Prepayment and pay-on-receipt options exist but can cost more. Pick the payment method that matches how you actually pay when you compare.",
            },
            {
                test: /(prepayment|pre[- ]?pay|pay as you go|key meter|top[- ]?up)/,
                reply: "Prepayment deals are available — choose prepayment as your payment method when you compare. Top-up still works as usual; just make sure the deal is marked for prepayment meters.",
            },
            {
                test: /(smart meter|smartmeter|need a smart|do i (need|have) (a )?smart)/,
                reply: "Some tariffs (especially EV or smart time-of-use) need a smart meter. Many standard fixed/variable deals don’t. If a deal requires one, it’ll usually say so in the details — your new supplier can often arrange installation.",
            },
            {
                test: /(economy ?7|e7|night rate|off[- ]peak|time of use|tou\b|ev tariff|overnight)/,
                reply: "Economy 7 and EV/time-of-use tariffs are cheaper at certain times (often overnight). They work best if you shift usage — e.g. charging an EV or running appliances off-peak.",
            },
            {
                test: /(dual fuel|gas and electric|electric(ity)? only|gas only|single fuel)/,
                reply: "Dual fuel means gas and electricity with one supplier (often simpler). You can also compare electricity-only or gas-only on the usage step.",
            },
            {
                test: /(credit (score|check|rating)|affect (my )?credit|hard search|soft search)/,
                reply: `Comparing on ${product} doesn’t run a credit check. Some suppliers may do checks when you apply to switch.`,
            },
            {
                test: /(debt|owed|arrears|in debt|outstanding balance)/,
                reply: "If you owe your current supplier, you may still be able to switch, but debt rules can apply (especially on prepayment). Clear or discuss arrears with your supplier if a switch is blocked.",
            },
            {
                test: /(cancel (my )?(switch|application)|cooling off|change my mind|withdraw)/,
                reply: "You usually get a cooling-off period after applying (often 14 days — confirm on the supplier’s terms). Contact the new supplier promptly if you want to cancel before the switch completes.",
            },
            {
                test: /(when (should|to) switch|end of (my )?fixed|fixed (term )?end|out of contract)/,
                reply: "A common time to switch is near the end of a fixed deal, before you roll onto a (often pricier) variable tariff. If you’re mid-fixed term, weigh any exit fee against the saving.",
            },
            {
                test: /(moving|move house|new address|relocating)/,
                reply: "If you’re moving, tell both your current and new suppliers your move date. You can compare deals for the new postcode once you have it.",
            },
            {
                test: /(landlord|tenant|renter|rental|flatmate)/,
                reply: "Tenants can usually switch if they’re responsible for the energy bills. Check your tenancy agreement. Landlords or bill-payers should be the ones named on the application.",
            },
            {
                test: /(warm home|whd|benefit|priority service|vulnerable)/,
                reply: "Some support schemes (like Warm Home Discount) depend on the supplier and eligibility. After you switch, check the new supplier’s support pages — schemes don’t always transfer automatically.",
            },
            {
                test: /(ofgem|regulated|licence|safe supplier)/,
                reply: "Licensed UK suppliers are regulated by Ofgem. Switching through a comparison service still ends with a licensed supplier handling your account and supply.",
            },
            {
                test: /(postcode|why.*(postcode|address)|where i live)/,
                reply: "Your postcode helps match regional network charges and available tariffs. Deals can vary by area, so we need it to show accurate options.",
            },
            {
                test: /(data|privacy|gdpr|sell (my )?data|share (my )?(data|details|email))/,
                reply: "We use your details to find deals and (if you choose) complete a switch application. We don’t sell your personal data.",
            },
            {
                test: /(view deal|what happens next|after i (click|choose|pick)|complete (my )?switch|application)/,
                reply: "After View Deal you’ll see a short handoff page, then a form to confirm your details. Submit that and the supplier application can proceed.",
            },
            {
                test: /(edit|change (my )?(details|postcode|usage|supplier)|wrong (postcode|usage)|update results)/,
                reply: "On your deals page, tap Edit in the summary bar. Update postcode, supplier, tariff, usage, fuel or payment and hit Update results — no need to restart the whole form.",
            },
            {
                test: /(business|commercial|sole trader|shop|office)/,
                reply: `${product} is built for UK home energy comparisons. For business energy you’ll usually need a business-specific comparison or to contact suppliers directly.`,
            },
            {
                test: /(current supplier|stay with|same supplier|do i have to (leave|change))/,
                reply: "You’re never forced to switch. Compare freely, and only continue if a deal looks better. If you stay put, nothing changes with your current supplier.",
            },
            {
                test: /(octopus|british gas|e\.?on|scottish ?power|ovo|utilita|suppliers)/,
                reply: `We compare deals from leading UK suppliers including Octopus Energy, British Gas, E.ON, ScottishPower, OVO, Utilita and more — availability depends on your postcode and details. ${product} itself isn’t a supplier.`,
            },
        ];

        for (const topic of topics) {
            if (topic.test.test(q)) {
                return topic.reply;
            }
        }

        return `Not sure I caught that. Try asking who ${product} is, how comparing works, fees, fixed vs variable, smart meters, savings/annual cost, or what happens after View Deal. Or Contact us at ${this.contactUrl}.`;
    },
}));

Alpine.data('dealResults', () => ({
    sort: 'cheapest',
    showAll: false,
    greenOnly: false,
    fixedOnly: false,
    filterOpen: false,
    matchCount: 0,

    init() {
        this.$nextTick(() => this.recompute());
        this.$watch('sort', () => {
            this.showAll = false;
            this.recompute();
        });
        this.$watch('greenOnly', () => {
            this.showAll = false;
            this.recompute();
        });
        this.$watch('fixedOnly', () => {
            this.showAll = false;
            this.recompute();
        });
        this.$watch('showAll', () => this.recompute());
    },

    cards() {
        if (! this.$refs.list) {
            return [];
        }

        return [...this.$refs.list.querySelectorAll('[data-deal-card]')];
    },

    recompute() {
        const cards = this.cards();

        if (cards.length === 0) {
            this.matchCount = 0;

            return;
        }
        let rows = cards.map((el) => ({
            el,
            cost: Number(el.dataset.cost || 0),
            saving: Number(el.dataset.saving || 0),
            rating: Number(el.dataset.rating || 0),
            green: el.dataset.green === '1',
            fixed: el.dataset.fixed === '1',
        }));

        if (this.greenOnly || this.sort === 'green') {
            rows = rows.filter((row) => row.green);
        }

        if (this.fixedOnly) {
            rows = rows.filter((row) => row.fixed);
        }

        rows.sort((a, b) => {
            if (this.sort === 'top') {
                return b.rating - a.rating || a.cost - b.cost;
            }

            if (this.sort === 'saving') {
                return b.saving - a.saving || a.cost - b.cost;
            }

            return a.cost - b.cost || b.saving - a.saving;
        });

        this.matchCount = rows.length;
        const order = new Map(rows.map((row, index) => [row.el, index]));

        cards.forEach((el) => {
            const index = order.get(el);

            if (index === undefined) {
                el.hidden = true;
                el.style.order = '9999';

                return;
            }

            el.style.order = String(index);
            el.hidden = ! this.showAll && index >= 3;
        });
    },
}));

Alpine.start();
