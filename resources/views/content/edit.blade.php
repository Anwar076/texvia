<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('content.update', $content) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Content Type (readonly) -->
                        <div>
                            <x-input-label for="type" :value="__('Content Type')" />
                            <div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($content->type === 'blog') bg-blue-100 text-blue-800
                                    @elseif($content->type === 'post') bg-green-100 text-green-800
                                    @elseif($content->type === 'email') bg-purple-100 text-purple-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($content->type) }}
                                </span>
                            </div>
                        </div>

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $content->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Body -->
                        <div>
                            <x-input-label for="body" :value="__('Content')" />
                            <textarea id="body" name="body" rows="20" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('body', $content->body) }}</textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>

                        <!-- Meta Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Content Information</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Created:</strong> {{ $content->created_at->format('F j, Y \a\t g:i A') }}</p>
                                @if($content->updated_at != $content->created_at)
                                <p><strong>Last Updated:</strong> {{ $content->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('content.show', $content) }}" class="text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Content') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>