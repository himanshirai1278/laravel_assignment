<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportProductsJob;

class ImportController extends Controller
{
    public function form()
    {
        return view('admin.import');
    }

    public function upload(Request $r)
    {
        $r->validate(['file'=>'required|file|mimes:csv,txt,xlsx,xls']);
        $path = $r->file('file')->store('imports');
        ImportProductsJob::dispatch($path);
        return back()->with('ok','Import queued.');
    }
}
