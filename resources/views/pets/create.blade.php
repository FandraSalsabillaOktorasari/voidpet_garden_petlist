<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voidpet Garden - Add New Pet</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tom Select (Alternative to Select2 for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* Modern Dark Mode Styling for TomSelect */
        .ts-control { background-color: #1f2937 !important; border: 1px solid #374151 !important; color: white !important; border-radius: 0.5rem !important; padding: 0.75rem !important; box-shadow: none !important;}
        .ts-control input { color: white !important; }
        .ts-control .item { color: white !important; display: inline-block; }
        .ts-dropdown { background-color: #1f2937 !important; color: white !important; border: 1px solid #374151 !important; border-radius: 0.5rem !important; }
        .ts-dropdown .option:hover, .ts-dropdown .active { background-color: #374151 !important; color: white !important; }
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
            </div>

            <!-- Navigation -->
            <nav class="flex space-x-4 overflow-x-auto pb-2">
                <a href="{{ route('pets.index') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium border border-gray-700 shadow-inner shrink-0">Pet Collection</a>
                <a href="{{ route('pets.duplicates') }}" class="{{ request()->routeIs('pets.duplicates') ? 'bg-gray-900 text-white border-gray-700 shadow-inner' : 'text-gray-400 hover:text-white border-transparent hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium border transition-colors shrink-0">Duplicate Pets</a>
                <a href="{{ route('people.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">People (Food Tracking)</a>
                <a href="{{ route('plants.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Plant Vivid Forms</a>
                <a href="{{ route('pets.checklist') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Pet Checklist</a>
            </nav>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('pets.index') }}" class="inline-flex items-center text-sm text-gray-400 hover:text-white transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Collection
            </a>
        </div>

        <!-- Add Pet Form container -->
        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700/50 overflow-hidden">
            <div class="p-6 bg-gray-808/80 border-b border-gray-700/50">
                <h2 class="text-2xl font-bold flex items-center text-purple-400">
                    <span class="mr-2">âž•</span> Add New Pet
                </h2>
                <p class="text-gray-400 text-sm mt-1">Sprout and track a new pet in your gardening collection.</p>
            </div>

            <!-- Error Banner -->
            @if($errors->any())
                <div class="bg-red-500/10 border-b border-red-500/50 text-red-400 p-4 text-sm">
                    <div class="font-semibold mb-1">Please fix the following validation errors:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pets.store') }}" method="POST" class="p-8 space-y-6" autocomplete="off">
                @csrf

                <!-- Row 1: Nickname & Species -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nickname / Name</label>
                        <input type="text" name="nickname" value="{{ old('nickname') }}" placeholder="Leave empty for default" class="w-full bg-gray-900 focus:bg-gray-700 p-3 rounded-lg text-white border border-gray-600 focus:border-purple-500 transition-all outline-none">
                        <span class="text-xs text-gray-500 mt-1 block">If empty, will use Species name by default.</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Species <span class="text-red-400">*</span></label>
                        <select id="form-species" name="species_id" required autocomplete="off">
                            <option value="">Search Species...</option>
                            @foreach($speciesList as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ ucfirst($s->default_element) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Row 2: Element Indicator (Readonly) & Vivid Form selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Element (Auto-filled)</label>
                        <input type="text" id="form-element-display" readonly placeholder="Select Species first..." class="w-full bg-gray-900/50 cursor-not-allowed p-3 rounded-lg text-emerald-400 font-semibold border border-gray-700 outline-none select-none">
                        <span class="text-xs text-gray-500 mt-1 block">Determined by Species default element or Deviant form box.</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Vivid Form</label>
                        <select id="form-vivid" name="vivid_form_id" autocomplete="off">
                            <option value="">-- Normal Appearance --</option>
                            @foreach($vividForms as $vivid)
                                <option value="{{ $vivid->id }}">[{{ strtoupper($vivid->box_type) }}] {{ $vivid->name }} ({{ ucfirst($vivid->rarity) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Row 3: Stage & Level -->
                <div class="grid grid-cols-2 gap-6 pt-4 border-t border-gray-700/50">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Stage <span class="text-red-400">*</span></label>
                        <input type="number" name="stage" value="{{ old('stage') }}" min="1" placeholder="e.g. 1" required class="w-full bg-gray-900 focus:bg-gray-700 p-3 rounded-lg text-white border border-gray-600 outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Level <span class="text-red-400">*</span></label>
                        <input type="number" name="level" value="{{ old('level') }}" min="1" placeholder="e.g. 1" required class="w-full bg-gray-900 focus:bg-gray-700 p-3 rounded-lg text-white border border-gray-600 outline-none transition-colors">
                    </div>
                </div>

                <!-- Row 4: Bonus Stats -->
                <div class="pt-6 border-t border-gray-700/50">
                    <h3 class="text-md font-bold text-yellow-400 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Bonus Stats
                    </h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Intensity</label>
                            <input type="number" name="intensity" value="{{ old('intensity') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-purple-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Clarity</label>
                            <input type="number" name="clarity" value="{{ old('clarity') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-purple-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Stability</label>
                            <input type="number" name="stability" value="{{ old('stability') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-purple-500 transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Row 5: Battle Stats -->
                <div class="pt-6 border-t border-gray-700/50">
                    <h3 class="text-md font-bold text-emerald-400 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Battle Stats
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">HP</label>
                            <input type="number" name="hp" value="{{ old('hp') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Focus</label>
                            <input type="number" name="focus" value="{{ old('focus') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Calm</label>
                            <input type="number" name="calm" value="{{ old('calm') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Speed</label>
                            <input type="number" name="speed" value="{{ old('speed') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Balance</label>
                            <input type="number" name="balance" value="{{ old('balance') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 mb-1.5">Strength</label>
                            <input type="number" name="strength" value="{{ old('strength') }}" placeholder="0" class="w-full bg-gray-900 focus:bg-gray-700 p-2.5 rounded text-white text-center border border-gray-700 focus:border-emerald-500 transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Favorite Checkbox & Submit Action -->
                <div class="pt-6 border-t border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <label class="flex items-center space-x-3 text-sm text-pink-400 font-semibold cursor-pointer select-none">
                        <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite') ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-600 text-pink-500 focus:ring-pink-500 focus:ring-offset-gray-900 bg-gray-700">
                        <span>â­ Lock as Favorite (Protect from Delete)</span>
                    </label>

                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-all transform active:scale-95">
                        Sprout New Pet
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- TomSelect scripts with database references for automatic element display -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data from backend for automatic Element filling
            const speciesData = @json($speciesList->pluck('default_element', 'id'));
            const vividData = @json($vividForms->pluck('box_type', 'id'));

            // Basic config for Searchable Dropdowns (TomSelect)
            const baseConfig = {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: 'Search or select...'
            };

            const tsSpecies = new TomSelect("#form-species", baseConfig);
            const tsVivid = new TomSelect("#form-vivid", baseConfig);

            // Auto-fill element preview based on species & vivid selections
            function autoFillElement() {
                const speciesId = tsSpecies.getValue();
                const vividId = tsVivid.getValue();
                const displayEl = document.getElementById('form-element-display');

                if (!speciesId) {
                    displayEl.value = '';
                    return;
                }

                let elementToSet = speciesData[speciesId];

                // If a vivid form is selected, check its box type to determine if it is a Deviant
                if (vividId && vividData[vividId]) {
                    const boxType = vividData[vividId];
                    if (boxType !== 'void') {
                        elementToSet = 'Deviant ' + boxType.charAt(0).toUpperCase() + boxType.slice(1);
                    } else {
                        elementToSet = elementToSet.charAt(0).toUpperCase() + elementToSet.slice(1);
                    }
                } else if (elementToSet) {
                    elementToSet = elementToSet.charAt(0).toUpperCase() + elementToSet.slice(1);
                }

                displayEl.value = elementToSet || '';
            }

            // Bind selection change events
            tsSpecies.on('change', autoFillElement);
            tsVivid.on('change', autoFillElement);
        });
    </script>
    @include("components.hotkeys")
</body>
</html>
