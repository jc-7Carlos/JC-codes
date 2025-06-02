<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Bienvenido al Dashboard</h1>

                <!-- Mensajes de éxito o error -->
                <div class="mb-4">
                    @if(session('success'))
                        <div class="bg-green-500 text-black p-4 rounded">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-500 text-white p-4 rounded">{{ session('error') }}</div>
                    @endif
                </div>

                <!-- Botón Actualizar Tabla -->
                <form action="{{ route('actualizar.tabla') }}" method="POST">
                    @csrf
                    <button type="submit" style="background-color: rgb(72, 255, 0); color: black; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                        Actualizar Tabla
                    </button>
                </form>
                
               
               
            </div>
        </div>
    </div>
</x-app-layout>


