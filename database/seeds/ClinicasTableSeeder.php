<?php

use Illuminate\Database\Seeder;

class ClinicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pt_BR');

        for ($i = 0; $i < 100; $i++) {
            $location = $this->getLocation([-18.910327, -48.266320], 5000);
            $address = $this->getAddressFromLocation($location);
            
            App\Clinica::create([
                'nome' => $faker->company,
                'endereco' => $address,
                'lat' => $location[0],
                'lng' => $location[1],
                'foto' => 'img/clinicas/clinica' . rand(1, 19) . '.jpg' 
            ]);
        }
    }

    public function getLocation($point, $radius) {

        $x0 = $point[0];
        $y0 = $point[1];

        // Convert radius from meters to degrees
        $radiusInDegrees = $radius/111000;

        $u = $this->getRand0_1();
        $v = $this->getRand0_1();
        $w = $radiusInDegrees * sqrt($u);
        $t = 2 * pi() * $v;
        $x = $w * cos($t);
        $y = $w * sin($t);

        // Adjust the x-coordinate for the shrinking of the east-west distances
        $new_x = $x/cos($y0);

        $foundLongitude = $new_x + $x0;
        $foundLatitude = $y + $y0;

        return [$foundLongitude, $foundLatitude];
    }
    
    public function getRand0_1()
    {
        return (mt_rand()/mt_getrandmax());
    }

    public function getAddressFromLocation($location)
    {

        
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $location[0] . ',' . $location[1] . '&key=AIzaSyA6J7whdFiathMGxDwBgWsO24eu7e6S6JA';

        /* $options = [ */
        /*     'http' => [ */
        /*         'proxy' => 'proxy.ufu.br:3128', */
        /*         'request_fulluri' => true */
        /*     ] */
        /* ]; */

        /* $stream = stream_context_create($options); */
        /* $data = file_get_contents($url, false, $stream); */
        $data = file_get_contents($url);        
        $array = json_decode($data, true);


        if(!$this->checkStatus($array))
            return '';

        return $array['results'][0]['formatted_address'];
    }

    public function checkStatus($data)
    {
        return (isset($data) && $data['status'] == 'OK');
    }
}
