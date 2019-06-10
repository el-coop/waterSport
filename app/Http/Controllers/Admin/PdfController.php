<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Pdf\DestroyPdfRequest;
use App\Http\Requests\Admin\Pdf\StorePdfRequest;
use App\Http\Requests\Admin\Pdf\UpdatePdfRequest;
use App\Models\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PdfController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$pdfs = Pdf::all();
		return view('admin.filesystem.show', compact('pdfs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StorePdfRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePdfRequest $request) {
		return $request->commit();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Pdf $pdf
	 * @return void
	 */
	public function show(Pdf $pdf) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Pdf $pdf
	 * @return void
	 */
	public function edit(Pdf $pdf) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdatePdfRequest $request
	 * @param  \App\Models\Pdf $pdf
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePdfRequest $request, Pdf $pdf) {
		return $request->commit();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyPdfRequest $request
	 * @param  \App\Models\Pdf $pdf
	 * @return void
	 */
	public function destroy(DestroyPdfRequest $request, Pdf $pdf) {
		$request->commit();
		return [
			'success' => true
		];
	}
}
