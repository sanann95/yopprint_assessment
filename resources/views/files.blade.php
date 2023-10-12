<style>
    .progress {
        height: 20px;
    }

    .progress-bar {
        min-width: 2em;
    }
</style>
@if($models->count() > 0)
<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">File</th>
            <th class="px-4 py-2">File path</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Progress</th>
            <th class="px-4 py-2">Completed at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $model)
        <tr>
            <td class="px-4 py-2">{{ $model->created_at->format('d M Y h:i:s') }}</td>
            <td class="px-4 py-2">{{ $model->original_filename }}</td>
            <td class="px-4 py-2">{{ $model->filename }}</td>
            <td class="px-4 py-2">{{ $model->status }}</td>
            <td class="px-4 py-2">
            	<div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-200">
                                {{ $model->progress_percentage }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200">
                        <div style="width: {{ $model->progress_percentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                    </div>
                </div>
            </td>
            <td>{{ $model->completed_at_string }}</td>
        </tr>
        @endforeach 
    </tbody>
</table>
@else
<p>No Data</p>
@endif