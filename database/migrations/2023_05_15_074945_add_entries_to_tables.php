<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $departments = [
            'Human Resources',
            'Marketing',
            'Finance',
            'Operations',
            'Sales',
            'Information Technology',
        ];

        $designations = [
            'Manager',
            'Coordinator',
            'Analyst',
            'Specialist',
            'Executive',
        ];

        $departmentIds = [];
        foreach ($departments as $department) {
            $departmentId = DB::table('departments')->insertGetId(['name' => $department]);
            $departmentIds[] = $departmentId;
        }

        $designationIds = [];
        foreach ($designations as $designation) {
            $designationId = DB::table('designations')->insertGetId(['name' => $designation]);
            $designationIds[] = $designationId;
        }

        $users = [
            ['name' => 'Salih', 'email' => 'salih@gmail.com', 'phone_no' => '9061431494'],
            ['name' => 'Sinan', 'email' => 'sinan@gmail.com', 'phone_no' => '9061431495'],
            ['name' => 'Aman', 'email' => 'aman@gmail.com', 'phone_no' => '9061431496'],
        ];

        foreach ($users as $user) {
            $departmentId = $departmentIds[array_rand($departmentIds)];
            $designationId = $designationIds[array_rand($designationIds)];

            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'phone_no' => $user['phone_no'],
                'department_id' => $departmentId,
                'designation_id' => $designationId,
                'password' => mt_rand(100000, 999999)
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->truncate();
        DB::table('designations')->truncate();
        DB::table('departments')->truncate();
    }
};
