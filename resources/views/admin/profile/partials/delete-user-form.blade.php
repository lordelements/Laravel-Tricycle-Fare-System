<section class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg"> {{-- Added padding, background, rounded corners, and shadow --}}
    <header class="mb-6"> {{-- Added margin-bottom for spacing --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center"> {{-- Increased font size, bold, and added flex for icon --}}
            <i class="fas fa-user-minus mr-3 text-red-600"></i> {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-base text-gray-600 dark:text-gray-400"> {{-- Increased margin-top and font size for better readability --}}
            {{ __('Once your account is deleted, all of its resources and data will be permanently removed. Before proceeding, please ensure you have downloaded any data or information you wish to retain.') }} {{-- Rephrased for clarity --}}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 text-base font-semibold shadow-md hover:scale-105 transition duration-150 ease-in-out" {{-- Enhanced button styling --}}
    >
        <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Account') }} {{-- Added icon --}}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('admin.profile.destroy') }}" class="p-8 space-y-6"> {{-- Increased padding and added space-y --}}
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center"> {{-- Larger, bolder title with icon --}}
                <i class="fas fa-exclamation-triangle mr-3 text-yellow-500"></i> {{ __('Confirm Account Deletion') }}
            </h2>

            <p class="text-base text-gray-600 dark:text-gray-400"> {{-- Larger font for better readability --}}
                {{ __('This action is irreversible. Once your account is deleted, all associated resources and data will be permanently removed. To confirm this permanent deletion, please enter your password below.') }} {{-- Rephrased for emphasis and clarity --}}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Your Password') }}" class="sr-only" /> {{-- Changed value for clarity --}}

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" {{-- Professional input styling --}}
                    placeholder="{{ __('Password for confirmation') }}" {{-- More descriptive placeholder --}}
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3"> {{-- Increased margin-top and used gap --}}
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 font-semibold shadow-sm hover:scale-105 transition duration-150 ease-in-out"> {{-- Enhanced button styling --}}
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="px-5 py-2.5 font-semibold shadow-md hover:scale-105 transition duration-150 ease-in-out"> {{-- Enhanced button styling --}}
                    <i class="fas fa-check-circle mr-2"></i> {{ __('I understand, Delete My Account') }} {{-- More explicit text and icon --}}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>