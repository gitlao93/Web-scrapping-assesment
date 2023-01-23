<?php

namespace App\Http\Controllers;


use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Illuminate\Http\Request;

class ScrapperWebsiteController extends Controller{

    public function scrape(){
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

        $driver->get('https://ararat.greenlightopm.com/search-register?deptName=Planning&ApplicationNo=&status=&ApplicationType=TownPlanning&Address=');

        // $form = $driver->findElement(
        //     WebDriverBy::cssSelector('form#SearchForm')
        // );

        
        //Find the <a> tag on the page
        $aTag = $driver->findElement(
            WebDriverBy::id('LastMonth')
        );

        $driver->executeScript("arguments[0].click();", array($aTag));
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::id('DataTables_Table_0_wrapper')
            )
        );

        // Find the table element
        $table = $driver->findElement(
            WebDriverBy::id('DataTables_Table_0')
        );
        
        
        // Find the tbody element within the table
        $tbody = $table->findElement(WebDriverBy::cssSelector('tbody'));
       
        // Find the rows within the tbody
        $rows = $tbody->findElements(WebDriverBy::cssSelector('tr'));
       
        // Initialize an empty array to store the data
        $data = [];

        foreach($rows as $row){
                // get the cells within the row
            $cells = $row->findElements(WebDriverBy::cssSelector('td'));
            
            $rowData = [];
            // loop through the cells
            foreach($cells as $cell){
                // get the cell text
                $cellText = $cell->getText();
                // add the cell text to the row data
                $rowData[] = $cellText;
            }
            // add the row data to the overall data array
            $data[] = $rowData;
        }
        // print the data
        print_r($data);
        
        // quit the driver
        $driver->quit();

    }
}
