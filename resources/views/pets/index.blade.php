<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voidpet Garden - My Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tom Select (Alternative to Select2 for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* Modern Dark Mode Styling for TomSelect */
        .ts-control { background-color: #1f2937 !important; border: 1px solid #374151 !important; color: white !important; border-radius: 0.5rem !important; padding: 0.6rem !important; box-shadow: none !important;}
        .ts-control input { color: white !important; }
        .ts-dropdown { background-color: #1f2937 !important; color: white !important; border: 1px solid #374151 !important; border-radius: 0.5rem !important; }
        .ts-dropdown .option:hover, .ts-dropdown .active { background-color: #374151 !important; color: white !important; }
        .ts-wrapper.multi .ts-control > item { background-color: #4f46e5 !important; border-radius: 9999px !important; padding: 2px 10px !important; margin: 2px !important; color: white; border: none !important;}
        .ts-wrapper.single .ts-control:after { border-color: #9CA3AF transparent transparent transparent !important; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4B5563; }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen pb-12 font-sans">

    <!-- Header Section -->
    <header class="bg-gray-800 border-b border-gray-700 p-6 mb-8 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <span class="text-4xl">🪴</span>
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Voidpet Garden</h1>
                </div>
                <div class="text-sm font-medium text-gray-400">Total Pets: <span class="text-white font-bold">{{ $pets->count() }}</span></div>
            </div>

            <!-- Navigation -->
            <nav class="flex space-x-4">
                <a href="{{ route('pets.index') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium border border-gray-700 shadow-inner">Pet Collection</a>
                <a href="{{ route('people.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">People (Food Tracking)</a>
                <a href="{{ route('plants.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Plant Vivid Forms</a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 p-4 rounded-lg mb-8 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-lg mb-8 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT PANEL: Add Pet Form -->
            <div class="lg:col-span-4">
                <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700/50 overflow-hidden sticky top-6">
                    <div class="p-6 bg-gray-800/80 border-b border-gray-700/50">
                        <h2 class="text-xl font-bold flex items-center text-purple-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add New Pet
                        </h2>
                    </div>

                    <form action="{{ route('pets.store') }}" method="POST" class="p-6 space-y-5" autocomplete="off">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Nickname / Name</label>
                            <input type="text" name="nickname" placeholder="Leave empty for default" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded-lg text-white border border-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Species <span class="text-red-400">*</span></label>
                            <!-- USING TOMSELECT -->
                            <select id="form-species" name="species_id" placeholder="Cari Species..." required autocomplete="off">
                                <option value="">Cari Species...</option>
                                @foreach($speciesList as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }} ({{ ucfirst($s->default_element) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Element(s)</label>
                            <!-- USING TOMSELECT MULTIPLE -->
                            <select id="form-element" name="element[]" multiple placeholder="Element..." autocomplete="off">
                                <option value="">All Elements</option>
                                @foreach(['water','fire','earth','wood','metal'] as $el)
                                    <option value="{{ $el }}">{{ ucfirst($el) }}</option>
                                    <option value="Deviant {{ $el }}">Deviant {{ ucfirst($el) }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Leave empty for default species element.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Vivid Form</label>
                            <!-- USING TOMSELECT -->
                            <select id="form-vivid" name="vivid_form_id" placeholder="Cari Form Normal/Vivid..." autocomplete="off">
                                <option value="">-- Normal Appearance --</option>
                                @foreach($vividForms as $vivid)
                                    <option value="{{ $vivid->id }}">[{{ strtoupper($vivid->box_type) }}] {{ $vivid->name }} ({{ ucfirst($vivid->rarity) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Stage <span class="text-red-400">*</span></label>
                            <input type="number" name="stage" value="1" min="1" required class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded-lg text-white border border-gray-600 outline-none">
                        </div>

                        <div class="border-t border-gray-700 pt-4 mt-4">
                            <h3 class="text-sm font-bold text-yellow-400 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Bonus Stats
                            </h3>
                            <div class="grid grid-cols-3 gap-3">
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Intensity</label><input type="number" name="intensity" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Clarity</label><input type="number" name="clarity" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Stability</label><input type="number" name="stability" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                            </div>
                        </div>

                        <div class="border-t border-gray-700 pt-4 pb-2">
                            <h3 class="text-sm font-bold text-red-400 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                                Battle Stats
                            </h3>
                            <div class="grid grid-cols-3 gap-3 gap-y-4">
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">HP</label><input type="number" name="hp" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Focus</label><input type="number" name="focus" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Calm</label><input type="number" name="calm" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Speed</label><input type="number" name="speed" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Balance</label><input type="number" name="balance" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                                <div><label class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Strength</label><input type="number" name="strength" value="0" class="w-full bg-gray-900 p-2 rounded text-sm text-center border border-gray-700"></div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 bg-gray-900/50 p-3 rounded-lg border border-gray-700">
                            <input type="checkbox" name="is_favorite" value="1" id="favorite" class="w-5 h-5 rounded border-gray-600 text-pink-500 focus:ring-pink-500 focus:ring-offset-gray-900 bg-gray-700">
                            <label for="favorite" class="text-sm font-medium text-pink-400 cursor-pointer">Lock / Favorite Pet</label>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 mt-4 px-4 rounded-lg shadow-md transition-all transform active:scale-95">
                            Sprout New Pet
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT PANEL: Filter & Pet List -->
            <div class="lg:col-span-8">
                <!-- Filter Section -->
                <div class="bg-gray-800 p-5 rounded-xl shadow-md border border-gray-700 mb-6">
                    <form action="{{ route('pets.index') }}" method="GET" class="grid grid-cols-2 md:grid-cols-3 gap-4" autocomplete="off">

                        <div class="col-span-2 md:col-span-3 mb-2">
                            <label class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 block">Search by Name</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pet nickname or species..." class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded-lg text-white border border-gray-600 outline-none transition-colors">
                        </div>

                        <div>
                            <label class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 block">Species Filter</label>
                            <!-- USING TOMSELECT -->
                            <select id="search-species" name="species" placeholder="Filter species..." autocomplete="off">
                                <option value="">All Species</option>
                                @foreach($speciesList as $s)
                                    <option value="{{ $s->name }}" {{ request('species') == $s->name ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 block">Element Filter</label>
                            <!-- USING TOMSELECT -->
                            <select id="search-element" name="element" placeholder="Filter Element..." autocomplete="off">
                                <option value="">All Element</option>
                                @foreach(['water','fire','earth','wood','metal'] as $el)
                                    <option value="{{ $el }}" {{ request('element') == $el ? 'selected' : '' }}>{{ ucfirst($el) }}</option>
                                    <option value="Deviant {{ $el }}" {{ request('element') == "Deviant $el" ? 'selected' : '' }}>Deviant {{ ucfirst($el) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 block">Vivid Form Filter</label>
                            <!-- USING TOMSELECT -->
                            <select id="search-vivid" name="vivid_form" placeholder="Filter Form..." autocomplete="off">
                                <option value="">All Forms</option>
                                @foreach($vividForms as $v)
                                    <option value="{{ $v->name }}" {{ request('vivid_form') == $v->name ? 'selected' : '' }}>{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 block">Sort By Rarity</label>
                            <!-- USING TOMSELECT -->
                            <select id="search-rarity" name="rarity" placeholder="Filter Rarity..." autocomplete="off">
                                <option value="">All Rarity</option>
                                @foreach(['rare', 'fabled', 'mythical', 'absurd'] as $rarity)
                                    <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>{{ ucfirst($rarity) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 block">Sort By Box Type</label>
                            <!-- USING TOMSELECT -->
                            <select id="search-box" name="box_type" placeholder="Filter Box Type..." autocomplete="off">
                                <option value="">All Box Types</option>
                                @foreach(['void', 'water', 'metal', 'fire', 'earth', 'wood'] as $box)
                                    <option value="{{ $box }}" {{ request('box_type') == $box ? 'selected' : '' }}>{{ ucfirst($box) }} Box</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <div class="flex space-x-2 w-full">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white transition-colors px-4 py-2 rounded-lg text-sm font-bold flex-1 text-center shadow-sm">Filter</button>
                                <a href="{{ route('pets.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white transition-colors px-4 py-2 rounded-lg text-sm font-bold text-center shadow-sm">Reset</a>
                            </div>
                        </div>

                        <input type="hidden" name="sort" value="{{ request('sort', 'recent') }}">
                    </form>
                </div>

                <!-- Pet List Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($pets as $pet)
                        <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-xl transition-shadow border border-gray-700">

                            <!-- Card Header -->
                            <div class="p-4 bg-gray-800/80 border-b border-gray-700/50 flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-1">{{ $pet->nickname ?? $pet->species->name }}</h3>
                                    <div class="flex items-center space-x-2 text-sm text-gray-400">
                                        <span class="bg-gray-700/50 px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider">{{ $pet->species->name }}</span>
                                        <span class="text-gray-500">•</span>
                                        <span>Stage {{ $pet->stage }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($pet->is_favorite)
                                        <span title="Locked / Favorited" class="bg-pink-500/20 text-pink-400 p-1.5 rounded-full">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                                        </span>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('Release this pet to the Void? (Favorited pets are protected)');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 bg-red-400/10 hover:bg-red-400/20 p-1.5 rounded-full transition" title="Release / Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="p-5">
                                <!-- Tags / Elements -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @php
                                        // Karena element berbentuk array json, kita buat default handler
                                        $elements = is_string($pet->element) ? json_decode($pet->element, true) : $pet->element;
                                        if(!is_array($elements)) $elements = [$pet->element];
                                    @endphp

                                    @foreach($elements as $el)
                                        <span class="inline-flex divide-x divide-transparent items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900/50 text-blue-300 border border-blue-700/50">
                                            {{ ucfirst($el) }}
                                        </span>
                                    @endforeach

                                    @if($pet->vividForm)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-900/50 text-purple-300 border border-purple-700/50">
                                            {{ $pet->vividForm->name }} Form
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-900/50 text-emerald-300 border border-emerald-700/50">
                                            {{ ucfirst($pet->vividForm->rarity) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Stats Layout -->
                                <div class="bg-gray-900 rounded-lg p-3 grid grid-cols-2 gap-4">

                                    <!-- Bonus Stats -->
                                    <div>
                                        <div class="text-[10px] font-bold text-yellow-500 uppercase tracking-wider mb-2 border-b border-gray-700 pb-1">Bonus</div>
                                        <ul class="text-xs space-y-1.5 text-gray-400">
                                            <li class="flex justify-between"><span>Intensity</span> <span class="font-mono text-gray-300">{{ $pet->intensity }}</span></li>
                                            <li class="flex justify-between"><span>Clarity</span> <span class="font-mono text-gray-300">{{ $pet->clarity }}</span></li>
                                            <li class="flex justify-between"><span>Stability</span> <span class="font-mono text-gray-300">{{ $pet->stability }}</span></li>
                                        </ul>
                                    </div>

                                    <!-- Battle Stats -->
                                    <div>
                                        <div class="text-[10px] font-bold text-red-400 uppercase tracking-wider mb-2 border-b border-gray-700 pb-1">Battle</div>
                                        <ul class="text-xs space-y-1.5 text-gray-400">
                                            <li class="flex justify-between"><span>HP</span> <span class="font-mono text-white">{{ $pet->hp }}</span></li>
                                            <li class="flex justify-between"><span>Focus</span> <span class="font-mono text-white">{{ $pet->focus }}</span></li>
                                            <li class="flex justify-between"><span>Calm</span> <span class="font-mono text-white">{{ $pet->calm }}</span></li>
                                            <li class="flex justify-between"><span>Speed</span> <span class="font-mono text-white">{{ $pet->speed }}</span></li>
                                            <li class="flex justify-between"><span>Balance</span> <span class="font-mono text-white">{{ $pet->balance }}</span></li>
                                            <li class="flex justify-between"><span>Strength</span> <span class="font-mono text-white">{{ $pet->strength }}</span></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full border-2 border-dashed border-gray-700 rounded-xl p-12 text-center bg-gray-800/50">
                            <span class="text-4xl block mb-3">🕸️</span>
                            <h3 class="text-xl font-bold text-gray-300 mb-1">Your Garden is Empty</h3>
                            <p class="text-gray-500">No pets match your criteria, or you haven't added any pets yet!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- TomSelect Initialization Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Konfigurasi dasar untuk plugin Searchable Dropdown kita (TomSelect)
            const baseConfig = {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: 'Cari atau pilih...'
            };

            // ---- FORM ADD PET (LEFT PANEL) ----
            new TomSelect("#form-species", baseConfig);
            new TomSelect("#form-vivid", baseConfig);

            // Khusus Elemen Form: bisa dipilih banyak (multiple select) & ada tombol delete x
            new TomSelect("#form-element", {
                ...baseConfig,
                plugins: ['remove_button'],
                placeholder: 'Multiple element...'
            });

            // ---- FORM FILTER (RIGHT PANEL) ----
            ['#search-species', '#search-element', '#search-vivid', '#search-rarity', '#search-box'].forEach(function(selector) {
                new TomSelect(selector, baseConfig);
            });
        });
    </script>
</body>
</html>