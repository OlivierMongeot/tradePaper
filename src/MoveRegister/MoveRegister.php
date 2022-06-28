<?php

namespace App\MoveRegister;

class MoveRegister
{
    public function recordInfo($message)
    {
        // get path of var log symfony app
        $path = dirname(__FILE__).'\move_register.log';
      
        $file = fopen($path, 'a');
        // dd($path);
        
        $dateTime = new \DateTime('now');
        // Set Datetime London
        $dateTime->setTimezone(new \DateTimeZone('Europe/London'));
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        fwrite($file, $dateTime . ' : ' . $message . "\n");
        fclose($file);
    }
    
      
    
}