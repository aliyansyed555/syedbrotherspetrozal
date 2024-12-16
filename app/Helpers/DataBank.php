<?php


if(!function_exists('get_company')){
    function get_company($user){
        if ($user->hasRole('client_admin')) {
            return $user->company;  
        } elseif ($user->hasRole('manager')) {
            return $user->teamMembers->first()->company; 
        }
        return null;  
    }
} 
if(!function_exists('get_fuel_types')){
    function get_fuel_types($company) {
        // $company = get_company($user);
        if ($company) {
            return $company->fuelTypes;
        }
        return []; 
    }
} 

if(!function_exists('get_fuel_types_with_tanks')){
    function get_fuel_types_with_tanks($pump) {
        return $pump->tanks()->with('fuelType')->get()->pluck('fuelType')->unique();
    }
} 
