<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

class ScraperController extends Controller
{
    
    public function scrape()
    {
        // configure the browser options
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);

        // navigate to the website
        $driver->get('https://ararat.greenlightopm.com/search-register?deptName=Planning&ApplicationNo=&status=&ApplicationType=TownPlanning&Address=');
        //$element = $driver->findElement(WebDriverBy::id('ApplicationNo'));
        $a = $driver->findElements(WebDriverBy::id('ApplicationNo'))->getAttribute('class');
        echo $a;
        
        

    

        // close the browser
        $driver->quit();
    }
}
