<h3>Import Products</h3>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.import.upload') }}">
@csrf
<input type="file" name="file" />
<button>Upload</button>
</form>
<p>Download sample: <a href="/products_sample_import.csv">products_sample_import.csv</a></p>
