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

namespace App\Models;

use Database\Factories\JokeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Joke extends Model
{
    /** @use HasFactory<JokeFactory> */
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'content',
        'category',
        'title',
        'tag',
        'role',
        'user_id'
    ];

    /**
     * Define a relationship to the parent user.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Define a relationship to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a many-to-many relationship to roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
