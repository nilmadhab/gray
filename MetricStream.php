<?php

require_once ("simple_html_dom.php");
require_once ("AbstractWebGsScraper2.php");

class MetricStream extends AbstractWebGsScraper2 {

	static private $pageSize = 100;
	
	private $page = 0;
	
	private $lastJobKey = 0;
	
	function __construct($url, $username="", $password="") {
		parent::__construct($url, $username, $password); //initialize parent constructor
		$this->setScrapperName(__CLASS__); //set ScraperName
	}
	
	private function clean($string) {
      //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string=preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    $string=str_replace('-',' ',$string);
    $string=str_replace('nbsp',' ', $string);                  
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	public function parseJobList() {
		
		$parsedURLs = array();
		
		$running = true;
		
		do {
			
			$content = $this->getNextPageContent();
			
			$urls = $this->extractJobURLs($content);

			if (count($urls) == 0) {
				break;
			}
			
			foreach($urls as $url) {
				$url = preg_replace('/(;jsessionid=.*)(\?)/', '$2', $url);
				
				if (in_array($url, $parsedURLs)) {
					$running = false;
					break;
				}
				$this->setJobToList($url);
				$parsedURLs[] = $url;
			}
		}while(!$running);
	}
	
	public function loadJobDetails($url) {

		echo "<br>here**********************************";
		
		$this->curl->setOpt(CURLOPT_FOLLOWLOCATION, 1);
		$this->curl->get($url);
		
		$content = $this->curl->getResponse();
		
		$dom = str_get_html($content);
		
		$title1 = $dom->getElementById('jdDiv')->find('div');
		$loc = $title1[2]->find('span');

		// foreach($loc as $t)
		// 	echo "ELEMTN <br> ".$t."<br>"; 
		
		if ($title1 === null) {
		 	return;
		}

		$title = $title1[1]->innertext;
		$city = $title1[2]->find('span')[2]->innertext; echo "<br>city ".$city ;
		$state = "Karnataka";
		

		$snippet = $title1[4]->plaintext; echo "<br> SNIPPET ".$snippet ;
		//$snippet = $content[5]->plaintext;
		//$snippet = $this->clean($snippet);
		



		// foreach($title as $a)
		// {
		// 	echo "h1".$a ; 
		// }
		
		// $title = $table[3];

		// $table = $dom->find('span');
		// $table1 = $dom->find('div');

		// $location = explode(', ',$table[34]); 
		// $city = $location[0]; 
		// $state = $location[1];

		// $content = $table[19];
		// $temp = $content->find('p'); 
	
		// if($temp)
		// 	$snippet = $temp[0];
		// else
		// {
		// 	$snippet = "working on";
		// 	// echo "<p style='color:red'> heteregtre</p>" ;
		// 	// $content = $table[12];
		// 	// //$location = explode('<br><br>',$content); 
		// 	// echo $content;
		// 	// $a = 0 ;
		// 	// foreach ($table1 as $key) {
		// 	// 	echo "content --".$a." >".$key ;
		// 	// 	$a++;
		 	// }
		// } 

		 $this->lastJobKey++;
		 $key = $this->lastJobKey;
		 $company = 'Metricstream';
		 $country = 'INDIA';
	
		$this->setJobToList($url, $key, $title, $snippet, $city, $state, $country, date('Y-m-d'), $company);
	}
	
	private function extractJobURLs($content) {
		$dom = str_get_html($content);

		$a = $dom->find('a');

		$k = 0 ; 
		foreach($a as $aa)
		{
			if($k > 10 && $k%2== 1)
			{
				if($aa->getAttribute('href') == "#")
					break;
				//echo "<br>link ".$k."-->".$aa ;
				$urls[] = $aa->getAttribute('href');
			}
			$k++;
		}

		// $i = 0;
		// $urls = array();
		// foreach($b as $ch) {
		// 	if($i > 3)
		// 	{
		// 		if($ch->getAttribute('href'))
		// 			$urls[] = "http://www.eliassen.com".$ch->getAttribute('href');
		// 	}
		// 	$i++;
		// }
		//print_r($urls); 
		return $urls;
	}
	
	private function getNextPageContent() {
		$url = $this->url;

		if ($this->page > 0) {
			$url .= '&act=next&rowFrom='.(($this->page - 1) * self::$pageSize);
		}
		
		$this->curl->get($url);
		
		$content = $this->curl->getResponse();

		return $content;
	}
	
}