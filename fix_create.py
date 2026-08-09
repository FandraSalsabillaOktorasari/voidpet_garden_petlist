import re

with open('resources/views/pets/create.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
for line in lines:
    if 'name="is_favorite"' in line and "old('is_favorite')" in line:
        new_lines.append('                        <input type="checkbox" name="is_favorite" value="1" {{ old(\'is_favorite\') ? \'checked\' : \'\' }} class="w-5 h-5 rounded border-gray-600 text-pink-500 focus:ring-pink-500 focus:ring-offset-gray-900 bg-gray-700">\n')
    elif 'Lock as Favorite (Protect from Delete)' in line:
        new_lines.append('                        <span>⭐ Lock as Favorite (Protect from Delete)</span>\n')
    else:
        new_lines.append(line)

with open('resources/views/pets/create.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(new_lines)
