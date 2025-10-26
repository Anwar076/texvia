<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Company Profile') }}
            </h2>
            @if($company)
                <a href="{{ route('company.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Profile
                </a>
            @endif
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
                    @if($company)
                        <div class="space-y-6">
                            <!-- Company Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Company Name</label>
                                        <div class="mt-1 text-lg text-gray-900">{{ $company->name }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Industry</label>
                                        <div class="mt-1 text-lg text-gray-900">{{ $company->industry }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tone of Voice</label>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 capitalize">
                                                {{ $company->tone_of_voice }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($company->keywords)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Keywords</label>
                                        <div class="mt-1 flex flex-wrap gap-2">
                                            @foreach($company->keywords as $keyword)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-sm font-medium bg-gray-100 text-gray-800">
                                                    {{ $keyword }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Profile Meta -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Profile Details</h4>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p><strong>Created:</strong> {{ $company->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    @if($company->updated_at != $company->created_at)
                                    <p><strong>Last Updated:</strong> {{ $company->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- How This Helps -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-medium text-blue-900 mb-2">How This Improves Your Content</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• AI uses your company name and industry for relevant context</li>
                                    <li>• Content matches your preferred tone of voice</li>
                                    @if($company->keywords)
                                    <li>• Keywords are naturally incorporated into generated content</li>
                                    @endif
                                    <li>• All content is tailored specifically for your business needs</li>
                                </ul>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">
                                    ← Back to Dashboard
                                </a>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('content.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Generate Content
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">🏢</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No company profile yet</h3>
                            <p class="text-gray-600 mb-6">Set up your company profile to get personalized AI-generated content.</p>
                            <a href="{{ route('company.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Company Profile
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>