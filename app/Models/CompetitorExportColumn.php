<?php

namespace App\Models;

use ElCoop\HasFields\Models\Field;
use Illuminate\Database\Eloquent\Model;

class CompetitorExportColumn extends Model {


	static public function options(){
		$options = collect([
			'user.name' => __('global.name'),
			'user.last_name' => __('global.lastName'),
			'user.email' => __('global.email'),
		]);
		Field::where('form', Competitor::class)->get()->each(function ($competitorColumn) use ($options){
			$options->put('competitor.' . $competitorColumn->id, $competitorColumn->name_nl);
		});
		return $options;
	}
}
