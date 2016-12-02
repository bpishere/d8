<?php
namespace Drupal\d8training\Plugin\Block;
namespace Drupal\d8training;

use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;

class OpenWeatherForecaster
{
  private $config;
  private $client;

  public function __construct(ConfigFactory $config, Client $client)
  {
    $this->config = $config;
    $this->client =$client;
  }

  public function fetchWeatherData($city_name)
  {
    $app_id = $this->config->get('d8training.config')->get('app_id');
    //return '-----Helloooo---'. $app_id .'----'. $city_name;
    //$app_id = '2ae6e13f8875b87d47454e897e6da198';
//    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city_name&appid=$app_id";
//    $res = $this->client->request('GET', $url);
//    print 'url--' .$url;
//    dsm($res->getBody()); exit;
      //$json_data= Json::decode ($res->getBody()->getContents());
      $json_data = '{"coord":{"lon":72.85,"lat":19.01},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"base":"stations","main":{"temp":304.15,"pressure":1011,"humidity":58,"temp_min":304.15,"temp_max":304.15},"wind":{"speed":5.1,"deg":310},"clouds":{"all":12},"dt":1480582800,"sys":{"type":1,"id":7770,"message":0.0079,"country":"IN","sunrise":1480555548,"sunset":1480595390},"id":1275339,"name":"Mumbai","cod":200}';
      //dsm(json_decode ($json_data)); exit;
      return json_decode ($json_data, true);
  }




}
