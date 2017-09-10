<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function wantsJson()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->ajax() || $this->wantsJson()) {
            throw new ValidationException(
                $validator,
                new JsonResponse(['errors' => $this->formatErrors($validator), 'message' => trans('api.validation_errors'), 'error' => true], 200)
            );
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($this->formatErrors($validator), $this->errorBag);
    }

    /**
     * @param array $errors
     * @return $this|JsonResponse
     */
    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse(['error' => ['message' => trans('api_general.validation_errors')], 'validation' => $errors], 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

    /**
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse(['errors' => ['message' => trans('api_general.forbidden_response')], 'error' => true, 'message' => trans('api_general.need_authorize')], 403);
        }

        return parent::forbiddenResponse();
    }
}
