<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate New Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-800">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('content.store') }}" class="space-y-6">
                        @csrf

                        <!-- Content Type -->
                        <div>
                            <x-input-label for="type" :value="__('Content Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select content type...</option>
                                <option value="blog" {{ request('type') === 'blog' ? 'selected' : '' }}>Blog Post</option>
                                <option value="post" {{ request('type') === 'post' ? 'selected' : '' }}>Social Media Post</option>
                                <option value="email" {{ request('type') === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="seo_page" {{ request('type') === 'seo_page' ? 'selected' : '' }}>SEO Page</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Enter the title for your content..." />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Prompt -->
                        <div>
                            <x-input-label for="prompt" :value="__('Content Prompt')" />
                            <textarea id="prompt" name="prompt" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Describe what you want the AI to write about. Be specific about the topic, target audience, key points to cover, etc.">{{ old('prompt') }}</textarea>
                            <x-input-error :messages="$errors->get('prompt')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-600">
                                Tip: The more specific you are, the better the AI-generated content will be. Include details about your target audience, key points to cover, and desired tone.
                            </p>
                        </div>

                        <!-- Company Context (if available) -->
                        @if($company)
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">Company Context</h4>
                            <p class="text-sm text-blue-800">
                                The AI will use your company profile to personalize the content:
                            </p>
                            <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                <li><strong>Company:</strong> {{ $company->name }}</li>
                                <li><strong>Industry:</strong> {{ $company->industry }}</li>
                                <li><strong>Tone:</strong> {{ $company->tone_of_voice }}</li>
                                @if($company->keywords)
                                <li><strong>Keywords:</strong> {{ implode(', ', $company->keywords) }}</li>
                                @endif
                            </ul>
                        </div>
                        @else
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <strong>Tip:</strong> <a href="{{ route('company.create') }}" class="underline font-medium">Set up your company profile</a> to get more personalized AI-generated content.
                            </p>
                        </div>
                        @endif

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Generate Content') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>