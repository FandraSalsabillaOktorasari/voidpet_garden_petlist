<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voidpet Garden - Plant Vivid Forms</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4B5563; }

        /* Masonry Grid for Plants */
        .masonry {
            column-count: 1;
            column-gap: 2rem;
        }
        @media (min-width: 768px) { .masonry { column-count: 2; } }
        @media (min-width: 1024px) { .masonry { column-count: 3; } }
        .masonry > div { break-inside: avoid; margin-bottom: 2rem; }

        /* Custom Checkbox Styling */
        .form-checkbox {
            appearance: none;
            background-color: #1f2937;
            margin: 0;
            font: inherit;
            color: currentColor;
            width: 1.15em;
            height: 1.15em;
            border: 1px solid #4b5563;
            border-radius: 0.15em;
            display: grid;
            place-content: center;
        }

        .form-checkbox::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em #34d399; /* emerald-400 */
            background-color: #34d399;
            transform-origin: bottom left;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        .form-checkbox:checked::before {
            transform: scale(1);
        }

        .form-checkbox:checked {
            border-color: #34d399;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen pb-12 font-sans">

    <!-- Header Section -->
    <header class="bg-gray-800 border-b border-gray-700 p-6 mb-8 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <span class="text-4xl">🪴</span>
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Plant Tracking</h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex space-x-4 overflow-x-auto pb-2">
                <a href="{{ route('pets.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Pet Collection</a>
                <a href="{{ route('people.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">People (Food Tracking)</a>
                <a href="{{ route('plants.index') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium border border-gray-700 shadow-inner shrink-0">Plant Vivid Forms</a>
                <a href="{{ route('pets.checklist') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors shrink-0">Pet Checklist</a>
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

        <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
            <!-- Global Plant Search -->
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="global-plant-search" onkeyup="searchGlobalPlants(this.value)" placeholder="Search plant species..."
                    class="bg-gray-800 border border-gray-600 text-white pl-10 pr-3 py-2 rounded-lg text-sm focus:outline-none focus:border-cyan-500 w-full transition-colors shadow-sm">
            </div>

            <!-- Quick Add Plant Form -->
            <form action="{{ route('plants.store') }}" method="POST" class="flex gap-2 w-full md:w-auto">
                @csrf
                <input type="text" name="name" placeholder="New Plant Name..." required class="bg-gray-800 border border-gray-600 text-white px-3 py-2 rounded-lg text-sm focus:outline-none focus:border-emerald-500 w-48">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    Add Plant
                </button>
            </form>
            @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        @if($allVividForms->isEmpty())
            <div class="text-center text-gray-500 p-8 border border-gray-700 border-dashed rounded-lg">
                <p class="mb-2">⚠️ No Vivid Forms found in the database.</p>
                <p class="text-sm">Please make sure the species seeder has been run to populate the master Vivid Forms data.</p>
            </div>
        @elseif($plants->isEmpty())
            <div class="text-center text-gray-500 p-8 border border-gray-700 border-dashed rounded-lg bg-gray-800/50">
                <p>No plants have been added yet. Use the input field above to add your first plant!</p>
            </div>
        @else
            <!-- Using Grid instead of Masonry/Columns to strictly enforce 3 items per row and avoid jumping layouts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start" id="plants-container">
                @foreach($plants as $plant)
                    <div class="plant-card bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700" data-name="{{ strtolower($plant->name) }}">
                        <!-- Card Header -->
                        <div class="p-4 bg-gray-800/80 border-b border-gray-700/50 flex justify-between items-center group">
                            <h3 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-cyan-400">
                                {{ $plant->name }}
                            </h3>

                            <div class="flex items-center gap-3">
                                @php
                                    $ownedCount = $plant->vividForms->count();
                                    $totalCount = $allVividForms->count();
                                    $percentage = $totalCount > 0 ? round(($ownedCount / $totalCount) * 100) : 0;
                                @endphp
                                <span class="text-xs font-mono {{ $ownedCount == $totalCount ? 'text-emerald-400 font-bold' : 'text-gray-400' }}">
                                    {{ $ownedCount }} / {{ $totalCount }} ({{ $percentage }}%)
                                </span>

                                <form action="{{ route('plants.destroy', $plant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plant and all its tracking data?');" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-400" title="Delete Plant">
                                        <svg class="w-4 h-4" transform="scale(1.1)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Checklists -->
                        <div class="p-4">
                            <!-- Search Form (Javascript Only) -->
                            <div class="mb-3">
                                <input type="text" onkeyup="searchForms('plant-{{ $plant->id }}', this.value)" placeholder="Search vivid forms..." class="w-full bg-gray-900 focus:bg-gray-700 text-white px-3 py-1.5 rounded text-xs border border-gray-600 focus:border-cyan-500 outline-none transition-colors">
                            </div>

                            <form action="{{ route('plants.updateVividForms', $plant->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @php
                                    // Make a simple array of IDs for quick checking in the loop
                                    $ownedVividFormIds = $plant->vividForms->pluck('id')->toArray();

                                    // Group vivid forms by box type for organized display
                                    $groupedForms = $allVividForms->groupBy('box_type');
                                @endphp

                                <!-- Set strict height (h-[400px]) so the box never shrinks when elements are hidden -->
                                <div class="space-y-4 h-[400px] overflow-y-auto pr-2" id="plant-{{ $plant->id }}">
                                    @foreach($groupedForms as $boxType => $forms)
                                        <div class="form-group bg-gray-900/50 rounded-lg p-3 border border-gray-700/50">
                                            <h4 class="group-title text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 border-b border-gray-700/50 pb-1 flex justify-between">
                                                <span>{{ ucfirst($boxType) }}</span>
                                                <span class="text-gray-600 font-mono">{{ count(array_intersect($forms->pluck('id')->toArray(), $ownedVividFormIds)) }}/{{ $forms->count() }}</span>
                                            </h4>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @foreach($forms as $form)
                                                    <label class="form-item flex items-center space-x-2 text-sm cursor-pointer hover:bg-gray-800/80 p-1.5 rounded transition-colors group">
                                                        <input type="checkbox" name="vivid_forms[]" value="{{ $form->id }}"
                                                            class="form-checkbox cursor-pointer"
                                                            {{ in_array($form->id, $ownedVividFormIds) ? 'checked' : '' }}>
                                                        <span class="form-name group-hover:text-emerald-300 {{ in_array($form->id, $ownedVividFormIds) ? 'text-gray-200' : 'text-gray-500' }}">
                                                            {{ $form->name }}
                                                        </span>
                                                        <span class="text-[9px] uppercase font-mono px-1.5 py-0.5 rounded
                                                            {{ $form->rarity == 'Absurd' ? 'bg-pink-500/20 text-pink-400' :
                                                              ($form->rarity == 'Mythical' ? 'bg-purple-500/20 text-purple-400' :
                                                              ($form->rarity == 'Fable' ? 'bg-blue-500/20 text-blue-400' : 'bg-gray-600/30 text-gray-400')) }}">
                                                            {{ substr($form->rarity, 0, 3) }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="w-full mt-4 bg-gray-700 hover:bg-emerald-600 hover:text-white text-gray-300 transition-colors py-2.5 rounded-lg text-xs font-bold shadow-sm border border-gray-600 hover:border-emerald-500">
                                    Save Checklist
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script>
        // Search filter for global plants
        function searchGlobalPlants(query) {
            query = query.toLowerCase().trim();
            const cards = document.querySelectorAll('.plant-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search filter inside specific vivid forms
        function searchForms(containerId, searchQuery) {
            const container = document.getElementById(containerId);
            const query = searchQuery.toLowerCase().trim();
            const groups = container.querySelectorAll('.form-group');

            groups.forEach(group => {
                const items = group.querySelectorAll('.form-item');
                let hasVisibleItem = false;

                items.forEach(item => {
                    const name = item.querySelector('.form-name').textContent.toLowerCase();
                    if (name.includes(query)) {
                        item.style.display = ''; // Show
                        hasVisibleItem = true;
                    } else {
                        item.style.display = 'none'; // Hide
                    }
                });

                // If no items are visible in this specific group (box type), hide the entire group
                if (hasVisibleItem) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
