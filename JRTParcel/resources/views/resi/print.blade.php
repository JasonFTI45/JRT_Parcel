<x-print-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight no-print">
            {{ __('Print Resi') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <!-- Updated Test div with a class for printing -->
                <div class="text-gray-900">
                    <p>test</p>
                </div>
            </div>
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded no-print">
                    {{ __('Print') }}
            </button>
        </div>
    </div>
</x-print-layout>
<script>
        window.onload = function() {
            window.print();
        }
    </script>