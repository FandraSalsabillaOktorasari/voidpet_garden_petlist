import sys

with open('resources/views/pets/edit.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
for line in lines:
    if "request()->routeIs('pets.duplicates')" in line:
        line = line.replace('⭐', '?')
        
    new_lines.append(line)

with open('resources/views/pets/edit.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(new_lines)
