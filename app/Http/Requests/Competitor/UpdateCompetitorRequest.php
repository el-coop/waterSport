<?php

namespace App\Http\Requests\Competitor;

use App\Events\CompetitorSubmitted;
use App\Models\CompetitionDay;
use App\Models\Competitor;
use App\Models\PracticeDay;
use ElCoop\HasFields\Models\Field;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitorRequest extends FormRequest {
    private $competitor;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $this->competitor = $this->user();
        if ($this->route('competitor')) {
            $this->competitor  = $this->route('competitor')->user;
        }
        
        $rules = collect([
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email," . $this->competitor->id],
            'language' => ['required', 'in:en,nl'],
            'sports.*.0' => 'required|exists:sports,id',
            'sports.*.practiceDays' => 'array',
            'sports.*.practiceDays.*' => 'exists:practice_days,id',
            'sports.*.competitionDays' => 'array',
            'sports.*.competitionDays.*' => 'exists:competition_days,id',
            'sports.*' => 'array',
        ]);
        
        $rules['competitor'] = 'required|array';
        $requiredFields = Field::getRequiredFields(Competitor::class);
        $protectedFields = Field::getProtectedFields(Competitor::class);
        $rules = $rules->merge($requiredFields)->merge($protectedFields);
        return $rules->toArray();
    }
    
    
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            foreach ($this->input('sports', []) as $data) {
                $data = collect($data);
                foreach ($data->get('practiceDays',[]) as $day) {
                    $dayEntry = PracticeDay::find($day);
                    if ($dayEntry && $dayEntry->isFull && !$dayEntry->competitors()->where('competitor_id',$this->competitor->user->id)->exists()) {
                        $validator->errors()->add('fullDays', __('practiceDays.full'));
                    }
                }
                
                foreach ($data->get('competitionDays',[]) as $day) {
                    $dayEntry = CompetitionDay::find($day);
                    if ($dayEntry && $dayEntry->isFull && !$dayEntry->competitors()->where('competitor_id',$this->competitor->user->id)->exists()) {
                        if (CompetitionDay::find($day)->isFull) {
                            $validator->errors()->add('fullDays', __('practiceDays.full'));
                        }
                    }
                }
            };
        });
    }
    
    public function commit() {
        
        $this->competitor->name = $this->input('name');
        $this->competitor->last_name = $this->input('lastName');
        $this->competitor->email = $this->input('email');
        $this->competitor->language = $this->input('language');
        $sports = collect();
        $this->competitor->user->practiceDays()->detach();
        $this->competitor->user->competitionDays()->detach();
        foreach ($this->input('sports', []) as $sport => $data) {
            $data = collect($data);
            $sports->put($sport, ['data' => $data->except('practiceDays', 0, 'competitionDays')]);
            $this->competitor->user->practiceDays()->attach($data->get('practiceDays'));
            $this->competitor->user->competitionDays()->attach($data->get('competitionDays'));
        }
        $this->competitor->user->sports()->sync($sports);
        $this->competitor->user->data = array_filter($this->input('competitor'));
        
        $this->session()->flash('fireworks', true);
        
        $this->competitor->user->save();
        $this->competitor->save();
    }
}
