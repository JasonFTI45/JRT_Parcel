@props(['id', 'name', 'label', 'items' => [], 'placeholder', 'disabled' => false, 'defaultText' => '', 'required' => false])

<div 
    x-data="{
            search: '{{ $defaultText }}',
            open: false,
            items: {{ json_encode($items) }},

            get filteredItems() {
                if (!this.search.trim()) {
                    return [];
                }
                return this.items.filter(
                    i => i.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            handleInput() {
                this.open = this.search.length > 0;
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
        :class="{'bg-gray-100 text-gray-500 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}, 'bg-white': !{{ $disabled ? 'true' : 'false' }}}"
        class="py-3 px-4 w-1/2 rounded shadow font-thin focus:outline-none focus:shadow-lg focus:shadow-slate-200 duration-100 shadow-gray-100 mt-1"
        :disabled="{{ $disabled ? 'true' : 'false' }}"
        :readonly="{{ $disabled ? 'true' : 'false' }}"
        :required="{{ $required ? 'true' : 'false' }}"
    >
    
    <ul 
        x-show="open && filteredItems.length > 0" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute left-0 mt-2 w-1/2 bg-white border border-gray-300 rounded shadow-lg z-10"
    >
        <template x-for="item in filteredItems" :key="item">
            <li 
                class="w-full text-gray-700 p-4 cursor-pointer hover:bg-gray-100"
                x-text="item"
                x-on:click="search = item; open = false"
            ></li>
        </template>
    </ul>
</div>