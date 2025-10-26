<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $content->title }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($content->type === 'blog') bg-blue-100 text-blue-800
                    @elseif($content->type === 'post') bg-green-100 text-green-800
                    @elseif($content->type === 'email') bg-purple-100 text-purple-800
                    @else bg-orange-100 text-orange-800
                    @endif">
                    {{ ucfirst($content->type) }}
                </span>
                <a href="{{ route('content.edit', $content) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Content Meta -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div>
                                Created {{ $content->created_at->format('F j, Y \a\t g:i A') }}
                                @if($content->updated_at != $content->created_at)
                                    • Updated {{ $content->updated_at->format('F j, Y \a\t g:i A') }}
                                @endif
                            </div>
                            <div class="flex items-center space-x-4">
                                <button onclick="copyToClipboard()" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Copy Content
                                </button>
                                <form method="POST" action="{{ route('content.destroy', $content) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this content?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="prose prose-lg max-w-none">
                        <div id="content-body">
                            {!! nl2br(e($content->body)) !!}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('content.index') }}" class="text-gray-600 hover:text-gray-800">
                                ← Back to All Content
                            </a>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('content.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Generate New Content
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const content = document.getElementById('content-body').innerText;
            navigator.clipboard.writeText(content).then(function() {
                // Create a temporary notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50';
                notification.textContent = 'Content copied to clipboard!';
                document.body.appendChild(notification);
                
                // Remove notification after 3 seconds
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 3000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</x-app-layout>