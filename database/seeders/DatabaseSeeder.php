<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('institute_info')->first() == null) {
            $numbers = json_encode(['01624*******', '01591*******']);
            $social = json_encode([["media" => "Facebook", "address" => "http://facebook.com"], ["media" => "Instagram", "address" => "http://facebook.com"]]);
            $address = json_encode(['Saraipara, Pahartali, Chittagong']);
            DB::table('institute_info')->insert(["institute_name" => "Test School", "institute_motto" => "To Leave A Legacy", "institute_shortform" => "TS", "institute_phonenumbers" => $numbers, "social_media" => $social, "institute_address" => $address, "institute_email" => "imtiajrex@gmail.com", "institute_logo" => "logo.png"]);
        }

        $data = '[{"name":"View Role","parent_controller":"Role","parent_group":"Settings"},{"name":"Create Role","parent_controller":"Role","parent_group":"Settings"},{"name":"Delete Role","parent_controller":"Role","parent_group":"Settings"},{"name":"Update Role","parent_controller":"Role","parent_group":"Settings"},{"name":"View User","parent_controller":"User","parent_group":"Settings"},{"name":"Create User","parent_controller":"User","parent_group":"Settings"},{"name":"Delete user","parent_controller":"User","parent_group":"Settings"},{"name":"Update User","parent_controller":"User","parent_group":"Settings"},{"name":"View Religion","parent_controller":"Religion","parent_group":"Settings"},{"name":"Create Religion","parent_controller":"Religion","parent_group":"Settings"},{"name":"Update Religion","parent_controller":"Religion","parent_group":"Settings"},{"name":"Delete Religion","parent_controller":"Religion","parent_group":"Settings"},{"name":"View Session","parent_controller":"Session","parent_group":"Settings"},{"name":"Create Session","parent_controller":"Session","parent_group":"Settings"},{"name":"Update Session","parent_controller":"Session","parent_group":"Settings"},{"name":"Delete Session","parent_controller":"Session","parent_group":"Settings"},{"name":"View Department","parent_controller":"Department","parent_group":"Settings"},{"name":"Create Department","parent_controller":"Department","parent_group":"Settings"},{"name":"Update Department","parent_controller":"Department","parent_group":"Settings"},{"name":"Delete Department","parent_controller":"Department","parent_group":"Settings"},{"name":"View GPA","parent_controller":"GPA","parent_group":"Settings"},{"name":"Create GPA","parent_controller":"GPA","parent_group":"Settings"},{"name":"Update GPA","parent_controller":"GPA","parent_group":"Settings"},{"name":"Delete GPA","parent_controller":"GPA","parent_group":"Settings"},{"name":"View Grade","parent_controller":"Grade","parent_group":"Settings"},{"name":"Create Grade","parent_controller":"Grade","parent_group":"Settings"},{"name":"Update Grade","parent_controller":"Grade","parent_group":"Settings"},{"name":"Delete Grade","parent_controller":"Grade","parent_group":"Settings"},{"name":"View Subject","parent_controller":"Subject","parent_group":"Settings"},{"name":"Create Subject","parent_controller":"Subject","parent_group":"Settings"},{"name":"Update Subject","parent_controller":"Subject","parent_group":"Settings"},{"name":"Delete Subject","parent_controller":"Subject","parent_group":"Settings"},{"name":"View Class","parent_controller":"Class","parent_group":"Settings"},{"name":"Create Class","parent_controller":"Class","parent_group":"Settings"},{"name":"Update Class","parent_controller":"Class","parent_group":"Settings"},{"name":"Delete Class","parent_controller":"Class","parent_group":"Settings"},{"name":"View PaymentCategory","parent_controller":"PaymentCategory","parent_group":"Settings"},{"name":"Create PaymentCategory","parent_controller":"PaymentCategory","parent_group":"Settings"},{"name":"Update PaymentCategory","parent_controller":"PaymentCategory","parent_group":"Settings"},{"name":"Delete PaymentCategory","parent_controller":"PaymentCategory","parent_group":"Settings"},{"name":"View InstituteInfo","parent_controller":"InstituteInfo","parent_group":"Settings"},{"name":"Update InstituteInfo","parent_controller":"InstituteInfo","parent_group":"Settings"},{"name":"View Permission","parent_controller":"Permission","parent_group":"Settings"},{"name":"View Assigned Subject","parent_controller":"Subject Assignment","parent_group":"Settings"},{"name":"Assign Subject","parent_controller":"Subject Assignment","parent_group":"Settings"},{"name":"View Assigned Department","parent_controller":"Department Assignment","parent_group":"Settings"},{"name":"Assign Department","parent_controller":"Department Assignment","parent_group":"Settings"}]';


        $data = json_decode($data);
        foreach ($data as $permission) {
            if (Permission::where("name", $permission->name)->first() != null) {
                continue;
            }
            Permission::create([
                "name" => $permission->name,
                "parent_controller" => $permission->parent_controller,
                "parent_group" => $permission->parent_group,
                "guard_name" => "web"
            ]);
        }

        if (Role::where("name", 'Super Admin')->first() == null) {
            Role::create(["name" => "Super Admin"]);
        }

        if (User::where("username", 'imtiajrex')->first() == null) {
            User::create([
                "name" => "Imtiaj",
                "username" => "imtiajrex",
                "user_type" => "admin",
                "password" => Hash::make(123456)
            ]);
            $user = User::where("username", 'imtiajrex')->first();
            $user->assignRole("Super Admin");
        }
    }
}
