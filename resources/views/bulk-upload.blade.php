<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <!-- Add the link to the Tailwind CSS stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">

    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-4">Product Management</h1>

        <ul class="flex mb-4">
            <li><a href="#" class="text-blue-500 hover:underline">Bulk Uploads</a></li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">Upload a File</h2>

        <form action="{{ route('bulk-upload.create') }}" method="post" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-2">
                <label for="file" class="block">Choose a file:</label>
                <input type="file" name="file" id="file" accept=".csv, .xlsx" class="border p-2 w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Upload</button>
        </form>

        @if ($errors->any())
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Validation Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-xl font-semibold mb-2">Uploaded Files</h2>
        <div id="file-table-container">
            @include('files')
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to update the table with the updated file list
        function updateTable() {
            $.ajax({
                url: "{{ route('get-updated-files') }}",
                type: 'GET',
                success: function(data) {
                    $('#file-table-container').html(data);
                }
            });
        }

        // Set an interval to update the table every 5 seconds (adjust as needed)
        setInterval(updateTable, 5000); // 5000 milliseconds = 5 seconds
    });
</script>
</body>
</html>
