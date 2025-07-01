<form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel_file" required>
    <button type="submit">Upload</button>
</form>
