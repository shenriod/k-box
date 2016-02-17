<?php namespace Klink\DmsMicrosites\Requests;

use KlinkDMS\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;
use KlinkDMS\Capability;
use Klink\DmsMicrosites\Microsite;

class MicrositeUpdateRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{

		$tests = [
            'title' => 'required|string',
            'slug' => array('required','string','regex:/[a-z\\-]+/'),
            'description' => 'sometimes|required|string',
            'logo' => 'sometimes|required|string|url|regex:/^https/',
            'hero_image' => 'sometimes|required|string|url|regex:/^https/',
            'default_language' => 'sometimes|required|string|regex:/^[a-z]{2}$/',
            'content' => 'required|array',
            'menu' => 'sometimes|required|array'
		];
        
        /* 
            content is a key-value array: key = language code, value MicrositeContent details
            $example = [
                'en' => [
                    'title' => 'Example page',
                    'slug' => 'Example page',
                    'content' => 'Example page content',
                ]
            ];
        */
        
        

		return $tests;
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        // user must be a project admin
        // user must be the same as the project owner
      
        $user = $this->user();
        
        if( !$user->can_capability(Capability::$PROJECT_MANAGER) ){
            return false;
        }
        
        $microsite_id = $this->route('microsites');
        
        try{
            
            $prj = Microsite::findOrFail($microsite_id);
            
            return $prj->user_id === $user->id;
            
        }catch(\Exception $e){
            return false;
        }
        
		return false;
	}

}
