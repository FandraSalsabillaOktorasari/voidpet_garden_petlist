<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voidpet Garden - Pet Checklist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4B5563; }
        
        .box-void { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        .box-water { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .box-metal { background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%); }
        .box-fire { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .box-earth { background: linear-gradient(135deg, #a16207 0%, #854d0e 100%); }
        .box-wood { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
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
                <a href="{{ route('pets.index') }}" class="{{ request()->routeIs('pets.index') ? 'bg-gray-900 text-white border-gray-700 shadow-inner' : 'text-gray-400 hover:text-white border-transparent hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium border transition-colors shrink-0">Pet Collection</a>
                <a href="{{ route('pets.duplicates') }}" class="{{ request()->routeIs('pets.duplicates') ? 'bg-gray-900 text-white border-gray-700 shadow-inner' : 'text-gray-400 hover:text-white border-transparent hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium border transition-colors shrink-0">Duplicate Pets</a>
                <a href="{{ route('people.index') }}" class="{{ request()->routeIs('people.index') ? 'bg-gray-900 text-white border-gray-700 shadow-inner' : 'text-gray-400 hover:text-white border-transparent hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium border transition-colors shrink-0">People (Food Tracking)</a>
                <a href="{{ route('plants.index') }}" class="{{ request()->routeIs('plants.index') ? 'bg-gray-900 text-white border-gray-700 shadow-inner' : 'text-gray-400 hover:text-white border-transparent hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium border transition-colors shrink-0">Plant Vivid Forms</a>
                <a href="{{ route('pets.checklist') }}" class="{{ request()->routeIs('pets.checklist') ? 'bg-gray-900 text-white border-gray-700 shadow-inner' : 'text-gray-400 hover:text-white border-transparent hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium border transition-colors shrink-0">Pet Checklist</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 p-4 rounded-lg mb-8 shadow-sm">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-lg mb-8 shadow-sm">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
        
        <div class="mb-8 bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Species Checklist</h2>
                    <p class="text-gray-400">Lacak progres pet yang telah kamu kumpulkan. Hijau berarti kamu sudah memiliki kombinasi spesies dan vivid form tersebut.</p>
                </div>
                
                <!-- Sync Species Baru -->
                <form action="{{ route('species.sync') }}" method="POST" class="mt-4 md:mt-0 md:mr-3">
                    @csrf
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Cek Species Baru
                    </button>
                </form>

                <!-- Filter Form -->
                <form action="{{ route('pets.checklist') }}" method="GET" class="mt-4 md:mt-0 flex items-center space-x-3 bg-gray-900 p-2 rounded-lg border border-gray-700">
                    <label for="box_type" class="text-sm font-medium text-gray-400 pl-2">Filter Form:</label>
                    <select name="box_type" id="box_type" class="bg-gray-800 text-white text-sm rounded-md border border-gray-600 px-3 py-1.5 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">All Forms</option>
                        <option value="regular" {{ $selectedBoxType == 'regular' ? 'selected' : '' }}>Regular (No Form)</option>
                        @foreach($boxTypes as $type)
                            <option value="{{ $type }}" {{ $selectedBoxType == $type ? 'selected' : '' }} class="capitalize">{{ $type }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 rounded-md text-sm font-medium transition-colors">
                        Apply
                    </button>
                    @if($selectedBoxType)
                        <a href="{{ route('pets.checklist') }}" class="text-gray-400 hover:text-white px-2 py-1.5 text-sm transition-colors">Clear</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3 bg-gray-900 border border-gray-700 font-semibold sticky left-0 z-10 w-48 shadow-[2px_0_5px_rgba(0,0,0,0.5)]">Species</th>
                            
                            @if(empty($selectedBoxType) || $selectedBoxType === 'regular')
                            <th class="p-3 bg-gray-900 border border-gray-700 font-semibold text-center w-24">Regular<br><span class="text-xs text-gray-500 font-normal">No Form</span></th>
                            @endif
                            
                            @foreach($groupedVividForms as $boxType => $forms)
                                @foreach($forms as $form)
                                <th class="p-3 border border-gray-700 text-center min-w-[120px] 
                                    @if($boxType == 'void') bg-indigo-900/40 
                                    @elseif($boxType == 'water') bg-blue-900/40 
                                    @elseif($boxType == 'metal') bg-gray-700/40 
                                    @elseif($boxType == 'fire') bg-red-900/40 
                                    @elseif($boxType == 'earth') bg-yellow-900/40 
                                    @elseif($boxType == 'wood') bg-green-900/40 
                                    @else bg-gray-900 @endif">
                                    <div class="text-sm font-bold">{{ $form->name }}</div>
                                    <div class="text-xs text-gray-400 capitalize">{{ $form->box_type }} - {{ $form->rarity }}</div>
                                </th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($speciesList as $species)
                        <tr class="hover:bg-gray-700/50 transition">
                            <td class="p-3 border border-gray-700 font-medium sticky left-0 z-10 bg-gray-800 shadow-[2px_0_5px_rgba(0,0,0,0.3)]">
                                {{ $species->name }}
                            </td>
                            
                            @if(empty($selectedBoxType) || $selectedBoxType === 'regular')
                            <td class="p-3 border border-gray-700 text-center">
                                @if(isset($ownedMap[$species->id]['regular']))
                                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @else
                                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-gray-600 border border-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                @endif
                            </td>
                            @endif

                            @foreach($groupedVividForms as $boxType => $forms)
                                @foreach($forms as $form)
                                <td class="p-3 border border-gray-700 text-center">
                                    @if(isset($ownedMap[$species->id][$form->id]))
                                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @else
                                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-gray-600 border border-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </div>
                                    @endif
                                </td>
                                @endforeach
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
