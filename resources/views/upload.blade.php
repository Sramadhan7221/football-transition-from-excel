<form action="{{ route('excel.download') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel_file" required>
    <button type="submit">Upload</button>
</form>
