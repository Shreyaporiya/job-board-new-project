<?php
// database/seeders/SkillSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            ['name' => 'PHP', 'slug' => 'php', 'color' => '#4F5D95'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#FF2D20'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'color' => '#F7DF1E'],
            ['name' => 'Vue.js', 'slug' => 'vuejs', 'color' => '#4FC08D'],
            ['name' => 'React', 'slug' => 'react', 'color' => '#61DAFB'],
            ['name' => 'MySQL', 'slug' => 'mysql', 'color' => '#4479A1'],
            ['name' => 'HTML5', 'slug' => 'html5', 'color' => '#E34F26'],
            ['name' => 'CSS3', 'slug' => 'css3', 'color' => '#1572B6'],
            ['name' => 'Bootstrap', 'slug' => 'bootstrap', 'color' => '#7952B3'],
            ['name' => 'Git', 'slug' => 'git', 'color' => '#F05032'],
            ['name' => 'Docker', 'slug' => 'docker', 'color' => '#2496ED'],
            ['name' => 'AWS', 'slug' => 'aws', 'color' => '#FF9900'],
            ['name' => 'REST API', 'slug' => 'rest-api', 'color' => '#00A98F'],
            ['name' => 'GraphQL', 'slug' => 'graphql', 'color' => '#E10098'],
            ['name' => 'Tailwind CSS', 'slug' => 'tailwind-css', 'color' => '#06B6D4'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}