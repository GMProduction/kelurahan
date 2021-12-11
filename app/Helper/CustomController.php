<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomController extends Controller
{

    protected $validationRules = [];

    protected $validationMessage = [];

    /** @var Request $request */
    protected $request;

    /**
     * CustomController constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    public function checkValidation(Request $request)
    {
        $data = $request->all();

        return Validator::make($data, $this->getValidationRules(), $this->getValidationMessage());
    }

    public function isAuth($credentials = [])
    {
        if (count($credentials) > 0 && Auth::attempt($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * @param mixed $validationRules
     *
     * @return CustomController
     */
    public function setValidationRules($validationRules)
    {
        $this->validationRules = $validationRules;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationMessage()
    {
        return $this->validationMessage;
    }

    /**
     * @param mixed $validationMessage
     *
     * @return CustomController
     */
    public function setValidationMessage($validationMessage)
    {
        $this->validationMessage = $validationMessage;

        return $this;
    }

    public function postField($key)
    {
        return $this->request->request->get($key);
    }

    public function field($key)
    {
        return $this->request->query->get($key);
    }

    public function jsonResponse($msg = '', $status = 200, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'payload' => $data
        ], $status);
    }

    public function uploadImage($field, $targetName = '', $disk = 'upload')
    {
        $file = $this->request->file($field);
        return Storage::disk($disk)->put($targetName, File::get($file));
    }
}
