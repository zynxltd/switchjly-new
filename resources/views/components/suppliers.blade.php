<section class="bg-white py-12 sm:py-14" aria-label="Energy suppliers we compare">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <h2 class="text-center text-lg font-extrabold tracking-tight text-brillia-ink sm:text-xl">
            We compare the UK's top energy suppliers
        </h2>

        {{-- Mobile: single-row horizontal slider --}}
        <div class="mt-8 -mx-5 sm:mx-0 sm:mt-10 sm:hidden">
            <ul class="flex snap-x snap-mandatory items-center gap-8 overflow-x-auto px-5 pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ([
                    ['octopus-color.png', 'Octopus Energy', 'h-9'],
                    ['eon-color.png', 'E.ON', 'h-8'],
                    ['scottishpower-color.png', 'ScottishPower', 'h-9'],
                    ['british-gas-color.png', 'British Gas', 'h-8'],
                    ['ovo-color.png', 'OVO Energy', 'h-8'],
                    ['utilita-color.png', 'Utilita', 'h-8'],
                ] as [$file, $alt, $height])
                    <li class="flex shrink-0 snap-start items-center justify-center">
                        <img
                            src="{{ asset("images/suppliers/{$file}") }}"
                            alt="{{ $alt }}"
                            class="{{ $height }} w-auto max-w-[8.5rem] object-contain grayscale"
                        >
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Desktop / tablet: wrap row --}}
        <ul class="mt-8 hidden flex-wrap items-center justify-between gap-x-6 gap-y-6 sm:mt-10 sm:flex sm:gap-x-8 lg:gap-x-10">
            @foreach ([
                ['octopus-color.png', 'Octopus Energy', 'h-9 sm:h-10'],
                ['eon-color.png', 'E.ON', 'h-8 sm:h-9'],
                ['scottishpower-color.png', 'ScottishPower', 'h-9 sm:h-10'],
                ['british-gas-color.png', 'British Gas', 'h-8 sm:h-9'],
                ['ovo-color.png', 'OVO Energy', 'h-8 sm:h-9'],
                ['utilita-color.png', 'Utilita', 'h-8 sm:h-9'],
            ] as [$file, $alt, $height])
                <li class="flex min-w-0 flex-1 items-center justify-center">
                    <img
                        src="{{ asset("images/suppliers/{$file}") }}"
                        alt="{{ $alt }}"
                        class="{{ $height }} w-auto max-w-[11rem] object-contain grayscale transition duration-300 hover:grayscale-0"
                    >
                </li>
            @endforeach
        </ul>
    </div>
</section>
