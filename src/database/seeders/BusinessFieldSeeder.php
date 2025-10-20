<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessField;

class BusinessFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessFields = [
            [
                'code' => 'technology',
                'name' => 'Teknologi Informasi',
                'name_en' => 'Information Technology',
                'description' => 'Bidang yang berkaitan dengan pengembangan software, hardware, jaringan, dan sistem informasi',
                'icon' => 'fas fa-laptop-code',
                'color' => '#007bff',
                'sort_order' => 1,
                'metadata' => [
                    'keywords' => ['IT', 'software', 'programming', 'web development', 'mobile app'],
                    'popular' => true
                ]
            ],
            [
                'code' => 'finance',
                'name' => 'Keuangan & Perbankan',
                'name_en' => 'Finance & Banking',
                'description' => 'Bidang yang berkaitan dengan layanan keuangan, perbankan, investasi, dan asuransi',
                'icon' => 'fas fa-university',
                'color' => '#28a745',
                'sort_order' => 2,
                'metadata' => [
                    'keywords' => ['bank', 'finance', 'investment', 'insurance', 'fintech'],
                    'popular' => true
                ]
            ],
            [
                'code' => 'manufacturing',
                'name' => 'Manufaktur',
                'name_en' => 'Manufacturing',
                'description' => 'Bidang industri yang berkaitan dengan produksi barang dan manufaktur',
                'icon' => 'fas fa-industry',
                'color' => '#fd7e14',
                'sort_order' => 3,
                'metadata' => [
                    'keywords' => ['production', 'factory', 'industrial', 'automotive', 'electronics'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'healthcare',
                'name' => 'Kesehatan',
                'name_en' => 'Healthcare',
                'description' => 'Bidang yang berkaitan dengan layanan kesehatan, rumah sakit, dan farmasi',
                'icon' => 'fas fa-hospital',
                'color' => '#dc3545',
                'sort_order' => 4,
                'metadata' => [
                    'keywords' => ['hospital', 'pharmacy', 'medical', 'health tech', 'biotech'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'education',
                'name' => 'Pendidikan',
                'name_en' => 'Education',
                'description' => 'Bidang pendidikan, pelatihan, dan pengembangan sumber daya manusia',
                'icon' => 'fas fa-graduation-cap',
                'color' => '#6f42c1',
                'sort_order' => 5,
                'metadata' => [
                    'keywords' => ['school', 'university', 'training', 'e-learning', 'edtech'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'retail',
                'name' => 'Retail & E-commerce',
                'name_en' => 'Retail & E-commerce',
                'description' => 'Bidang perdagangan ritel, e-commerce, dan marketplace',
                'icon' => 'fas fa-shopping-cart',
                'color' => '#e83e8c',
                'sort_order' => 6,
                'metadata' => [
                    'keywords' => ['retail', 'ecommerce', 'marketplace', 'online shop', 'trading'],
                    'popular' => true
                ]
            ],
            [
                'code' => 'energy',
                'name' => 'Energi & Pertambangan',
                'name_en' => 'Energy & Mining',
                'description' => 'Bidang energi, minyak dan gas, pertambangan, dan energi terbarukan',
                'icon' => 'fas fa-bolt',
                'color' => '#ffc107',
                'sort_order' => 7,
                'metadata' => [
                    'keywords' => ['energy', 'oil', 'gas', 'mining', 'renewable energy'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'transportation',
                'name' => 'Transportasi & Logistik',
                'name_en' => 'Transportation & Logistics',
                'description' => 'Bidang transportasi, logistik, pengiriman, dan supply chain',
                'icon' => 'fas fa-truck',
                'color' => '#17a2b8',
                'sort_order' => 8,
                'metadata' => [
                    'keywords' => ['logistics', 'shipping', 'transportation', 'supply chain', 'delivery'],
                    'popular' => true
                ]
            ],
            [
                'code' => 'construction',
                'name' => 'Konstruksi & Properti',
                'name_en' => 'Construction & Property',
                'description' => 'Bidang konstruksi, real estate, dan pengembangan properti',
                'icon' => 'fas fa-building',
                'color' => '#6c757d',
                'sort_order' => 9,
                'metadata' => [
                    'keywords' => ['construction', 'real estate', 'property', 'architecture', 'civil engineering'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'media',
                'name' => 'Media & Komunikasi',
                'name_en' => 'Media & Communication',
                'description' => 'Bidang media, komunikasi, periklanan, dan industri kreatif',
                'icon' => 'fas fa-broadcast-tower',
                'color' => '#20c997',
                'sort_order' => 10,
                'metadata' => [
                    'keywords' => ['media', 'advertising', 'communication', 'creative', 'marketing'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'government',
                'name' => 'Pemerintahan',
                'name_en' => 'Government',
                'description' => 'Instansi pemerintah, BUMN, dan lembaga publik',
                'icon' => 'fas fa-landmark',
                'color' => '#495057',
                'sort_order' => 11,
                'metadata' => [
                    'keywords' => ['government', 'public service', 'BUMN', 'ministry', 'agency'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'consulting',
                'name' => 'Konsultan & Jasa Profesional',
                'name_en' => 'Consulting & Professional Services',
                'description' => 'Bidang konsultasi, jasa profesional, dan layanan bisnis',
                'icon' => 'fas fa-handshake',
                'color' => '#8e6a3a',
                'sort_order' => 12,
                'metadata' => [
                    'keywords' => ['consulting', 'professional service', 'business service', 'advisory'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'agriculture',
                'name' => 'Pertanian & Perikanan',
                'name_en' => 'Agriculture & Fisheries',
                'description' => 'Bidang pertanian, perkebunan, perikanan, dan agribisnis',
                'icon' => 'fas fa-seedling',
                'color' => '#198754',
                'sort_order' => 13,
                'metadata' => [
                    'keywords' => ['agriculture', 'farming', 'fisheries', 'agribusiness', 'plantation'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'tourism',
                'name' => 'Pariwisata & Perhotelan',
                'name_en' => 'Tourism & Hospitality',
                'description' => 'Bidang pariwisata, perhotelan, dan industri jasa wisata',
                'icon' => 'fas fa-plane',
                'color' => '#0dcaf0',
                'sort_order' => 14,
                'metadata' => [
                    'keywords' => ['tourism', 'hotel', 'hospitality', 'travel', 'leisure'],
                    'popular' => false
                ]
            ],
            [
                'code' => 'other',
                'name' => 'Lainnya',
                'name_en' => 'Other',
                'description' => 'Bidang usaha lainnya yang tidak termasuk dalam kategori di atas',
                'icon' => 'fas fa-ellipsis-h',
                'color' => '#adb5bd',
                'sort_order' => 99,
                'metadata' => [
                    'keywords' => ['other', 'miscellaneous', 'various'],
                    'popular' => false
                ]
            ]
        ];

        foreach ($businessFields as $field) {
            BusinessField::create($field);
            $this->command->info("Created business field: {$field['name']} ({$field['code']})");
        }
        
        $this->command->info("Created " . count($businessFields) . " business fields");
    }
}