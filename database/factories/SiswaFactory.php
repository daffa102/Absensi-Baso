<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\TahunAjar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique()->numerify('##########'),
            'nama' => $this->faker->name(),
            'kelas_id' => Kelas::factory(),
            'tahun_ajar_id' => TahunAjar::factory(),
        ];
    }
}
