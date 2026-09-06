<section class="bg-white py-12 sm:py-14" aria-label="Energy suppliers we compare">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <h2 class="text-center text-[1.875rem] font-extrabold tracking-tight text-switchly-ink sm:text-4xl">
            We compare the UK's top energy suppliers
        </h2>

        <ul class="mt-8 flex flex-wrap items-center justify-between gap-x-6 gap-y-6 sm:mt-10 sm:gap-x-8 lg:gap-x-10">
            @foreach ([
                ['octopus-color.png', 'Octopus Energy', 'h-8 sm:h-9'],
                ['eon-color.png', 'E.ON', 'h-7 sm:h-8'],
                ['scottishpower-color.png', 'ScottishPower', 'h-8 sm:h-9'],
                ['british-gas-color.png', 'British Gas', 'h-7 sm:h-8'],
                ['ovo-color.png', 'OVO Energy', 'h-7 sm:h-8'],
                ['utilita-color.png', 'Utilita', 'h-7 sm:h-8'],
            ] as [$file, $alt, $height])
                <li class="flex min-w-[5.5rem] flex-1 items-center justify-center sm:min-w-0">
                    <img
                        src="{{ asset("images/suppliers/{$file}") }}"
                        alt="{{ $alt }}"
                        class="{{ $height }} w-auto max-w-[9.5rem] object-contain grayscale transition duration-300 hover:grayscale-0"
                    >
                </li>
            @endforeach
        </ul>
    </div>
</section>
