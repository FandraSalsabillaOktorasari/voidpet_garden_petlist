<!-- Manage Master Foods Modal -->
<div id="manage-foods-modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Food Dictionary Master
            </h2>
            <button onclick="document.getElementById('manage-foods-modal').classList.add('hidden')" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Modal Body (List of items) -->
        <div class="p-6 overflow-y-auto flex-1">
            <p class="text-sm text-gray-400 mb-4">You can rename or delete foods globally from here. Note: Deleting a food will also remove it from ALL characters' tracking lists.</p>
            
            <div class="mb-4">
                <input type="text" id="food-search-input" placeholder="Search food by name..." class="w-full bg-gray-900 border border-gray-600 focus:border-indigo-500 rounded-lg px-4 py-2 text-white outline-none" onkeyup="filterFoods()">
            </div>
            
            <div class="space-y-3" id="food-list-container">
                @forelse($foods as $f)
                    <div class="food-item flex items-center justify-between bg-gray-900 border border-gray-700 p-3 rounded-lg" data-name="{{ strtolower($f->name) }}">
                        <!-- Update Form -->
                        <form action="{{ route('foods.update', $f->id) }}" method="POST" class="flex-1 flex items-center mr-4">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $f->name }}" required class="flex-1 bg-gray-800 border border-gray-600 focus:border-indigo-500 rounded px-3 py-1.5 text-sm text-white outline-none mr-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1.5 rounded text-xs font-semibold transition-colors">Update</button>
                        </form>
                        
                        <!-- Delete Form -->
                        <form action="{{ route('foods.destroy', $f->id) }}" method="POST" onsubmit="return confirm('SURE? Deleting \'{{ $f->name }}\' will remove it from every character\'s tracker as well!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500/20 hover:bg-red-500/40 text-red-400 px-3 py-1.5 rounded text-xs font-semibold transition-colors border border-red-500/30">Delete</button>
                        </form>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8 border-2 border-dashed border-gray-700 rounded-lg">
                        Dictionary is empty. Create new foods via the character tracking inputs first.
                    </div>
                @endforelse
            </div>
            
            <div id="no-food-results" class="hidden text-center text-gray-500 py-6 italic border border-gray-700 rounded-lg bg-gray-800/50 mt-3">
                No foods matched your search.
            </div>
        </div>
    </div>
</div>

<script>
function filterFoods() {
    let input = document.getElementById('food-search-input');
    let filter = input.value.toLowerCase();
    let foodsContainer = document.getElementById('food-list-container');
    let foodItems = foodsContainer.getElementsByClassName('food-item');
    let noResultsMsg = document.getElementById('no-food-results');
    
    let visibleCount = 0;
    
    for (let i = 0; i < foodItems.length; i++) {
        let name = foodItems[i].getAttribute('data-name');
        if (name.indexOf(filter) > -1) {
            foodItems[i].style.display = "";
            visibleCount++;
        } else {
            foodItems[i].style.display = "none";
        }
    }
    
    // Show/hide no results message
    if (visibleCount === 0 && foodItems.length > 0) {
        noResultsMsg.classList.remove('hidden');
    } else {
        noResultsMsg.classList.add('hidden');
    }
}
</script>
