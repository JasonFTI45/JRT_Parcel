@props(['id', 'name', 'label', 'items' => [], 'placeholder', 'disabled' => false, 'defaultText' => '', 'required' => false, 'value' => ''])

<div 
    x-data="{
            search: '{{ $defaultText }}',
            open: true,
            disabled: {{ $disabled ? 'true' : 'false' }},
            items: {{ json_encode($items) }},
            selectedItem: null,
            get filteredItems() {
                if (!this.search.trim() || this.disabled) {
                    return [];
                }
                const searchLower = this.search.toLowerCase();
                const filtered = this.items.filter(
                    i => i.toLowerCase().includes(searchLower)
                );
                filtered.sort();
                return filtered;
            },
            handleInput() {
                if (!this.disabled) {
                    this.open = this.search.length > 0;
                }
            },
            selectItem(item) {
                if (!this.disabled) {
                    this.search = item;
                    this.selectedItem = item;
                    this.open = false;
                }
            }
        }"
    class="relative"
>
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    
    <input 
        type="text" 
        x-on:input="handleInput" 
        x-on:focus="handleInput"
        x-on:blur="open = false"
        x-model="search" 
        placeholder="{{ $placeholder ?? 'Search Here...' }}" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        autocomplete="off"
        :class="{'bg-gray-100 text-gray-500 cursor-not-allowed': disabled, 'bg-white': !disabled}"
        class="py-3 px-4 w-full border-gray-300 rounded shadow font-thin focus:outline-none focus:shadow-lg focus:shadow-slate-200 duration-100 shadow-gray-100 mt-1"
        :disabled="disabled"
        :required="{{ $required ? 'true' : 'false' }}"
        :value="{{ $value }}"
    >
    @if ($disabled)
        <input type="hidden" name="{{ $name }}" x-bind:value="search">
    @endif
    <ul 
        x-show="open && filteredItems.length > 0 && !disabled" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded shadow-lg z-10 overflow-y-auto max-h-32"
    >
        <template x-for="item in filteredItems" :key="item">
            <li 
                class="w-full text-gray-700 p-4 cursor-pointer hover:bg-gray-100 "
                x-text="item"
                x-on:click="selectItem(item)"
            ></li>
        </template>
    </ul>
    <div x-show="open && filteredItems.length === 0 && search.trim().length > 0 && !disabled" class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded shadow-lg p-4 text-gray-700">
        No items found.
    </div>
</div>