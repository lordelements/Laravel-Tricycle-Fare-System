<section class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg"> {{-- Added padding, background, rounded corners, and shadow --}}
    <header class="mb-6"> {{-- Added margin-bottom for spacing --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center"> {{-- Increased font size, bold, and added flex for icon --}}
            <i class="fas fa-key mr-3 text-red-600"></i> {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-base text-gray-600 dark:text-gray-400"> {{-- Increased margin-top and font size for better readability --}}
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('admin.password.update') }}" class="mt-6 space-y-6"> {{-- Main form styling --}}
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="{{ __('Current Password') }}" class="mb-1" /> {{-- Added mb-1 --}}
            {{-- Assuming x-text-input is a Blade component that renders an <input> --}}
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" {{-- Professional input styling --}}
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="{{ __('New Password') }}" class="mb-1" /> {{-- Added mb-1 --}}
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" {{-- Professional input styling --}}
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="{{ __('Confirm Password') }}" class="mb-1" /> {{-- Added mb-1 --}}
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" {{-- Professional input styling --}}
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4"> {{-- Added pt-4 for spacing above buttons --}}
            {{-- Assuming x-primary-button is a Blade component for primary buttons --}}
            <x-primary-button class="px-5 py-2.5 shadow-md"> {{-- Larger padding and shadow for the button --}}
                <i class="fas fa-save mr-2"></i> {{ __('Save New Password') }} {{-- Added icon and more descriptive text --}}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 flex items-center font-medium" {{-- Changed color to green and added icon --}}
                >
                    <i class="fas fa-check-circle mr-2"></i> {{ __('Password updated successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>