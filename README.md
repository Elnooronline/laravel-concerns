# Laravel Concerns
The components that make up the [Elnooronline](https://www.elnooronline.com/)'s Laravel Projects.

### Install 
```bash
composer require elnooronline/laravel-concerns
```
### Configuration
1. Import `\Elnooronline\LaravelConcerns\Http\Controllers\Helpers` trait in your base controller class
```php
<?php

namespace App\Http\Controllers;

use Elnooronline\LaravelConcerns\Http\Controllers\Helpers;
...
class Controller extends BaseController
{
    use Helpers;
    ...
}
```
This feature enables to use `flash()` and `getResourceName()` methods.
* `flash()` : This method will set flash session with localed message.
	* example :
	```php
	public function store(Request $request)
	{
		// Handle store
	
		$this->>flash('created'); // returns : trans('%RESOURCE_NAME%.messages.created').
	
		return view('home');
	}
	```
* `getResourceName()` : This method returns the resource name of the specified crud used in `Controller`, `Request`, `Model`.
	* example : If you have `UserController` class will returns `users`. and you can add custom resource name by adding `$resourceName` property.
	```
	class UserController extends Controller 
	{
		public function index()
		{
			return $this->getResourceName();
			// returns : users
		}
	}
	class UserController extends Controller 
	{
		/**
		 * The controller resource name.
		 *
		 * @return string
		 */
		protected $resourceName = 'persons';
		
		public function index()
		{
			return $this->getResourceName();
			// returns : persons
		}
	}
	```
2. All `Request` classes should extends `\Elnooronline\LaravelConcerns\Http\RequestsFormRequest` class.
#### API :
* `getResourceName()`
* `parseLocale()`
	*  example : 
	```
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->parseLocale([
			'name:{default}' => 'required|string|max:255',
			'name:{lang}' => 'nullable|string|max:255',
		]);
	}
	```
	insted of 
	```
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		// The default locale is "en" in this example
		return [
			'name:en' => 'required|string|max:255',
			'name:ar' => 'nullable|string|max:255',
			'name:fr' => 'nullable|string|max:255',
		];
	}
	```
* `getAproperRules()`
	* example :
	```
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->getAproperRules();
	}
	
	/**
	 * The rules of create request.
	 *
	 * @return array
	 */
	public function createRules()
	{
		return [];
	}
	
	/**
	 * The rules of update request.
	 *
	 * @return array
	 */
	public function updateRules()
	{
		return [];
	}
	```

