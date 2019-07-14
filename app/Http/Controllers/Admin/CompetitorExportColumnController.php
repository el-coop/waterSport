<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CompetitorExportColumn\CreateCompetitorExportColumnRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\DestroyCompetitorExportColumnRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\OrderCompetitorExportColumnRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\UpdateCompetitorExportColumnRequest;
use App\Models\CompetitorExportColumn;
use App\Models\Sport;
use App\Services\CompetitorService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

class CompetitorExportColumnController extends Controller {
	public function show() {

		$options = CompetitorExportColumn::options();
		$alreadySelected = CompetitorExportColumn::orderBy('order')->get();
		$downloadAction = action('Admin\CompetitorExportColumnController@export');
		$addAction = action('Admin\CompetitorExportColumnController@create');
		$title = __('competitors.export');
		$btn = __('competitors.export');
		return view('admin.exportColumns.show', compact('options', 'alreadySelected', 'downloadAction', 'addAction', 'title', 'btn'));
	}

	public function create(CreateCompetitorExportColumnRequest $request) {
		return $request->commit();
	}

	public function update(UpdateCompetitorExportColumnRequest $request, CompetitorExportColumn $competitorExportColumn) {
		return $request->commit();
	}

	public function destroy(DestroyCompetitorExportColumnRequest $request, CompetitorExportColumn $competitorExportColumn){
		$request->commit();
		return [
			'success' => true
		];
	}

	public function saveOrder(OrderCompetitorExportColumnRequest $request) {
		$request->commit();
		return [
			'success' => true
		];
	}

	public function export(Excel $excel, CompetitorService $competitorService) {
		return $excel->download($competitorService, 'competitors.xls');
	}
}
