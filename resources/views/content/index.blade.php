<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Content') }}
            </h2>
            <a href="{{ route('content.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Generate New Content
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($contents->count() > 0)
                        <div class="space-y-4">
                            @foreach($contents as $content)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($content->type === 'blog') bg-blue-100 text-blue-800
                                                @elseif($content->type === 'post') bg-green-100 text-green-800
                                                @elseif($content->type === 'email') bg-purple-100 text-purple-800
                                                @else bg-orange-100 text-orange-800
                                                @endif">
                                                {{ ucfirst($content->type) }}
                                            </span>
                                            <span class="text-sm text-gray-500">{{ $content->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $content->title }}</h3>
                                        <p class="text-gray-600 text-sm">{{ Str::limit(strip_tags($content->body), 200) }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('content.show', $content) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                                        <a href="{{ route('content.edit', $content) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Edit</a>
                                        <form method="POST" action="{{ route('content.destroy', $content) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this content?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $contents->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">📝</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No content yet</h3>
                            <p class="text-gray-600 mb-6">Start generating AI-powered content for your business.</p>
                            <a href="{{ route('content.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Generate Your First Content
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>