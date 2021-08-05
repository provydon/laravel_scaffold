<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $validationName)
    {
        if ($validationName && is_string($validationName) && strlen($validationName) > 0) {

            // request data
            $validationData = $request->all();

            // validation rules
            $validationRules = config("validations.rules.".$validationName, []);

            // initialize validation with request if is a function
            if(is_callable($validationRules)){
              $validationRules = $validationRules($request);
            }

            // get route parameters
            $routeParameters = $request->route()->parameters();

            // get request data
            $requestData = $request->all();

            // replace placeholders in rules with route params
            foreach ($routeParameters as $key => $value) {
                if(is_array($value)){
                    continue;
                }
                foreach($validationRules as $ruleKey => $rules){
                    $validationRules[$ruleKey] = str_replace("{" . $key . "}", $value, $validationRules[$ruleKey]);
                }
            }

            // replace placeholders in rules with request data
            foreach ($requestData as $key => $value) {
                if(is_array($value)){
                    continue;
                }
                foreach($validationRules as $ruleKey => $rules){
                    if($key === "authenticated_user"){
                        // replace "{authenticated_user}" with authenticated user id
                        $validationRules[$ruleKey] = str_replace(
                            "{" . $key . "}",
                            $value->id,
                            $validationRules[$ruleKey]
                        );
                        // move on to next step
                        continue;
                    }
                    $validationRules[$ruleKey] = str_replace("{" . $key . "}",$value, $validationRules[$ruleKey]);
                }
            }

            // validation messages
            $validationMessages = config("validations.messages", []);

            // validation
            $validation = Validator::make($validationData, $validationRules, $validationMessages);

            // checks for when validation fails.
            if ($validation->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation error.",
                    "type" => "validation_error",
                    "errors" => $validation->errors()->getMessages()
                ], 422);
            }
        }

        return $next($request);
    }
}
