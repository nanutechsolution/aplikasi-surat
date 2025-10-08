<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratMasuk>
 */
class SuratMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tanggal surat akan dibuat secara acak dalam 30 hari terakhir
        $tanggalSurat = $this->faker->dateTimeBetween('-30 days', 'now');

        return [
            'nomor_surat' => $this->faker->unique()->numerify('SM/2023/###'),
            'tanggal_surat' => $tanggalSurat,
            // Tanggal diterima dibuat setelah tanggal surat, maks 3 hari setelahnya
            'tanggal_diterima' => $this->faker->dateTimeBetween($tanggalSurat, strtotime('+3 days')),
            'pengirim' => $this->faker->company(),
            'perihal' => $this->faker->sentence(6),
            'sifat_surat' => $this->faker->randomElement(['Biasa', 'Penting', 'Segera', 'Rahasia']),
            'file_path' => 'dummy-file.pdf', // Kita gunakan path palsu
            'user_id' => 1, // Pastikan ada user dengan ID 1 di tabel users Anda
        ];
    }
}
