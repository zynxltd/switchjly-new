import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('leadPopup', () => ({
    openState: false,
    email: '',
    postcode: '',
    loading: false,
    success: false,
    error: '',
    message: '',
    timer: null,
    storeUrl: '/leads',

    init() {
        this.storeUrl = this.$el.dataset.storeUrl || '/leads';

        if (localStorage.getItem('switchly_lead_done') === '1') {
            return;
        }

        this.timer = setTimeout(() => this.open(), 10000);
    },

    open() {
        if (localStorage.getItem('switchly_lead_done') === '1') {
            return;
        }

        this.openState = true;
        this.error = '';
        document.body.classList.add('overflow-hidden');
    },

    close() {
        this.openState = false;
        document.body.classList.remove('overflow-hidden');

        if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
        }

        if (this.success) {
            localStorage.setItem('switchly_lead_done', '1');
        }
    },

    async submit() {
        this.loading = true;
        this.error = '';

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
                    email: this.email,
                    postcode: this.postcode || null,
                    source: 'popup',
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

            this.success = true;
            this.message = data.message || 'Thanks — check your inbox for deals.';
            localStorage.setItem('switchly_lead_done', '1');
        } catch (e) {
            this.error = 'Network error. Please try again.';
        } finally {
            this.loading = false;
        }
    },
}));

Alpine.data('switchlyChat', () => ({
    open: false,
    draft: '',
    sending: false,
    messages: [],
    suggestions: [
        'How does switching work?',
        'Is Switchly free?',
        'Which deal should I pick?',
        'How long does it take?',
    ],

    init() {
        this.messages = [
            {
                role: 'bot',
                text: "Hi! I'm Switchly Assist. Ask me anything about comparing deals, switching, or what these tariffs mean.",
            },
        ];

        window.addEventListener('switchly-chat-open', () => this.show());
    },

    show() {
        this.open = true;
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

    useSuggestion(text) {
        this.draft = text;
        this.send();
    },

    send() {
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
        const q = input.toLowerCase();

        if (/(free|cost|charge|fee|pay you)/.test(q)) {
            return "Yes — Switchly is 100% free for you. We never charge to compare or switch. If you switch, we may earn a commission from the supplier — it doesn't change the price you pay.";
        }

        if (/(how (does|do).*(switch|work)|switch(ing)? work|process)/.test(q)) {
            return "Enter your details and usage, we compare live UK deals, then you pick a tariff. If you switch, your new supplier handles the rest — your supply shouldn't be interrupted.";
        }

        if (/(which|what).*(deal|tariff|pick|choose)|recommend|best deal|help choosing/.test(q)) {
            return "Start with the cheapest suitable deal that matches how you pay (e.g. Direct Debit). Check fixed vs flexible, exit fees, and whether you want renewable electricity. The 'Cheapest' badge is a good first look — tap a deal for full details.";
        }

        if (/(how long|how (fast|quick)|60 second|takes)/.test(q)) {
            return "Comparing usually takes under a minute. A switch itself is typically completed in about 5 working days, and your energy supply continues as normal.";
        }

        if (/(usage|kwh|estimate|annual)/.test(q)) {
            return "An estimate is fine. Typical UK dual-fuel homes use around 2,700–3,100 kWh electricity and ~11,500 kWh gas a year. More accurate usage = more accurate savings.";
        }

        if (/(safe|data|privacy|secure)/.test(q)) {
            return "Your data is encrypted and only used to find matching deals. We don't sell your personal details. You can edit your comparison inputs anytime before switching.";
        }

        if (/(exit fee|fixed|variable|tracker)/.test(q)) {
            return "Fixed tariffs lock your unit rates for a set term (often 12 months). Variable/SVT can change. Tracker follows a published index. Always check exit fees before you commit.";
        }

        if (/(hello|hi |hey|thanks|thank you)/.test(q)) {
            return "Happy to help! Ask about switching, fees, tariffs, or which deal might suit you.";
        }

        return "I can help with switching, whether Switchly is free, how long it takes, usage estimates, and picking between deals. Try one of the suggestions below, or ask in your own words.";
    },
}));

Alpine.start();
