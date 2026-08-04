<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Entities\Faq;

class FaqController extends Controller
{
    protected $title = 'Faq';

    public function __construct(Faq $data) 
    {
        $this->data = $data;
        $this->view = 'template::';
        $this->prefix = 'faq';

        $this->toIndex = route('faq');
        $this->tCreate = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }
     
    public function index()
    {
        
        return view("template::faq.index");
    }
   
}
