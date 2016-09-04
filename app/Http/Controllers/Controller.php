<?php
namespace App\Http\Controllers;

/**
 * Created by Yanko Diev.
 * User: ydiev
 * Date: 5/30/16
 * Time: 10:56 AM
 */
use Illuminate\Routing\Controller AS BaseController;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{

    protected $limit = 15;
    protected $module = '';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}