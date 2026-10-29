<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-outfit">
            {{ __('Validation Rules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card shadow-sm sm:rounded-[1.25rem] p-6 lg:p-8">
                <div class="mb-8">
                    <h3 class="text-[1.75rem] font-bold text-gray-900 font-outfit">Statistical Validation Rules</h3>
                    <p class="text-gray-500 text-[0.875rem]">Configure the mathematical thresholds used by the engine to flag abnormal results.</p>
                </div>

                @if (session()->has('message'))
                    <div class="mb-6 bg-blue-50 border border-blue-200 text-[#2563EB] px-4 py-3 rounded-xl relative">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit="saveSettings" class="space-y-6 max-w-2xl">
                    
                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 font-outfit">Standard Deviation Anomalies</h4>
                        
                        <div class="mb-4">
                            <label class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Medium Severity Outlier (Z-Score)</label>
                            <p class="text-xs text-gray-500 mb-2">Flag a result as suspicious if it is this many standard deviations away from the class mean.</p>
                            <input type="number" step="0.1" wire:model="stdDevOutlier" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5">
                            @error('stdDevOutlier') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[0.875rem] font-semibold text-gray-700 mb-1">High Severity Outlier (Z-Score)</label>
                            <p class="text-xs text-gray-500 mb-2">Flag a result as HIGH severity if it is this many standard deviations away from the class mean.</p>
                            <input type="number" step="0.1" wire:model="highSeverityStdDev" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5">
                            @error('highSeverityStdDev') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 font-outfit">Suspicious CA vs Exam Ratios</h4>
                        
                        <div class="mb-4">
                            <label class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Suspicious CA Percentage (%)</label>
                            <p class="text-xs text-gray-500 mb-2">Flag if the Continuous Assessment score is greater than this percentage...</p>
                            <input type="number" step="1" wire:model="suspiciousCaPercent" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5">
                            @error('suspiciousCaPercent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Suspicious Exam Percentage (%)</label>
                            <p class="text-xs text-gray-500 mb-2">...AND the final exam score is less than this percentage.</p>
                            <input type="number" step="1" wire:model="suspiciousExamPercent" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5">
                            @error('suspiciousExamPercent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-primary flex items-center justify-center gap-2 py-3 px-8 rounded-xl text-white font-semibold">
                            <span wire:loading.remove wire:target="saveSettings">Save Configuration</span>
                            <span wire:loading wire:target="saveSettings">Saving...</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
