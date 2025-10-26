<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setup Company Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Company Information</h3>
                        <p class="text-gray-600">
                            Set up your company profile to get more personalized AI-generated content. This information will be used to tailor the content to your business needs.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('company.store') }}" class="space-y-6">
                        @csrf

                        <!-- Company Name -->
                        <div>
                            <x-input-label for="name" :value="__('Company Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Enter your company name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Industry -->
                        <div>
                            <x-input-label for="industry" :value="__('Industry')" />
                            <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry" :value="old('industry')" required placeholder="e.g., Technology, Healthcare, Retail, Consulting" />
                            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-600">
                                What industry does your company operate in? This helps the AI understand your business context.
                            </p>
                        </div>

                        <!-- Tone of Voice -->
                        <div>
                            <x-input-label for="tone_of_voice" :value="__('Tone of Voice')" />
                            <select id="tone_of_voice" name="tone_of_voice" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select your preferred tone...</option>
                                <option value="professional" {{ old('tone_of_voice') === 'professional' ? 'selected' : '' }}>Professional</option>
                                <option value="friendly" {{ old('tone_of_voice') === 'friendly' ? 'selected' : '' }}>Friendly</option>
                                <option value="casual" {{ old('tone_of_voice') === 'casual' ? 'selected' : '' }}>Casual</option>
                                <option value="authoritative" {{ old('tone_of_voice') === 'authoritative' ? 'selected' : '' }}>Authoritative</option>
                                <option value="conversational" {{ old('tone_of_voice') === 'conversational' ? 'selected' : '' }}>Conversational</option>
                                <option value="formal" {{ old('tone_of_voice') === 'formal' ? 'selected' : '' }}>Formal</option>
                            </select>
                            <x-input-error :messages="$errors->get('tone_of_voice')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-600">
                                How would you like your content to sound? This affects the writing style of all generated content.
                            </p>
                        </div>

                        <!-- Keywords -->
                        <div>
                            <x-input-label for="keywords" :value="__('Keywords (Optional)')" />
                            <x-text-input id="keywords" class="block mt-1 w-full" type="text" name="keywords" :value="old('keywords')" placeholder="keyword1, keyword2, keyword3" />
                            <x-input-error :messages="$errors->get('keywords')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-600">
                                Enter important keywords for your business, separated by commas. The AI will try to naturally incorporate these into your content.
                            </p>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">💡 Pro Tip</h4>
                            <p class="text-sm text-blue-800">
                                The more specific and accurate your company profile, the better the AI will be at generating content that matches your brand voice and business needs.
                            </p>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">
                                Skip for now
                            </a>
                            <x-primary-button>
                                {{ __('Save Company Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>