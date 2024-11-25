<?php
/**
 * Assessment Title: Portfolio Part 3
 * Cluster:          Cluster - SaaS: Front-End Dev - ICT50220 (Advanced Programming)
 * Qualification:    ICT50220 Diploma of Information Technology (Back End Web Development)
 * Name:             Yui Migaki
 * Student ID:       20098757
 * Year/Semester:    2024/S2
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * This portfolio is based on a scenario where I am employed as a Junior Web Application Developer at RIoT Systems,
 * a Perth-based company specializing in IoT, Robotics, and Web Application systems. My task is to implement
 * a simple web application using PHP and elements of the MVC (Model-View-Controller) development methodology.
 * The process involves following a predefined set of steps, with opportunities to consult stakeholders or their representatives for guidance.
 * The ultimate goal is to develop a web application that aligns with the company's expertise in IoT, Robotics, and Web
 *
 */

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class FlashMessage extends Component
{

    public $data;
    public $message;
    public $type;
    public $bgColour;
    public $fgColour;
    public $fgText;
    public $bgText;
    public $icon;

    /**
     * Create a new component instance.
     */
    public function __construct($data)
    {
        $types = [
            'error' => [
                'icon' => 'fa-solid fa-triangle-exclamation', 'fgColour' => 'text-white', 'bgColour' => 'bg-red-600',
                'fgText' => 'text-red-900', 'bgText' => 'bg-red-100',
            ],
            'success' => [
                'icon' => 'fa-solid fa-circle-check', 'fgColour' => 'text-white', 'bgColour' => 'bg-green-600',
                'fgText' => 'text-green-900', 'bgText' => 'bg-green-100',
            ],
            'info' => [
                'icon' => 'fa-solid fa-circle-info', 'fgColour' => 'text-white', 'bgColour' => 'bg-sky-600',
                'fgText' => 'text-sky-900', 'bgText' => 'bg-sky-100',
            ],
            'warning' => [
                'icon' => 'fa-solid fa-circle-exclamation', 'fgColour' => 'text-white', 'bgColour' => 'bg-amber-600',
                'fgText' => 'text-amber-900', 'bgText' => 'bg-amber-100',
            ],
        ];

        foreach ($types as $type => $formats) {
            if ($data->has($type)) {
                $this->type = Str::title($type);
                $this->message = Str::title($data->get($type));
                $this->fgColour = $formats['fgColour'];
                $this->bgColour = $formats['bgColour'];
                $this->fgText = $formats['fgText'];
                $this->bgText = $formats['bgText'];
                $this->icon = $formats['icon'];
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flash-message');
    }
}
