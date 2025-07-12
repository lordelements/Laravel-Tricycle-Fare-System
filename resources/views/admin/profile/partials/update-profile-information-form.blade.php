<section class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg"> {{-- Added padding, background, rounded corners, and shadow --}}
    <header class="mb-6"> {{-- Added margin-bottom for spacing --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center"> {{-- Increased font size, bold, and added flex for icon --}}
            <i class="fas fa-user-circle mr-3 text-purple-600"></i> {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-base text-gray-600 dark:text-gray-400"> {{-- Increased margin-top and font size for better readability --}}
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6"> {{-- Main form styling --}}
        @csrf
        @method('patch')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="name"> {{-- Added font-medium and mb-1 --}}
                {{ __('Name') }}
            </label>
            {{-- Assuming x-text-input is a Blade component that renders an <input> --}}
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" {{-- Professional input styling --}}
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="{{ __('Email') }}" class="mb-1" /> {{-- Added mb-1 --}}
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" {{-- Professional input styling --}}
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg text-yellow-800 dark:text-yellow-300"> {{-- Styled warning box for unverified email --}}
                    <p class="text-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="inline-flex items-center text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 hover:underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out ml-1"> {{-- Improved link styling with icon --}}
                            {{ __('Click here to re-send the verification email.') }} <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-medium text-sm text-green-600 dark:text-green-400">
                            <i class="fas fa-check-circle mr-2"></i> {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4"> {{-- Added pt-4 for spacing above buttons --}}
            {{-- Assuming x-primary-button is a Blade component for primary buttons --}}
            <x-primary-button class="px-5 py-2.5 shadow-md"> {{-- Larger padding and shadow for the button --}}
                <i class="fas fa-save mr-2"></i> {{ __('Save Changes') }} {{-- Added icon and more descriptive text --}}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 flex items-center font-medium" {{-- Changed color to green and added icon --}}
                >
                    <i class="fas fa-check mr-2"></i> {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>