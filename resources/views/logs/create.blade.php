@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl shadow-xl border border-gray-700 relative">
            <!-- Form status message -->
            <div id="statusMessage" class="hidden absolute top-4 right-4 p-4 rounded-lg text-sm"></div>

            <div class="p-6">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-white">Create Daily Log</h2>
                    <p class="mt-2 text-gray-400">Record your daily activities and thoughts</p>
                </div>

                <form action="{{ route('logs.store') }}" method="POST" class="space-y-6" id="logForm">
                    @csrf
                    
                    <div>
                        <label for="log" class="block text-sm font-medium text-gray-200">
                            Log Entry <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="mt-2 relative">
                            <textarea
                                name="log"
                                id="log"
                                rows="8"
                                class="block w-full rounded-lg border-0 bg-gray-700/50 text-white shadow-sm ring-1 ring-inset ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-blue-500 placeholder:text-gray-400 sm:text-sm sm:leading-6 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                placeholder="What would you like to log today?"
                                required
                                maxlength="2000"
                                aria-describedby="log-error"
                            >{{ old('log') }}</textarea>

                            <!-- Loading spinner (hidden by default) -->
                            <div id="saveIndicator" class="hidden absolute top-2 right-2">
                                <div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-500 border-t-transparent"></div>
                            </div>
                        </div>

                        <div class="mt-2 flex justify-between items-center text-sm">
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-400" id="charCount">
                                    <span id="currentCount">0</span>/2000 characters
                                </span>
                                <span id="saveStatus" class="text-gray-400 text-xs"></span>
                            </div>
                            @error('log')
                                <span class="text-red-400" id="log-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center gap-4 pt-4">
                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 text-white font-medium rounded-lg transition duration-200 flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submitButton"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Log
                        </button>
                        
                        <a
                            href="{{ route('logs.index') }}"
                            class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-200 flex items-center"
                            id="cancelButton"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('logForm');
    const textarea = document.getElementById('log');
    const currentCount = document.getElementById('currentCount');
    const charCount = document.getElementById('charCount');
    const submitButton = document.getElementById('submitButton');
    const cancelButton = document.getElementById('cancelButton');
    const saveStatus = document.getElementById('saveStatus');
    const saveIndicator = document.getElementById('saveIndicator');
    
    let lastSavedContent = '';

    function updateCharacterCount() {
        const count = textarea.value.length;
        currentCount.textContent = count;
        
        if (count >= 1800) {
            charCount.classList.remove('text-gray-400');
            charCount.classList.add('text-yellow-400');
        } else {
            charCount.classList.remove('text-yellow-400');
            charCount.classList.add('text-gray-400');
        }

        // Enable/disable submit button based on content
        submitButton.disabled = count === 0;
    }

    function saveToLocalStorage() {
        const content = textarea.value;
        if (content !== lastSavedContent) {
            localStorage.setItem('logDraft', content);
            lastSavedContent = content;
            
            saveIndicator.classList.remove('hidden');
            setTimeout(() => {
                saveIndicator.classList.add('hidden');
                saveStatus.textContent = 'Draft saved';
                setTimeout(() => {
                    saveStatus.textContent = '';
                }, 2000);
            }, 500);
        }
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        submitButton.disabled = true;
        localStorage.removeItem('logDraft');
    });

    // Autosave functionality
    let saveTimeout;
    textarea.addEventListener('input', function() {
        updateCharacterCount();
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveToLocalStorage, 1000);
    });

    // Restore draft if exists
    const savedDraft = localStorage.getItem('logDraft');
    if (savedDraft && !textarea.value) {
        textarea.value = savedDraft;
        lastSavedContent = savedDraft;
        updateCharacterCount();
    }

    // Initial character count
    updateCharacterCount();

    // Handle beforeunload
    window.addEventListener('beforeunload', function(e) {
        if (textarea.value && textarea.value !== lastSavedContent) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Clear draft on successful submission
    if (window.location.search.includes('success')) {
        localStorage.removeItem('logDraft');
    }
});
</script>
@endpush
@endsection