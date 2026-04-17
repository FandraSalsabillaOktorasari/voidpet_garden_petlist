<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voidpet Garden - NPC Food Tracking</title>
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

        /* Grid Template for the forms */
        .masonry {
            column-count: 1;
            column-gap: 2rem;
        }
        @media (min-width: 768px) { .masonry { column-count: 2; } }
        @media (min-width: 1024px) { .masonry { column-count: 3; } }
        .masonry > div { break-inside: avoid; margin-bottom: 2rem; }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen pb-12 font-sans">

    <!-- Header Section -->
    <header class="bg-gray-800 border-b border-gray-700 p-6 mb-8 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <span class="text-4xl">👥</span>
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">People Tracking</h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex space-x-4">
                <a href="{{ route('pets.index') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Pet Collection</a>
                <a href="{{ route('people.index') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium border border-gray-700 shadow-inner">People (Food Tracking)</a>
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
            <p class="text-gray-400 text-sm flex-1">Track how each character reacts to different foods. Hit "Enter" in the food dropdown to create a new one instantly if it isn't listed!</p>
            <button onclick="document.getElementById('manage-foods-modal').classList.remove('hidden')" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Manage Dictionary
            </button>
        </div>

        <!-- MASONRY GRID UNTUK SEMUA 8 ORANG -->
        <div class="masonry">
            @foreach($people as $person)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700">

                    <!-- Header Kartu -->
                    <div class="p-4 bg-gray-800/80 border-b border-gray-700/50 flex justify-between items-center">
                        <h3 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                            {{ $person->name }}
                        </h3>
                        <span class="text-xs text-gray-500 font-mono">{{ $person->foods->count() }} Foods Tracked</span>
                    </div>

                    <div class="p-4">

                        <!-- Form Tambah/Update Makanan -->
                        <form action="{{ route('people.storeFood', $person->id) }}" method="POST" class="mb-5 bg-gray-900/50 p-3 rounded-lg border border-gray-700/50" autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1 block">Select / Create Food</label>
                                <!-- TOMSELECT INPUT UNTUK SEARCH + CREATE BARU -->
                                <select class="food-select" name="food_name" placeholder="E.g., Apple, Donut..." required autocomplete="off">
                                    <option value="">Search food or type new...</option>
                                    @foreach($foods as $f)
                                        <option value="{{ $f->name }}">{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 mb-1 block">Gift Val (+)</label>
                                    <input type="number" name="gift_value" value="0" required class="w-full bg-gray-900 focus:bg-gray-700 p-2 rounded text-sm text-center border border-emerald-900/50 focus:border-emerald-500 text-emerald-100 outline-none transition-colors">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-red-400 mb-1 block">Throw Val (-)</label>
                                    <input type="number" name="throw_value" value="0" required class="w-full bg-gray-900 focus:bg-gray-700 p-2 rounded text-sm text-center border border-red-900/50 focus:border-red-500 text-red-100 outline-none transition-colors">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-gray-700 hover:bg-gray-600 text-white transition-colors py-2 rounded text-xs font-bold shadow-sm">
                                Track / Update Status
                            </button>
                        </form>

                        <!-- List Makanan Tracker -->
                        @if($person->foods->count() > 0)
                            <div class="mt-2">
                                <details class="group bg-gray-900 border border-gray-700 rounded-lg overflow-hidden cursor-pointer">
                                    <summary class="flex justify-between items-center font-medium bg-gray-800/80 p-3 text-sm text-gray-300 select-none">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400 group-open:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            Tracked Foods ({{ $person->foods->count() }})
                                        </span>
                                        <select onclick="event.stopPropagation()" onchange="filterFoods('list-{{ $person->id }}', this.value)" class="bg-gray-900 border border-gray-600 text-xs rounded px-2 py-1 text-gray-300 outline-none hover:border-gray-500 transition-colors uppercase tracking-wider font-bold">
                                            <option value="all">View All</option>
                                            <option value="gift">Only Gift (+)</option>
                                            <option value="throw">Only Throw (-)</option>
                                        </select>
                                    </summary>

                                    <div class="max-h-64 overflow-y-auto px-2 pb-2 pt-1 cursor-default">
                                        <!-- Header Kolom -->
                                        <div class="grid grid-cols-12 gap-2 px-2 py-1.5 mb-1 text-[10px] font-bold uppercase tracking-wider text-gray-500 border-b border-gray-800">
                                            <div class="col-span-6">Food Name</div>
                                            <div class="col-span-2 text-center text-emerald-400/80">Gift</div>
                                            <div class="col-span-2 text-center text-red-400/80">Throw</div>
                                            <div class="col-span-2 text-right">Aksi</div>
                                        </div>

                                        <ul class="space-y-1 block" id="list-{{ $person->id }}">
                                            @foreach($person->foods as $food)
                                                <li class="food-item grid grid-cols-12 gap-2 px-2 py-1.5 rounded items-center bg-gray-800/50 hover:bg-gray-800 transition-colors" data-gift="{{ $food->pivot->gift_value }}" data-throw="{{ $food->pivot->throw_value }}">
                                                    <span class="col-span-6 text-sm font-medium text-gray-300 truncate" title="{{ $food->name }}">{{ $food->name }}</span>

                                                    <span class="col-span-2 flex justify-center">
                                                        <span class="flex items-center justify-center text-emerald-400 bg-emerald-400/10 px-1.5 py-0.5 rounded text-xs font-mono min-w-[3rem]" title="Gift Value">
                                                            {{ $food->pivot->gift_value > 0 ? '+'.$food->pivot->gift_value : $food->pivot->gift_value }}
                                                        </span>
                                                    </span>

                                                    <span class="col-span-2 flex justify-center">
                                                        <span class="flex items-center justify-center text-red-400 bg-red-400/10 px-1.5 py-0.5 rounded text-xs font-mono min-w-[3rem]" title="Throw Value">
                                                            {{ $food->pivot->throw_value > 0 ? '+'.$food->pivot->throw_value : $food->pivot->throw_value }}
                                                        </span>
                                                    </span>

                                                    <form class="col-span-2 flex justify-end" action="{{ route('people.destroyFood', [$person->id, $food->id]) }}" method="POST" onsubmit="return confirm('Hapus track makanan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-500 hover:text-red-400 p-1 rounded-md hover:bg-red-400/10 transition-colors" title="Un-track">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </details>
                            </div>
                        @else
                            <div class="text-center text-xs text-gray-500 py-4 italic">No food data recorded yet.</div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

    </main>

    @include('people.modal')

    <!-- Scripts -->
    <script>
        // Fungsi untuk filtering List Makanan
        function filterFoods(listId, filterType) {
            const items = document.querySelectorAll(`#${listId} .food-item`);
            items.forEach(item => {
                const gift = parseInt(item.getAttribute('data-gift'), 10) || 0;
                const throwVal = parseInt(item.getAttribute('data-throw'), 10) || 0;

                if (filterType === 'all') {
                    item.style.display = ''; // Kembalikan ke normal (grid)
                } else if (filterType === 'gift') {
                    item.style.display = (gift !== 0) ? '' : 'none';
                } else if (filterType === 'throw') {
                    item.style.display = (throwVal !== 0) ? '' : 'none';
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Apply TomSelect to all food selects across different person cards
            document.querySelectorAll('.food-select').forEach(function(el) {
                new TomSelect(el, {
                    create: true, // INI PENTING! MEMUNGKINKAN USER BIKIN FOOD BARU DARI KETIKAN
                    createOnBlur: true,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: 'Type or search food...'
                });
            });
        });
    </script>
</body>
</html>