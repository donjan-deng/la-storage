<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Validators\Upload;
use Carbon\Carbon;

class IndexController extends Controller {

    public function index(Request $request) {
        return $request->user;
    }

    public function upload(Request $request) {
        $this->validate($request, Upload::rules(), Upload::messages(), Upload::attributes());
        $path = Storage::putFile(Carbon::now()->format('Y/m/d'), $request->file('file'));
        return ['code' => 200, 'message' => 'success', 'data' => $path];
    }

}
