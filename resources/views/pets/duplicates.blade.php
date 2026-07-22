<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voidpet Garden - Duplicate Pets</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tom Select (Alternative to Select2 for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* Modern Dark Mode Styling for TomSelect */
        .ts-control { background-color: #1f2937 !important; border: 1px solid #374151 !important; color: white !important; border-radius: 0.5rem !important; padding: 0.6rem !important; box-shadow: none !important;}
        .ts-control input { color: white !important; }
        .ts-control .item { color: white !important; display: inline-block; }
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
            </div>

            <!-- Navigation -->
            <nav class="flex space-x-4 overflow-x-auto pb-2">
                <a href="{{ route('pets.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Pet Collection</a>
                <a href="{{ route('pets.duplicates') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium border border-gray-700 shadow-inner shrink-0">Duplicate Pets</a>
                <a href="{{ route('people.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">People (Food Tracking)</a>
                <a href="{{ route('plants.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Plant Vivid Forms</a>
                <a href="{{ route('pets.checklist') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Pet Checklist</a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Flash Alert Messages -->
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

        <!-- Page Heading -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-gray-700/50 pb-5">
            <div>
                <h2 class="text-2xl font-bold text-white flex items-center mb-1">
                    <span class="mr-2">👯</span> Duplicate Pets
                </h2>
                <p class="text-gray-400 text-sm">View and manage pets that share the exact same species and form combination.</p>
            </div>
            <a href="{{ route('pets.create') }}" class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-all transform hover:-translate-y-0.5 inline-flex items-center text-sm shrink-0">
                <span class="mr-1.5">➕</span> Add New Pet
            </a>
        </div>

        <!-- Full-Width Collection Table Container -->
        <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900/50 border-b border-gray-700 text-gray-400 text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Species / Form</th>
                            <th class="px-6 py-4 whitespace-nowrap">Element</th>
                            <th class="px-6 py-4 whitespace-nowrap">Lvl / Stage</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap">Total Bonus Stat</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap">Total Battle Stat</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($duplicates as $groupKey => $group)
                            <!-- Group Header -->
                            <tr class="bg-gray-800/80">
                                <td colspan="7" class="px-6 py-3 border-l-4 border-emerald-500">
                                    @php 
                                        $firstPet = $group->first(); 
                                        $formName = $firstPet->vividForm ? $firstPet->vividForm->name : 'Normal';
                                    @endphp
                                    <div class="flex items-center space-x-2">
                                        <span class="font-bold text-emerald-400">{{ $firstPet->species->name }}</span>
                                        <span class="text-gray-400 text-sm">•</span>
                                        <span class="text-gray-300 text-sm">{{ $formName }}</span>
                                        <span class="ml-2 bg-gray-700 text-gray-300 py-0.5 px-2 rounded-full text-xs font-semibold">{{ $group->count() }} duplicates</span>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Group Members -->
                            @foreach($group as $pet)
                                @php
                                    $elements = is_string($pet->element) ? json_decode($pet->element, true) : $pet->element;
                                    if(!is_array($elements)) $elements = [$pet->element];
                                @endphp
                                <tr 
                                    onclick="openModal(this)"
                                    class="hover:bg-gray-700/30 cursor-pointer transition-colors duration-150"
                                    data-nickname="{{ $pet->nickname ?? $pet->species->name }}"
                                    data-species="{{ $pet->species->name }}"
                                    data-vivid-form="{{ $pet->vividForm ? $pet->vividForm->name : 'Normal' }}"
                                    data-level="{{ $pet->level }}"
                                    data-stage="{{ $pet->stage }}"
                                    data-elements='@json($elements)'
                                    data-favorite="{{ $pet->is_favorite ? '1' : '0' }}"
                                    data-intensity="{{ $pet->intensity }}"
                                    data-clarity="{{ $pet->clarity }}"
                                    data-stability="{{ $pet->stability }}"
                                    data-hp="{{ $pet->hp }}"
                                    data-focus="{{ $pet->focus }}"
                                    data-calm="{{ $pet->calm }}"
                                    data-speed="{{ $pet->speed }}"
                                    data-balance="{{ $pet->balance }}"
                                    data-strength="{{ $pet->strength }}"
                                    data-total-bonus="{{ $pet->total_bonus_stat }}"
                                    data-total-battle="{{ $pet->total_battle_stat }}"
                                    data-total-overall="{{ $pet->total_stat }}"
                                >
                                <td class="px-6 py-4.5">
                                    <div class="flex items-center space-x-2">
                                        @if($pet->is_favorite)
                                            <span class="text-pink-400" title="Locked / Favorited">⭐</span>
                                        @endif
                                        <span class="font-bold text-white text-sm">{{ $pet->nickname ?? $pet->species->name }}</span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4.5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-300">{{ $pet->species->name }}</span>
                                        @if($pet->vividForm)
                                            <span class="text-[11px] text-purple-400 font-bold tracking-wide">{{ $pet->vividForm->name }} Form ({{ ucfirst($pet->vividForm->rarity) }})</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4.5">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($elements as $el)
                                            @php
                                                $elLower = strtolower($el);
                                                $badgeClass = 'bg-blue-900/40 text-blue-300 border-blue-800/80';
                                                if (str_contains($elLower, 'fire')) {
                                                    $badgeClass = 'bg-red-900/40 text-red-300 border-red-800/80';
                                                } elseif (str_contains($elLower, 'water')) {
                                                    $badgeClass = 'bg-cyan-900/40 text-cyan-300 border-cyan-800/80';
                                                } elseif (str_contains($elLower, 'earth')) {
                                                    $badgeClass = 'bg-amber-900/40 text-amber-300 border-amber-800/80';
                                                } elseif (str_contains($elLower, 'wood')) {
                                                    $badgeClass = 'bg-emerald-900/40 text-emerald-300 border-emerald-800/80';
                                                } elseif (str_contains($elLower, 'metal')) {
                                                    $badgeClass = 'bg-indigo-900/40 text-indigo-300 border-indigo-800/80';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeClass }} border">
                                                {{ ucfirst($el) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-6 py-4.5 whitespace-nowrap">
                                    <div class="text-sm">
                                        <span class="text-gray-200 font-mono">Lvl {{ $pet->level }}</span>
                                        <span class="text-gray-500 text-xs block font-medium">Stage {{ $pet->stage }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4.5 text-center whitespace-nowrap">
                                    <span class="text-sm font-mono font-bold text-purple-400">
                                        {{ $pet->intensity + $pet->clarity + $pet->stability }}
                                    </span>
                                </td>

                                <td class="px-6 py-4.5 text-center whitespace-nowrap">
                                    <span class="text-sm font-mono font-bold text-emerald-400">
                                        {{ $pet->hp + $pet->focus + $pet->calm + $pet->speed + $pet->balance + $pet->strength }}
                                    </span>
                                </td>

                                <td class="px-6 py-4.5 text-right flex justify-end gap-2" onclick="event.stopPropagation();">
                                    <a href="{{ route('pets.edit', $pet->id) }}" class="text-blue-400 hover:text-blue-300 bg-blue-400/10 hover:bg-blue-400/20 p-2 rounded-lg transition-colors border border-blue-500/20" title="Edit Pet">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('Release this pet to the Void? (Favorited pets are protected)');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 bg-red-400/10 hover:bg-red-400/20 p-2 rounded-lg transition-colors border border-red-500/20" title="Release / Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 border-2 border-dashed border-gray-700/50 bg-gray-808/30 rounded-b-xl my-4">
                                    <span class="text-4xl block mb-3">✅</span>
                                    <h3 class="text-lg font-bold text-gray-300 mb-1">No Duplicates Found!</h3>
                                    <p class="text-sm">Every pet in your garden is unique.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </main>

    <!-- Modal Detail Pop-up -->
    <div id="pet-detail-modal" class="fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform duration-200 scale-95 opacity-0 transition-all flex flex-col" id="modal-container-panel">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-gray-700/50 flex justify-between items-center bg-gray-850">
                <div>
                    <div class="flex items-center space-x-2">
                        <span id="modal-favorite-star" class="text-pink-400 text-lg hidden">⭐</span>
                        <h2 class="text-xl font-extrabold text-white" id="modal-title">[Pet Nickname]</h2>
                    </div>
                    <p class="text-xs text-purple-400 font-semibold mt-0.5" id="modal-subtitle">[Species Name]</p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors bg-gray-700/55 hover:bg-gray-700 p-1.5 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
                
                <!-- Quick Info: Lvl, Stage, Elements -->
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-700/30">
                        <span class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold block mb-1">Level</span>
                        <span class="text-lg font-bold font-mono text-white" id="modal-level">0</span>
                    </div>
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-700/30">
                        <span class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold block mb-1">Stage</span>
                        <span class="text-lg font-bold font-mono text-white" id="modal-stage">0</span>
                    </div>
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-700/30 flex flex-col justify-center items-center">
                        <span class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold block mb-1">Element</span>
                        <div id="modal-elements-container" class="flex flex-wrap gap-1 justify-center"></div>
                    </div>
                </div>

                <!-- Bonus Stats -->
                <div>
                    <div class="flex justify-between items-center mb-3 border-b border-gray-700 pb-1.5">
                        <h3 class="text-sm font-bold text-purple-400 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Bonus Stats
                        </h3>
                        <span class="text-xs font-mono font-bold text-purple-400 bg-purple-500/10 px-2.5 py-0.5 rounded-full" id="modal-total-bonus">Total: 0</span>
                    </div>
                    <div class="bg-gray-900/55 rounded-lg p-4 grid grid-cols-3 gap-4 border border-gray-700/30">
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Intensity</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-intensity">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Clarity</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-clarity">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Stability</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-stability">0</span>
                        </div>
                    </div>
                </div>

                <!-- Battle Stats -->
                <div>
                    <div class="flex justify-between items-center mb-3 border-b border-gray-700 pb-1.5">
                        <h3 class="text-sm font-bold text-emerald-400 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Battle Stats
                        </h3>
                        <span class="text-xs font-mono font-bold text-emerald-500 bg-emerald-500/10 px-2.5 py-0.5 rounded-full" id="modal-total-battle">Total: 0</span>
                    </div>
                    <div class="bg-gray-900/55 rounded-lg p-4 grid grid-cols-3 gap-y-4 gap-x-2 border border-gray-700/30">
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">HP</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-hp">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Focus</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-focus">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Calm</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-calm">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Speed</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-speed">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Balance</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-balance">0</span>
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-gray-500 uppercase font-semibold block">Strength</span>
                            <span class="text-lg font-mono font-bold text-white mt-1 block" id="modal-stat-strength">0</span>
                        </div>
                    </div>
                </div>

                <!-- Overall Stat -->
                <div class="bg-gradient-to-r from-purple-950/40 to-indigo-950/40 rounded-lg border border-purple-500/20 p-4.5 flex justify-between items-center sm:px-6">
                    <div>
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Sum of All Stats</span>
                    </div>
                    <div>
                        <span class="text-2xl font-black font-mono text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400" id="modal-total-overall">0</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- TomSelect Initialization Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Konfigurasi dasar untuk plugin Searchable Dropdown kita (TomSelect)
            const baseConfig = {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: 'Show all...'
            };

            // ---- FORM FILTER FOR TABLE ----
            ['#search-species', '#search-element', '#search-vivid', '#search-rarity', '#search-box', '#search-sort'].forEach(function(selector) {
                new TomSelect(selector, baseConfig);
            });
        });

        // Detail Modal Pop-up Handlers
        function openModal(row) {
            const modal = document.getElementById('pet-detail-modal');
            const container = document.getElementById('modal-container-panel');
            
            // Set content from elements/data-attributes
            document.getElementById('modal-title').textContent = row.getAttribute('data-nickname');
            
            const species = row.getAttribute('data-species');
            const form = row.getAttribute('data-vivid-form');
            document.getElementById('modal-subtitle').textContent = form && form !== 'Normal' ? `${species} (${form} Form)` : `${species} (Normal Form)`;
            
            // Favorite status check
            const isFav = row.getAttribute('data-favorite') === '1';
            if (isFav) {
                document.getElementById('modal-favorite-star').classList.remove('hidden');
            } else {
                document.getElementById('modal-favorite-star').classList.add('hidden');
            }
            
            document.getElementById('modal-level').textContent = row.getAttribute('data-level');
            document.getElementById('modal-stage').textContent = row.getAttribute('data-stage');
            
            // Elements display with custom styles
            const elementsContainer = document.getElementById('modal-elements-container');
            elementsContainer.innerHTML = '';
            const elementsJson = JSON.parse(row.getAttribute('data-elements'));
            elementsJson.forEach(el => {
                const span = document.createElement('span');
                span.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-900/50 text-blue-300 border border-blue-700/50 border';
                
                const elLower = el.toLowerCase();
                if (elLower.includes('fire')) {
                    span.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-900/50 text-red-300 border border-red-700/50 border';
                } else if (elLower.includes('water')) {
                    span.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-cyan-900/50 text-cyan-300 border border-cyan-700/50 border';
                } else if (elLower.includes('earth')) {
                    span.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-900/50 text-amber-300 border border-amber-700/50 border';
                } else if (elLower.includes('wood')) {
                    span.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-900/50 text-emerald-300 border border-emerald-700/50 border';
                } else if (elLower.includes('metal')) {
                    span.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-900/50 text-indigo-300 border border-indigo-700/50 border';
                }
                
                span.textContent = el.charAt(0).toUpperCase() + el.slice(1);
                elementsContainer.appendChild(span);
            });
            
            // Set Stats values
            document.getElementById('modal-stat-intensity').textContent = row.getAttribute('data-intensity');
            document.getElementById('modal-stat-clarity').textContent = row.getAttribute('data-clarity');
            document.getElementById('modal-stat-stability').textContent = row.getAttribute('data-stability');
            
            document.getElementById('modal-stat-hp').textContent = row.getAttribute('data-hp');
            document.getElementById('modal-stat-focus').textContent = row.getAttribute('data-focus');
            document.getElementById('modal-stat-calm').textContent = row.getAttribute('data-calm');
            document.getElementById('modal-stat-speed').textContent = row.getAttribute('data-speed');
            document.getElementById('modal-stat-balance').textContent = row.getAttribute('data-balance');
            document.getElementById('modal-stat-strength').textContent = row.getAttribute('data-strength');
            
            // Totals
            document.getElementById('modal-total-bonus').textContent = 'Total: ' + row.getAttribute('data-total-bonus');
            document.getElementById('modal-total-battle').textContent = 'Total: ' + row.getAttribute('data-total-battle');
            document.getElementById('modal-total-overall').textContent = row.getAttribute('data-total-overall');
            
            // Open modal popup with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
                container.classList.add('scale-100', 'opacity-100');
            }, 20);
        }

        function closeModal() {
            const modal = document.getElementById('pet-detail-modal');
            const container = document.getElementById('modal-container-panel');
            
            container.classList.remove('scale-100', 'opacity-100');
            container.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }

        // Close on clicking modal backdrop/background
        document.getElementById('pet-detail-modal').addEventListener('click', function(e) {
            if(e.target === this) {
                closeModal();
            }
        });
    </script>
    @include("components.hotkeys")
</body>
</html>