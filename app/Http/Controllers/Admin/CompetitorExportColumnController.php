<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CompetitorExportColumn\CreateCompetitorExportColumnRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\DestroyCompetitorExportColumnRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\ExportSportByDateRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\OrderCompetitorExportColumnRequest;
use App\Http\Requests\Admin\CompetitorExportColumn\UpdateCompetitorExportColumnRequest;
use App\Models\CompetitionDay;
use App\Models\CompetitorExportColumn;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Services\CompetitorService;
use App\Services\SportDateService;
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
        $sports = Sport::all();
        $sportOptions = $sports->pluck('name', 'id');
        $sportsField = collect([
            'value' => $sportOptions->keys()->first(),
            'name' => 'sport',
            'type' => 'select',
            'label' => __('sports.sport'),
            'options' => $sportOptions
        ]);
        $dateTypes = collect([
            0 => __('sports.competitionDates'),
            1 => __('practiceDays.practiceDays')
        ]);
        $sportDates = $sports->mapWithKeys(function ($sport) {
            return [$sport->id => [
                0 => $sport->competitionDays->mapWithKeys(function ($date) {
                    return [$date->id => $date->start_time->format('d/m/Y H:i')];
                }),
                1 => $sport->practiceDays->mapWithKeys(function ($date) {
                    return [$date->id => $date->start_time->format('d/m/Y H:i')];
                })
            ]
            ];
        });
        return view('admin.exportColumns.show', compact('options', 'alreadySelected', 'downloadAction', 'addAction', 'title', 'btn', 'sportsField', 'sportDates', 'dateTypes'));
    }
    
    public function create(CreateCompetitorExportColumnRequest $request) {
        return $request->commit();
    }
    
    public function update(UpdateCompetitorExportColumnRequest $request, CompetitorExportColumn $competitorExportColumn) {
        return $request->commit();
    }
    
    public function destroy(DestroyCompetitorExportColumnRequest $request, CompetitorExportColumn $competitorExportColumn) {
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
    
    public function exportSportDate(ExportSportByDateRequest $request, Excel $excel) {
        $sport = Sport::find($request->input('sport'));
        $filename = "{$sport->name}";
    
        if ($request->input('date') > 0) {
            if ($request->input('dateType') == 0) {
                $exportObject = CompetitionDay::find($request->input('date'));
            } else {
                $exportObject = PracticeDay::find($request->input('date'));
            }
            $filename .= $exportObject->start_time->format('d m Y H:i');
        } else {
            $exportObject = $sport;
        }
        
        $sportDateService = new SportDateService($exportObject);
        return $excel->download($sportDateService, "{$filename}.xls");
    }
}
