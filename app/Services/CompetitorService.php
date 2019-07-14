<?php

namespace App\Services;

use App;
use App\Models\Competitor;
use App\Models\CompetitorExportColumn;
use App\Models\Sport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompetitorService implements FromCollection, WithHeadings {

	use  Exportable;

	public function headings(): array {
		$headers = CompetitorExportColumn::orderBy('order')->get()->pluck('name');
		$headers->push(__('sports.sport'));
		$headers->push(__('practiceDays.practiceDays'));
		$headers->push(__('sports.competitionDates'));
		return $headers->toArray();
	}


	public function collection() {
		$sports = Sport::all();
		$fields = CompetitorExportColumn::orderBy('order')->get()->pluck('column');
		$data = collect();
		foreach ($sports as $sport){
			foreach ($sport->competitors as $competitor){
				$data->push($this->listSportData($fields,$competitor,$sport));
			}
		}
		return $data;
	}

	protected function listSportData($fields, Competitor $competitor, Sport $sport) {
		$result = collect();
		foreach ($fields as $field) {
			$model = strtok($field, '.');
			$column = strtok('.');
			if ($model === 'user') {
				$result->push($competitor->user->$column);
			} else {
				$result->push($competitor->data[$column] ?? '');
			}
		}
		$result->push($sport->name);
		$result->push($competitor->getSportsPracticeDays($competitor->pivot->sport_id));
		$result->push($competitor->getSportCompetitionDays($competitor->pivot->sport_id));
		return $result;
	}
}
