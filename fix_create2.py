import sys

with open('resources/views/pets/create.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
for line in lines:
    if "request()->routeIs('pets.duplicates')" in line:
        line = line.replace('â­ ', '?')
        line = line.replace('â­', '?')
    
    # Also fix the weird emojis in headers
    if 'ðŸª´' in line:
        line = line.replace('ðŸª´', '🪴')
        
    new_lines.append(line)

with open('resources/views/pets/create.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(new_lines)
