<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\ClassRoom;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@darulabrar.edu.bd'],
            [
                'name' => 'মোহাম্মদ আব্দুল করিম',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '01712345678',
                'address' => 'দারুল আবরার মাদ্রাসা, ঢাকা',
                'is_active' => true,
            ]
        );

        // Create some departments
        $departments = [
            [
                'name' => 'ইসলামিক স্টাডিজ',
                'code' => 'IS',
                'head_of_department' => 'মাওলানা আব্দুর রহমান',
                'description' => 'কুরআন, হাদিস ও ইসলামিক শিক্ষা বিভাগ',
                'established_year' => 2010,
                'is_active' => true,
            ],
            [
                'name' => 'আরবি ভাষা ও সাহিত্য',
                'code' => 'ARAB',
                'head_of_department' => 'মাওলানা মোহাম্মদ আলী',
                'description' => 'আরবি ভাষা ও সাহিত্য শিক্ষা বিভাগ',
                'established_year' => 2012,
                'is_active' => true,
            ],
            [
                'name' => 'সাধারণ শিক্ষা',
                'code' => 'GEN',
                'head_of_department' => 'প্রফেসর মোহাম্মদ রহিম',
                'description' => 'গণিত, বিজ্ঞান ও সাধারণ বিষয় শিক্ষা বিভাগ',
                'established_year' => 2015,
                'is_active' => true,
            ],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Get department IDs
        $islamicDept = Department::where('code', 'IS')->first();
        $arabicDept = Department::where('code', 'ARAB')->first();
        $generalDept = Department::where('code', 'GEN')->first();

        // Create some classes
        $classes = [
            ['name' => 'হিফয বিভাগ - ১ম শ্রেণী', 'section' => 'A', 'capacity' => 30, 'department_id' => $islamicDept->id],
            ['name' => 'হিফয বিভাগ - ২য় শ্রেণী', 'section' => 'A', 'capacity' => 25, 'department_id' => $islamicDept->id],
            ['name' => 'কিতাব বিভাগ - ১ম বর্ষ', 'section' => 'A', 'capacity' => 40, 'department_id' => $arabicDept->id],
            ['name' => 'কিতাব বিভাগ - ২য় বর্ষ', 'section' => 'A', 'capacity' => 35, 'department_id' => $arabicDept->id],
            ['name' => 'কিতাব বিভাগ - ৩য় বর্ষ', 'section' => 'A', 'capacity' => 30, 'department_id' => $arabicDept->id],
            ['name' => 'আলিয়া বিভাগ - ১ম বর্ষ', 'section' => 'A', 'capacity' => 45, 'department_id' => $generalDept->id],
            ['name' => 'আলিয়া বিভাগ - ২য় বর্ষ', 'section' => 'A', 'capacity' => 40, 'department_id' => $generalDept->id],
        ];

        foreach ($classes as $class) {
            ClassRoom::create($class);
        }

        // Create basic settings
        $settings = [
            ['key' => 'madrasa_name', 'value' => 'দারুল আবরার মাদ্রাসা'],
            ['key' => 'madrasa_name_english', 'value' => 'Darul Abrar Madrasa'],
            ['key' => 'address', 'value' => 'মিরপুর, ঢাকা-১২১৬, বাংলাদেশ'],
            ['key' => 'phone', 'value' => '+880-2-9002123'],
            ['key' => 'email', 'value' => 'info@darulabrar.edu.bd'],
            ['key' => 'website', 'value' => 'https://darulabrar.edu.bd'],
            ['key' => 'established_year', 'value' => '2005'],
            ['key' => 'principal_name', 'value' => 'মাওলানা হাফেজ আব্দুল হালিম'],
            ['key' => 'total_students', 'value' => '850'],
            ['key' => 'total_teachers', 'value' => '45'],
            ['key' => 'vision', 'value' => 'ইসলামিক শিক্ষার আলোকে আদর্শ মানুষ গড়ে তোলা'],
            ['key' => 'mission', 'value' => 'কুরআন ও সুন্নাহর আলোকে সুশিক্ষিত ও আদর্শবান মুসলিম তৈরি করা'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        echo "✅ Admin user created: admin@darulabrar.edu.bd / password123\n";
        echo "✅ Departments, classes and settings have been seeded successfully!\n";
    }
}