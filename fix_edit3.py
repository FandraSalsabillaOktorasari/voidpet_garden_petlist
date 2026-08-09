import sys

with open('resources/views/pets/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("request()->routeIs('pets.duplicates') ??? 'bg-gray", "request()->routeIs('pets.duplicates') ? 'bg-gray")
content = content.replace('????', '🪴')

with open('resources/views/pets/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
