<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;
use Storage;

class ResourceController extends Controller {
	public function view(Pdf $pdf) {
		return Storage::response("public/pdf/{$pdf->file}");
	}
}
