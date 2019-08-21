<?php

namespace App\Services;

use App;
use App\Models\CompetitionDay;
use App\Models\Competitor;
use App\Models\CompetitorExportColumn;
use App\Models\PracticeDay;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SportDateService implements FromCollection, WithHeadings {

	use  Exportable;
	private $object;
	public function __construct( $object) {
		$this->object = $object;
	}

	public function headings(): array {
		$headers = CompetitorExportColumn::orderBy('order')->get()->pluck('name');
		return $headers->toArray();
	}


	public function collection() {
		$fields = CompetitorExportColumn::orderBy('order')->get()->pluck('column');
		$data = collect();
		foreach ($this->object->competitors as $competitor){
			$data->push($this->listCompetitorData($fields,$competitor));
		}
		return $data;
	}

	protected function listCompetitorData($fields, Competitor $competitor) {
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
		return $result;
	}
}
