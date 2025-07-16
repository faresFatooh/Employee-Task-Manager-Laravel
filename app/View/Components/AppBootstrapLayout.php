<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppBootstrapLayout extends Component
{
    /**
     * The header content.
     *
     * @var string|null
     */
    public $header; // تعريف الخاصية هنا

    /**
     * Create a new component instance.
     */
    public function __construct($header = null) // استلام المتغير في الـ constructor
    {
        $this->header = $header; // تعيين القيمة للخاصية
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.app-bootstrap');
    }
}