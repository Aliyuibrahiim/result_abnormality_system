<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-emerald-500">
                <div class="p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Current Session GPA</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($gpa, 2) }}</div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Cumulative GPA (CGPA)</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($cgpa, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                
                <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h3 class="text-xl font-bold">My Results</h3>
                    
                    <div class="mt-4 sm:mt-0 w-full sm:w-auto">
                        <select wire:model.live="selectedSessionId" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                            <option value="">-- Select Session --</option>
                            @foreach ($sessions as $session)
                                <option value="{{ $session->id }}">{{ $session->name }} - {{ $session->semester == 1 ? 'First Semester' : 'Second Semester' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if ($selectedSessionId)
                    @if (count($results) > 0)
                        <div class="overflow-x-auto border rounded-lg border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CA (30)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam (70)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($results as $result)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $result->course->code }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $result->course->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $result->course->unit_load }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $result->ca_score ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $result->exam_score ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $result->total_score ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-bold 
                                                @if($result->grade == 'A') text-green-600
                                                @elseif($result->grade == 'B') text-emerald-500
                                                @elseif($result->grade == 'C') text-blue-500
                                                @elseif($result->grade == 'D' || $result->grade == 'E') text-yellow-600
                                                @else text-red-600 @endif
                                            ">{{ $result->grade ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow">
                                Download PDF
                            </button>
                        </div>
                    @else
                        <div class="mt-4 p-8 text-center bg-gray-50 border rounded-lg text-gray-600">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Results Found</h3>
                            <p class="mt-1 text-sm text-gray-500">Your results for this session have not been uploaded yet.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
