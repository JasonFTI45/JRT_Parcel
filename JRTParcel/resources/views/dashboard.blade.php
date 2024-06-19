<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        Hello, {{ Auth::user()->name }}!
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        Hello, {{ Auth::user()->name }}!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
