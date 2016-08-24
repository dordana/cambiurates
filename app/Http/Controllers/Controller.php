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

    /**
     * @param $view
     * @param array $params
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function view($view, $params = array())
    {

        $reflection = new \ReflectionClass(__CLASS__);
        $viewPath = str_replace($reflection->getNamespaceName(), '', static::class);
        $viewPath = strtolower(str_replace('\\', '.', substr($viewPath, 1)));
        $viewParam = strstr($viewPath, 'controller', true) ;

        if (view()->exists($viewParam. '.' . $view)) {

            return view($viewParam. '.' . $view, $params);
        } else {
            $viewParam = substr($viewParam, 0, strrpos($viewParam, '.'));
            if (view()->exists($viewParam . '.' . $view)) {

                return view($viewParam. '.' . $view, $params);
            }else{

                $viewParam = substr($viewParam, 0, strrpos($viewParam, '.'));
                return view($viewParam. '.' . $view, $params);
            }
        }
    }
}