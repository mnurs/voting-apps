<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
  
class LogController extends Controller
{ 

	public function log()
    { 
    	// Log data string debug
    	Log::debug("Ini adalah log debug");
    	
    	// Log data JSON debug
    	$log = [
    		"message" => "Ini adalah log debug",
    		"status" => true
    	];
    	Log::debug(json_encode($log));


    	// Log data string info
    	Log::info("Ini adalah log info");

    	// Log data JSON info
    	$log = [
    		"message" => "Ini adalah log info",
    		"status" => true
    	];
    	Log::info(json_encode($log));

    	// Log data string notice
    	Log::notice("Ini adalah log notice");

    	// Log data JSON notice
    	$log = [
    		"message" => "Ini adalah log notice",
    		"status" => true
    	];
    	Log::notice(json_encode($log));

    	// Log data string warning
    	Log::warning("Ini adalah log warning");

    	// Log data JSON warning
    	$log = [
    		"message" => "Ini adalah log warning",
    		"status" => true
    	];
    	Log::warning(json_encode($log));

    	// Log data string error
    	Log::error("Ini adalah log error");

    	// Log data JSON error
    	$log = [
    		"message" => "Ini adalah log error",
    		"status" => true
    	];
    	Log::error(json_encode($log));

    	// Log data string critical
    	Log::critical("Ini adalah log critical");

    	// Log data JSON critical
    	$log = [
    		"message" => "Ini adalah log critical",
    		"status" => true
    	];
    	Log::critical(json_encode($log));

    	// Log data string alert
    	Log::alert("Ini adalah log alert");

    	// Log data JSON alert
    	$log = [
    		"message" => "Ini adalah log alert",
    		"status" => true
    	];
    	Log::alert(json_encode($log));

    	// Log data string emergency
    	Log::emergency("Ini adalah log emergency");

    	// Log data JSON emergency
    	$log = [
    		"message" => "Ini adalah log emergency",
    		"status" => true
    	];
    	Log::emergency(json_encode($log));

    	return "selesai";
    }
}